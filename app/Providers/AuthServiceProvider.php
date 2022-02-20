<?php

namespace App\Providers;

use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('Api-Token')) {
                $api_token = $request->header('Api-Token');

                if ($api_token === env('API_TOKEN')) {
                    return new GenericUser(['id' => 1, 'name' => 'Taylor']);
                }
            }
        });
    }
}
