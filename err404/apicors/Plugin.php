<?php

namespace Err404\ApiCors;

use System\Classes\PluginBase;
use Err404\ApiCors\Http\Middlewares\HandleCorsHeaders;

class Plugin extends PluginBase
{
    public $elevated = true;
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'ApiCors',
            'description' => 'No description provided yet...',
            'author' => 'Err404',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $this->app['Illuminate\Contracts\Http\Kernel']->prependMiddleware(HandleCorsHeaders::class);
    }
}
