<?php

namespace Mattoid\StoreAutoCheckIn\Goods;

use Flarum\User\User;
use Mattoid\Store\Goods\After;
use Mattoid\Store\Model\StoreModel;

class AutoCheckInAfter extends After
{

    public static function after(User $user, StoreModel $store, $params) {
        return true;
    }
}
