<?php

namespace Unforgivencl\LaraChileanCongress;

use Unforgivencl\LaraChileanCongress\CongressApi\ApiRequest;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LaraChileanCongressServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 */
	public function register()
	{
		$this->app->singleton('Unforgivencl\LaraChileanCongress\CongressApi\ApiRequest', function () {
			return new ApiRequest(new Client());
		});
	}
}
