<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('webApi', function($data, $status = 200) use ($factory) {

            $response = [
                'success' => ($status === 200 || $status === 201 ? true : false),
                'data' => $data
            ];
            
            return $factory->json($response, $status);

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
