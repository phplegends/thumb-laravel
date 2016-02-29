<?php 

namespace PHPLegends\ThumbLaravel;

use Illuminate\Support\ServiceProvider;

use PHPLegends\ThumbLaravel\Commands\ClearCommand;

class ThumbServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */

	public function boot()
	{
		$this->package('phplegends/thumb-laravel', 'thumb');

		$this->commands('thumb.clear');
	}


	public function register()
	{
		$this->app->bind('thumb', function ($app)
		{
			return new Thumb($app);
		});

		$this->app->bind('thumb.clear', function ()
		{
			return new ClearCommand;		
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
