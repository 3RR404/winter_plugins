<?php

namespace Err404\Shoping\Classes\Event;

use Backend;

class BackendMenuHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        return;

        $obEvent->listen('backend.menu.extendItems', function($obManager) {
            $this->addMenuItems($obManager);
        });
    }

    public function addMenuItems(Backend\Classes\NavigationManager $manager)
    {
        $manager->addSideMenuItems('Err404.Shoping', 'shoping-menu-custom-dimension', [
            'custom-dimension' => [
                'label'         => 'err404.shoping::lang.menu.custom_dimensions',
                'icon'          => 'icon-pencil',
                'owner'         => 'Err404.Shoping',
                'url'           => Backend::url('err404/shoping/customdimension'),
                'permissions'   => ['err404-menu-customdimension'],
                'order'         => 100,
            ],
        ]);
    }
}
