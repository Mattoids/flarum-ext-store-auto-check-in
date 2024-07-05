<?php

namespace Mattoid\StoreAutoCheckIn\Console;

use Flarum\Foundation\Paths;
use Illuminate\Console\Scheduling\Event;
use Flarum\Settings\SettingsRepositoryInterface;

class PublishSchedule
{
    public function __invoke(Event $event) {
        $settings = resolve(SettingsRepositoryInterface::class);
        $settingTimezone = $settings->get('mattoid-store.storeTimezone', 'Asia/Shanghai');

        // 设置时间
//        $event->everyMinute()->withoutOverlapping()->timezone($settingTimezone);
        $event->dailyAt('00:10')->withoutOverlapping()->timezone($settingTimezone);

        $paths = resolve(Paths::class);
        $event->appendOutputTo($paths->storage.(DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'mattoid-store-auto-check-in.log'));
    }
}
