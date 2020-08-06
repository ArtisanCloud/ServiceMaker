### "Service Maker" is a convenient tool to quickly generate your service folder.
#### When you meet the scenario that you want to have a service folder including all code in business logic boundary.

Artisan-Cloud team develop this package for the usage above.

#### Install this pacakge:
Please run "composer require" command to include this package.
~~~
 composer require artisan-cloud/service-maker --dev
~~~

we recommend using "--dev" as your development tool.

#### The Skeleton of folder generated from "Service Maker" looks like this:

        self::FOLDER_RESOURCE,
        self::FOLDER_DATABASE => [
            self::FOLDER_FACTORY,
            self::FOLDER_MIGRATION
        ],
        self::FOLDER_SOURCE => [
            self::FOLDER_CONTRACT,
            self::FOLDER_PROVIDER,
            self::FOLDER_FACADE,
            self::FOLDER_MODEL,
            self::FOLDER_DRIVER,
            self::FOLDER_CHANNEL,
        ],

* {app/Services}/{Object}Service
    * config/
    * database/
        * factories/
        * migrations/
        * seeds/
    * resources/    
    * src/
        * Console/
        * Exceptions/
        * Http/
            * Controllers/
            * Middleware/
        * Contracts/
            * {Object}ServiceContract.php
        * Providers/
            * {Object}ServiceProvider.php
        * Facades/
            * {Object}Service.php
        * Models/
        * Drivers/
        * Channels/
    * {Object}Service.php

{app/Services} is the default root folder.
 Also it can be customized by: 
 ~~~~
 php artisan service:make ObjectService --path {your/custom/paht}
~~~~

You can also replase the {Object}Service with your Service Name, like UserService.

