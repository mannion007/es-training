<?php

declare(strict_types=1);

namespace Tests\Model;

use Lendable\EventSourcingTraining\Common\Event;
use Lendable\EventSourcingTraining\Model\Account;
use Lendable\EventSourcingTraining\Model\DepositMade;
use Lendable\EventSourcingTraining\Model\InsufficientFunds;
use Lendable\EventSourcingTraining\Model\WithdrawalMade;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Tests\Support\AccountContext;

final class WithdrawalTest extends TestCase
{
    /**
     * @test
     */
    public function available_funds_can_be_withdrawn(): void
    {
        $account = Account::open();

        $context = new AccountContext($account);

        $context
            ->given(new DepositMade(Money::GBP(100)))
            ->when(fn(Account $a) => $a->makeWithdrawal(Money::GBP(100)))
            ->then(
                fn(Event $e) => \assert($e instanceof WithdrawalMade)
                    && $e->amount->equals(Money::GBP(100))
            );
    }

    /**
     * @test
     */
    public function withdrawals_cannot_exceed_available_funds(): void
    {
        $context = new AccountContext(Account::open());

        $context
            ->given(new DepositMade(Money::GBP(100)))
            ->expectException(InsufficientFunds::class)
            ->when(fn(Account $a) => $a->makeWithdrawal(Money::GBP(101)));
    }
}
