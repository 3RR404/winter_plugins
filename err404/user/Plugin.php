<?php

namespace Err404\User;

use Backend;
use Err404\User\Providers\AuthServiceProvider;
use Err404\User\Providers\JWTAuthServiceProvider;
use System\Classes\PluginBase;

/**
 * User Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.User', 'RainLab.UserPlus',  'RainLab.Location', 'RainLab.Notify'];

	/**
	 * Returns information about this plugin.
	 *
	 * @return array
	 */
	public function pluginDetails()
	{
		return [
			'name'        => 'User',
			'description' => 'No description provided yet...',
			'author'      => 'Err404',
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
		$this->app->register(AuthServiceProvider::class);
		$this->app->register(JWTAuthServiceProvider::class);
	}

	/**
	 * Boot method, called right before the request route.
	 *
	 * @return array
	 */
	public function boot()
	{

	}

}
