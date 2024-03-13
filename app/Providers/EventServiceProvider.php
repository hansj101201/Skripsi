<?php

namespace App\Providers;

use App\Models\menu;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Str;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $menuList = Menu::orderBy("MENU_URUTAN")->get();
            foreach ($menuList as $menu) {
                /**
                 *  Tambah Header, hanya jika nama menu header tersebut, belum pernah terdaftar dalam key menu-menu yang sudah ditambahkan ssebelumnya
                 */
                if (!$event->menu->itemKeyExists($menu->MENU_GROUP)) {
                    $event->menu->add([
                        'key' => $menu->MENU_GROUP,
                        'header' => Str::upper($menu->MENU_GROUP),
                    ]);
                }

                if ($menu->MENU_SUBMENU == "") {
                    $key = Str::lower(Str::replace(" ", "_", $menu->MENU_GROUP . "_" . $menu->MENU_SUBGROUP));

                    $temp = [
                        'key' => $key,
                        'text' => $menu->MENU_SUBGROUP,
                    ];

                    if (Str::contains($menu->MENU_ICON, "fas")) {
                        $temp['icon'] = $menu->MENU_ICON;
                    } else {
                        $temp['icon_color'] = $menu->MENU_ICON;
                    }

                    if ($menu->MENU_URL !== "") {
                        $temp['url'] = $menu->MENU_URL;
                    } else {
                        $temp['submenu'] = [];
                    }
                    $event->menu->add($temp);
                } else {
                    $keyParent = Str::lower(Str::replace(" ", "_", $menu->MENU_GROUP . "_" . $menu->MENU_SUBGROUP));

                    $key = Str::lower(Str::replace(" ", "_", $keyParent . "_" . $menu->submenu));

                    $temp = [
                        'key' => $key,
                        'text' => $menu->MENU_SUBMENU,
                    ];

                    if (Str::contains($menu->MENU_ICON, "fas")) {
                        $temp['icon'] = $menu->MENU_ICON;
                    } else {
                        $temp['icon_color'] = $menu->MENU_ICON;
                    }

                    $temp['url'] = $menu->MENU_URL;

                    $event->menu->addIn($keyParent,$temp);
                }
            }
        });

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
