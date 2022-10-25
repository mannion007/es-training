<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use Mannion007\EventSourcingTraining\Infrastructure\Persistence\AccountRepositoryInMemory;
use Mannion007\EventSourcingTraining\Model\Account;
use Mannion007\EventSourcingTraining\Model\AccountId;
use Mannion007\EventSourcingTraining\Model\AccountRepository;
use Mannion007\EventSourcingTraining\Model\NoAccountOfId;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class AccountRepositoryInMemoryTest extends TestCase
{
    private AccountRepository $accountRepository;

    protected function setUp(): void
    {
        $this->accountRepository = new AccountRepositoryInMemory();
    }

    /**
     * @test
     */
    public function an_account_can_be_persisted(): void
    {
        $account = Account::open();

        $this->accountRepository->save($account);

        $retrieved = $this->accountRepository->ofId($account->id());

        Assert::assertTrue($retrieved->id()->equals($account->id()));
    }

    /**
     * @test
     */
    public function retrieval_with_an_unknown_account_id_is_exceptional(): void
    {
        $this->expectException(NoAccountOfId::class);

        $this->accountRepository->ofId(AccountId::generate());
    }
}
