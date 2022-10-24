<?php

declare(strict_types=1);

namespace Lendable\EventSourcingTraining\Model;

use Lendable\EventSourcingTraining\Common\Event;
use Money\Money;

final class Account
{
    private int $version = 1;

    /**
     * @var Event[]
     */
    private array $recordedEvents = [];

    private AccountId $id;

    private Money $availableBalance;

    private function __construct()
    {
        $this->availableBalance = Money::GBP(0);
    }

    public static function open(): self
    {
        $instance = new self();

        $instance->recordThat(new AccountOpened(AccountId::generate()));

        return $instance;
    }

    public function makeDeposit(Money $deposit): void
    {
        $this->recordThat(new DepositMade($deposit));
    }

    public function makeWithdrawal(Money $withdrawal): void
    {
        if ($withdrawal->greaterThan($this->availableBalance)) {
            throw new InsufficientFunds();
        }

        $this->recordThat(new WithdrawalMade($withdrawal));
    }

    private function whenAccountOpened(AccountOpened $event): void
    {
        $this->id = $event->id;
    }

    private function whenDepositMade(DepositMade $event): void
    {
        $this->availableBalance = $this->availableBalance->add($event->amount);
    }

    private function whenWithdrawalMade(WithdrawalMade $event): void
    {
        $this->availableBalance = $this->availableBalance->subtract($event->amount);
    }

    public function recordThat(Event $event): void
    {
        $this->version++;
        $this->recordedEvents[] = $event;
        $this->apply($event);
    }

    private function apply(Event $event): void
    {
        $method = sprintf('when%s', $event->name());

        if (\is_callable([$this, $method])) {
            $this->{$method}($event);
        }
    }

    /**
     * @return Event[]
     */
    public function popRecordedEvents(): array
    {
        $recordedEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recordedEvents;
    }

    public function id(): AccountId
    {
        return $this->id;
    }
}
