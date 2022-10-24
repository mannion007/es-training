<?php

declare(strict_types=1);

namespace Tests\Support;

use Lendable\EventSourcingTraining\Common\Event;

final Class EventStream
{
    /**
     * @param array<Event> $events
     */
    private function __construct(private array $events)
    {
    }

    /**
     * @param array<Event> $events
     */
    public static function create(array $events): self
    {
        return new self($events);
    }

    /**
     * @template T of Event
     * @param class-string<T> $eventClass
     * @return T
     */
    public function mostRecentOfType(string $eventClass): Event
    {
        $eventsOfType = $this->ofType($eventClass);

        if ($eventsOfType === []) {
            throw new \Exception(\sprintf('No event of type %s found', $eventClass));
        }

        return \current($eventsOfType);
    }

    /**
     * @template T of Event
     * @param class-string<T> $eventClass
     * @return array<T>
     */
    public function ofType(string $eventClass): array
    {
        return \array_filter(\array_reverse($this->events), static fn ($event): bool => $event instanceof $eventClass);
    }

    /**
     * @template T of Event
     * @param class-string<T> $eventClass
     */
    public function hasEventOfType(string $eventClass): bool
    {
        $eventsOfType = \array_filter(
            \array_reverse($this->events),
            static fn ($event): bool => $event instanceof $eventClass,
        );

        return $eventsOfType !== [];
    }
}
