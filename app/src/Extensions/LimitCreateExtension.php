<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;

/**
 * Blocks creation once a maximum number of records of the owner's class already exist.
 * Use `LimitCreateExtension(0)` (or no args) to forbid creation entirely (e.g. for records
 * only ever added via populate/import), or `LimitCreateExtension(1)` for singleton pages/models.
 *
 * @extends Extension<object>
 */
class LimitCreateExtension extends Extension
{
    private int $limit;

    public function __construct(int $limit = 0)
    {
        parent::__construct();
        $this->limit = $limit;
    }

    /**
     * @param Member|null $member The member being checked.
     * @param array $context Additional context
     */
    public function extendCanCreate($member, $context = []): ?bool
    {
        $className = $this->getOwner()->ClassName;

        return ($className::get()->count() >= $this->limit) ? false : null;
    }
}
