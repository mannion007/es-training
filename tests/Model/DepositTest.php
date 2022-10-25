<?php

declare(strict_types=1);

namespace Tests\Model;

use Mannion007\EventSourcingTraining\Common\Event;
use Mannion007\EventSourcingTraining\Model\Account;
use Mannion007\EventSourcingTraining\Model\DepositMade;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Tests\Support\AccountContext;

final class DepositTest extends TestCase
{
    /**
     * @test
     */
    public function deposits_can_be_made(): void
    {
        $context = new AccountContext(Account::open());

        $context
            ->when(fn(Account $a) => $a->makeDeposit(Money::GBP(100)))
            ->then(
                fn(Event $e) => \assert($e instanceof DepositMade)
                    && $e->amount->equals(Money::GBP(100))
            );
    }
}
