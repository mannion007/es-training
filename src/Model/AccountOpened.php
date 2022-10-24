<?php

declare(strict_types=1);

namespace Lendable\EventSourcingTraining\Model;

use Lendable\EventSourcingTraining\Common\Event;

final class AccountOpened implements Event
{
    public readonly \DateTimeImmutable $occurredAt;

    public function __construct(public readonly AccountId $id)
    {
        $this->occurredAt = new \DateTimeImmutable('now');
    }

    public function name(): string
    {
        return "AccountOpened";
    }

    public function payload(): array
    {
        return [
            'id' => $this->id->toString(),
        ];
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function version(): int
    {
        return 1;
    }
}
