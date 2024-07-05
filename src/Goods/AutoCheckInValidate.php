<?php

namespace Mattoid\StoreAutoCheckIn\Goods;

use Carbon\Carbon;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Exception\PermissionDeniedException;
use Flarum\User\User;
use Mattoid\Store\Goods\Validate;
use Mattoid\Store\Model\StoreCartModel;
use Mattoid\Store\Model\StoreModel;
use Flarum\Foundation\ValidationException;
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

        // 签到卡在有效期内不允许重复购买
        $storeCart = StoreCartModel::query()->where('user_id', $user->id)->where('code', $store->code)
            ->where('status', 1)->where(function($where) use ($settings) {
                $where->where(function($where) use ($settings) {
                    $where->where('type', 'limit')->where('outtime', '>=', Carbon::now()->tz($settings->get('mattoid-store.storeTimezone', 'Asia/Shanghai')));
                });
                $where->orWhere('type', 'permanent');
            })->first();
        if ($storeCart) {
            throw new ValidationException(['message' => $translator->trans('mattoid-store.forum.error.cannot-purchase-repeatedly')]);
        }

        return true;
    }
}
