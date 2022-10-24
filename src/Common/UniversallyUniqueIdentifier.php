<?php

declare(strict_types=1);

namespace Lendable\EventSourcingTraining\Common;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait UniversallyUniqueIdentifier
{
    private UuidInterface $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    final public function __toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @return static
     */
    final public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @return static
     */
    final public static function fromString(string $id)
    {
        return new static(Uuid::fromString($id));
    }

    final public static function fromBinaryString(string $id): self
    {
        return new static(Uuid::fromBytes($id));
    }

    final public function toString(): string
    {
        return $this->uuid->toString();
    }

    final public function toBinary(): string
    {
        return $this->uuid->getBytes();
    }
}
