### "Service Maker" is a convenient tool to quickly generate your service folder.
#### When you meet the scenario that you want to have a service folder including all code in business logic boundary.
Artisan-Cloud team develop this package for the usage above.

The Skeleton of folder generated from "Service Maker" looks like this:

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
