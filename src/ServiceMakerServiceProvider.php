<?php

namespace ArtisanCloud\ServiceMaker;

use ArtisanCloud\ServiceMaker\Console\Commands\ServiceMakerCommand;
use Illuminate\Support\ServiceProvider;

class ServiceMakerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        //
        if ($this->app->runningInConsole()) {
            // publish config file

            if ($this->app->runningInConsole()) {

                $this->publishes([
                    __DIR__ . '/../'.ServiceMakerCommand::FOLDER_CONFIG.'/servicemaker.php' => "/../" . config_path('servicemaker.php'),
                ], 'Service-Maker');

                $this->commands([
                    ServiceMakerCommand::class,
                ]);
            }

        }
    }
}
