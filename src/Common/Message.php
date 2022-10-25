<?php

declare(strict_types=1);

namespace Mannion007\EventSourcingTraining\Common;

interface Message
{
    public function name(): string;

    /**
     * @return array<string, string>
     */
    public function payload(): array;

    public function version(): int;
}
