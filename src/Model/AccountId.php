<?php

declare(strict_types=1);

namespace Lendable\EventSourcingTraining\Model;

use Lendable\EventSourcingTraining\Common\UniversallyUniqueIdentifier;

final class AccountId
{
    use UniversallyUniqueIdentifier;

    public function equals(AccountId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
