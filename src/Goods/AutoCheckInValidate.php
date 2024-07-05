<?php

namespace Mattoid\StoreAutoCheckIn\Goods;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Exception\PermissionDeniedException;
use Flarum\User\User;
use Mattoid\Store\Goods\Validate;
use Mattoid\Store\Model\StoreModel;
use Symfony\Contracts\Translation\TranslatorInterface;

class AutoCheckInValidate extends Validate
{
    public static function validate(User $user, StoreModel $store, $params)
    {
        $settings = resolve(SettingsRepositoryInterface::class);
        $translator = resolve(TranslatorInterface::class);

        if (!$user->can('mattoid-store-auto-check-in.group-view') || !$user->can('checkin.allowCheckIn', $user)) {
            throw new PermissionDeniedException();
        }

        return true;
    }
}
