<?php

declare(strict_types=1);

namespace Mannion007\EventSourcingTraining\Model;

use Mannion007\EventSourcingTraining\Common\UniversallyUniqueIdentifier;

final class AccountId
{
    use UniversallyUniqueIdentifier;

    public function equals(AccountId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
