<?php

declare(strict_types=1);

namespace Lendable\EventSourcingTraining\Common;

interface Event extends Message
{
    public function occurredAt(): \DateTimeImmutable;
}
