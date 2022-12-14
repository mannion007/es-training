<?php

declare(strict_types=1);

namespace Mannion007\EventSourcingTraining\Common;

interface Event extends Message
{
    public function occurredAt(): \DateTimeImmutable;
}
