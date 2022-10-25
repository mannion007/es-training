<?php

declare(strict_types=1);

namespace Tests\Model;

use Mannion007\EventSourcingTraining\Model\Account;
use Mannion007\EventSourcingTraining\Model\AccountOpened;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class AccountOpeningTest extends TestCase
{
    /**
     * @test
     */
    public function accounts_can_be_opened(): void
    {
        $events = (Account::open())->popRecordedEvents();

        Assert::assertCount(1, $events);

        Assert::assertInstanceOf(AccountOpened::class, $events[0]);
    }
}
