### Service Maker is a convenient tool to quickly generate your service folder.

The Skeleton looks like this:

* app/Services/{Object}Service
    * ./Contracts
        * {Object}ServiceContract.php
    * ./Providers
        * {Object}ServiceProvider.php
    * ./Facades
        * {Object}Service.php
    * ./Models
    * ./Databases
    * ./Drivers
    * ./Channels
    * {Object}Service.php

Please run "composer require" command to include this package.
> composer require artisan-cloud/service-maker --dev

we recommend using "--dev" as your development tool.
