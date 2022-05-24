<?php namespace Err404\Location;

use Backend;
use Err404\Location\Classes\Extend\CountryExtend;
use System\Classes\PluginBase;

/**
 * location Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'location',
            'description' => 'RainLab Location extension',
            'author'      => 'err404',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Err404\Location\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'err404.location.some_permission' => [
                'tab' => 'location',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'location' => [
                'label'       => 'location',
                'url'         => Backend::url('err404/location/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['err404.location.*'],
                'order'       => 500,
            ],
        ];
    }
}
