<?php

declare(strict_types=1);

namespace Tests\Support;

use Lendable\EventSourcingTraining\Common\Event;
use Lendable\EventSourcingTraining\Model\Account;
use PHPUnit\Framework\Assert;

final class AccountContext
{
    /**
     * @var class-string<\Throwable> $expected
     */
    private ?string $expected = null;

    private ?\Throwable $caught = null;

    public function __construct(private Account $account)
    {
        $this->account->popRecordedEvents();
    }

    public function given(Event $event): self
    {
        $this->account->recordThat($event);
        $this->account->popRecordedEvents();

        return $this;
    }

    /**
     * @param class-string<\Throwable> $expected
     */
    public function expectException(string $expected): self
    {
        $this->expected = $expected;

        return $this;
    }

    /**
     * @param callable(Account): void $callable
     */
    public function when($callable): self
    {
        if ($this->expected !== null)
        {
            try {
                $callable($this->account);
            } catch (\Throwable $t) {
                $this->caught = $t;
            } finally {
                Assert::assertInstanceOf($this->expected, $this->caught);

                return $this;
            }
        }

        $callable($this->account);

        return $this;
    }

    /**
     * @param callable(Event): bool $callable
     */
    public function then(callable $callable): void
    {
        $recordedEvents = $this->account->popRecordedEvents();

        Assert::assertCount(1, $recordedEvents);

        Assert::assertTrue($callable($recordedEvents[0]));
    }
}
