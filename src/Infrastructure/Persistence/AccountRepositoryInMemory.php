<?php

declare(strict_types=1);

namespace Mannion007\EventSourcingTraining\Infrastructure\Persistence;

use Mannion007\EventSourcingTraining\Common\Event;
use Mannion007\EventSourcingTraining\Model\Account;
use Mannion007\EventSourcingTraining\Model\AccountId;
use Mannion007\EventSourcingTraining\Model\AccountRepository;
use Mannion007\EventSourcingTraining\Model\NoAccountOfId;

final class AccountRepositoryInMemory implements AccountRepository
{
    /**
     * @var array<string, array<Event>>
     */
    private array $eventStreamsByAccountId = [];

    public function ofId(AccountId $id): Account
    {
        $key = $id->toString();

        if (!isset($this->eventStreamsByAccountId[$key])) {
            throw new NoAccountOfId();
        }

        return Account::reconstitute($this->eventStreamsByAccountId[$key]);
    }

    public function save(Account $account): void
    {
        $key = $account->id()->toString();

        $this->eventStreamsByAccountId[$key] = $account->popRecordedEvents();
    }
}
