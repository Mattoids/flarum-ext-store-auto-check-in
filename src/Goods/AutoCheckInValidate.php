<?php

namespace Mattoid\StoreAutoCheckIn\Goods;

use Flarum\User\Exception\PermissionDeniedException;
use Flarum\User\User;
use Mattoid\Store\Goods\Validate;
use Mattoid\Store\Model\StoreModel;

class AutoCheckInValidate extends Validate
{
    public static function validate(User $user, StoreModel $store, $params)
    {
        if (!$user->can('mattoid-store-auto-check-in.group-view') || !$user->can('checkin.allowCheckIn', $user)) {
            throw new PermissionDeniedException();
        }

        return true;
    }
}
