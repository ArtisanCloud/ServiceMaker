<?php


use ArtisanCloud\ServiceMaker\Console\Commands\ServiceMakerCommand as SMSkelegon;


return [

    // you can use this config var to turn some folders off as you need
    'skelegon' => [
        // config/
        SMSkelegon::FOLDER_CONFIG => true,

        // resources/
        SMSkelegon::FOLDER_RESOURCE => true,

        // database/
        SMSkelegon::FOLDER_DATABASE => true,
        // database/factories/
        SMSkelegon::FOLDER_FACTORY => true,
        // database/migrations/
        SMSkelegon::FOLDER_MIGRATION => true,
        // database/seeds/
        SMSkelegon::FOLDER_SEED => true,

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
        SMSkelegon::FOLDER_MODEL => true,
        // src/Models/Drivers/
        SMSkelegon::FOLDER_DRIVER => true,
        // src/Models/Channels/
        SMSkelegon::FOLDER_CHANNEL => true,
    ]
];

