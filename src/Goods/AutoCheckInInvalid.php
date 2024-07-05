<?php

namespace Mattoid\StoreAutoCheckIn\Goods;

use Mattoid\Store\Goods\Invalid;
use Mattoid\Store\Model\StoreCartModel;
use Mattoid\Store\Model\StoreModel;

class AutoCheckInInvalid extends Invalid
{
    public static function invalid(StoreModel $store, StoreCartModel $cart) {
        return true;
    }
}
