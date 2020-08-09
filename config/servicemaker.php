<?php


use ArtisanCloud\ServiceMaker\Console\Commands\ServiceMakerCommand as SMSkelegon;


return [


    /**
     * Override default service path
     * Please use relative path from project root directory,  base_path();
     * If null, the default value app_path('Services') will return
     */
    'service_path' => null,

    /**
     * Override default name space
     * Please conform the namespace to PSR-4
     * If null, the default value "App\Services" will return
     */
    'namespace' => null,


    /**
     * you can use this config var to turn some folders off as you need
     */
    'skelegon' => [
        // config/
        SMSkelegon::FOLDER_CONFIG => true,

        // resources/
        SMSkelegon::FOLDER_RESOURCE => true,

        // database/
        SMSkelegon::FOLDER_DATABASE => false,
        // database/factories/
        SMSkelegon::FOLDER_FACTORY => false,
        // database/migrations/
        SMSkelegon::FOLDER_MIGRATION => false,
        // database/seeds/
        SMSkelegon::FOLDER_SEED => false,

        // src/
        SMSkelegon::FOLDER_SOURCE => true,
        // src/Console/
        SMSkelegon::FOLDER_CONSOLE => true,
        // src/Exceptions/
        SMSkelegon::FOLDER_EXCEPTION => true,
        // src/Http/
        SMSkelegon::FOLDER_HTTP => true,
        // src/Http/Controllers/
        SMSkelegon::FOLDER_CONTROLLER => true,
        // src/Http/Middleware/
        SMSkelegon::FOLDER_MIDDLEWARE => true,

        // src/Contracts/
        SMSkelegon::FOLDER_CONTRACT => true,
        // src/Providers/
        SMSkelegon::FOLDER_PROVIDER => true,
        // src/Facades/
        SMSkelegon::FOLDER_FACADE => true,
        // src/Models/
        SMSkelegon::FOLDER_MODEL => false,
        // src/Models/Drivers/
        SMSkelegon::FOLDER_DRIVER => true,
        // src/Models/Channels/
        SMSkelegon::FOLDER_CHANNEL => true,
    ]
];

