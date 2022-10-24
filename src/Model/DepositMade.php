<?php

declare(strict_types=1);

namespace Lendable\EventSourcingTraining\Model;

use Lendable\EventSourcingTraining\Common\Event;
use Money\Money;

final class DepositMade implements Event
{
    public readonly \DateTimeImmutable $occurredAt;

    public function __construct(public readonly Money $amount)
    {
        $this->occurredAt = new \DateTimeImmutable('now');
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function name(): string
    {
        return "DepositMade";
    }

    public function payload(): array
    {
        return [
            'amount' => $this->amount->getAmount(),
            'currency' => $this->amount->getCurrency()->getCode(),
        ];
    }

    public function version(): int
    {
        return 1;
    }
}
