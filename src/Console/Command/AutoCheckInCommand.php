<?php

namespace Mattoid\StoreAutoCheckIn\Console\Command;

use Carbon\Carbon;
use Flarum\Console\AbstractCommand;
use Flarum\User\User;
use Mattoid\Store\Model\StoreCartModel;
use Mockery\Exception;
use Symfony\Contracts\Translation\TranslatorInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Cache\Repository;
use Flarum\User\Event\Saving;

class AutoCheckInCommand extends AbstractCommand
{
    protected $events;
    protected $settings;

    private $storeTimezone = 'Asia/Shanghai';

    public function __construct(SettingsRepositoryInterface $settings, TranslatorInterface $translator, Repository $cache, Dispatcher $events) {
        parent::__construct();
        $this->cache = $cache;
        $this->events = $events;
        $this->settings = $settings;
        $this->translator = $translator;

        $storeTimezone = $this->settings->get('mattoid-store.storeTimezone', 'Asia/Shanghai');
        $this->storeTimezone = !!$storeTimezone ? $storeTimezone : 'Asia/Shanghai';
    }

    protected function configure()
    {
        $this->setName('mattoid:store:auto:check:in')->setDescription('Auto Check In');
    }

    protected function fire()
    {
        $datetime = Carbon::now()->tz($this->storeTimezone);
        $cartList = StoreCartModel::query()->where('outtime', '>=', $datetime)->where('status', 1)->where('code', 'autoCheckIn')->groupBy('user_id')->get();

        foreach ($cartList as $cart) {
            $user = User::query()->where('id',$cart->user_id)->first();
            try {
                $data = [
                    'id' => $user->id,
                    'type' => 'users',
                    'attributes' => [
                        'canCheckin' => false,
                        'totalContinuousCheckIn' => $user->total_checkin_count
                    ]
                ];
                $this->events->dispatch(new Saving($user, $user, $data));

                $user->save();
            } catch (\Exception $e) {
                $this->error($this->translator->trans('mattoid-store-auto-check-in.forum.error.auto-check-in-fail', ['username' => $user->username, 'message' => $e->getMessage()]));
            }
        }
    }


}
