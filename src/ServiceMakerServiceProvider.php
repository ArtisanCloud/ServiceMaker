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

            $this->commands([
                ServiceMakerCommand::class,
            ]);
        }
    }
}
