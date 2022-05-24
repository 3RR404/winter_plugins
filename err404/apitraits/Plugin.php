<?php namespace Err404\Apitraits;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Apitraits',
            'description' => 'Trait Api extension',
            'author'      => 'Err404',
            'icon'        => 'icon-leaf'
        ];
    }
}
