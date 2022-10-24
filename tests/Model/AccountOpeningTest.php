<?php

declare(strict_types=1);

namespace Tests\Model;

use Lendable\EventSourcingTraining\Model\Account;
use Lendable\EventSourcingTraining\Model\AccountOpened;
use PHPUnit\Framework\TestCase;
use Tests\Support\EventStream;

final class AccountOpeningTest extends TestCase
{
    /**
     * @test
     */
    public function accounts_can_be_opened(): void
    {
        $events = (Account::open())->popRecordedEvents();

        $this->assertCount(1, $events);

        $this->assertTrue(
            EventStream::create($events)->hasEventOfType(AccountOpened::class)
        );
    }
}
