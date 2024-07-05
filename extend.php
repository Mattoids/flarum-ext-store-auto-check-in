<?php

/*
 * This file is part of mattoid/flarum-ext-store-auto-check-in.
 *
 * Copyright (c) 2024 Mattoid.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */


use Flarum\Extend;
use Mattoid\Store\Extend\StoreExtend;
use Mattoid\StoreAutoCheckIn\Console\Command\AutoCheckInCommand;
use Mattoid\StoreAutoCheckIn\Console\PublishSchedule;
use Mattoid\StoreAutoCheckIn\Goods\AutoCheckInAfter;
use Mattoid\StoreAutoCheckIn\Goods\AutoCheckInGoods;
use Mattoid\StoreAutoCheckIn\Goods\AutoCheckInInvalid;
use Mattoid\StoreAutoCheckIn\Goods\AutoCheckInValidate;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),
    new Extend\Locales(__DIR__.'/locale'),

    (new StoreExtend('autoCheckIn'))
        ->addStoreGoods(AutoCheckInGoods::class)
        ->addValidate(AutoCheckInValidate::class)
        ->addAfter(AutoCheckInAfter::class)
        ->addInvalid(AutoCheckInInvalid::class),


    (new Extend\Console())
        ->command(AutoCheckInCommand::class)
        ->schedule(AutoCheckInCommand::class, new PublishSchedule()),
];
