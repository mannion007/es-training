<?php

declare(strict_types=1);

namespace Mannion007\EventSourcingTraining\Common;

interface Command extends Message
{
    public function issuedAt(): \DateTimeImmutable;
}
