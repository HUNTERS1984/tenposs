<?php
namespace Modules\Admin\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
	/**
	 * Register the Admin module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('Modules\Admin\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Admin module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('admin', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('admin', base_path('resources/views/vendor/admin'));
		View::addNamespace('admin', realpath(__DIR__.'/../Resources/Views'));
	}
}
