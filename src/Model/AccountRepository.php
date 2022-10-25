<?php

declare(strict_types=1);

namespace Mannion007\EventSourcingTraining\Model;

interface AccountRepository
{
    /**
     * @throws NoAccountOfId
     */
    public function ofId(AccountId $id): Account;

    public function save(Account $account): void;
}
