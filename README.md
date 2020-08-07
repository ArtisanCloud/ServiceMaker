[Quick Guide](https://github.com/ArtisanCloud/ServiceMaker/wiki/Quick-Guide)

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


### Config your customized service structure
After installation, Please publish pacakge:

 ~~~~
 php artisan vendor:publish

 Which provider or tag's files would you like to publish?:
  [0 ] Publish files from all providers and tags listed below
  [1 ] Provider: ArtisanCloud\ServiceMaker\ServiceMakerServiceProvider
  [2 ] Provider: Facade\Ignition\IgnitionServiceProvider
  ...
~~~~
Input 1 as prompt list, and Enter <return>:
~~~
> 1
Copied File [{project/root/}}/vendor/artisan-cloud/ServiceMaker/config/servicemaker.php] To [/config/servicemaker.php]
Publishing complete.
~~~


### Config your customized service structure

Now you can check the config file where located in 
~~~
"/config/servicemaker.php"
~~~

---------------------------

You can trigger(true/false) these folders name to customized your generate structure as you want.
~~~
return [

    // you can use this config var to turn some folders off as you need
    'skelegon' => [
        // config/
        SMSkelegon::FOLDER_CONFIG => false,

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
        SMSkelegon::FOLDER_EXCEPTION => false,
        // src/Http/
        SMSkelegon::FOLDER_HTTP => true,
        // src/Http/Controllers/
        SMSkelegon::FOLDER_CONTROLLER => false,
        // src/Http/Middleware/
        SMSkelegon::FOLDER_MIDDLEWARE => false,

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
        SMSkelegon::FOLDER_CHANNEL => false,
    ]
];
~~~

---------------------------
Now you can run this command:
~~~~
 php artisan service:make ObjectService
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases/factories
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases/factories
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases/migrations
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases/migrations
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases/seeds
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/databases/seeds
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/resources
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/resources
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Console
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Console
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Http
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Http
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Contracts
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Contracts
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Providers
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Providers
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Facades
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Facades
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Models
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Models
ready to create folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Drivers
success to creat folder:/private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Drivers
generated ServiceContract at /private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Contracts/ObjectServiceContract.php.
generated Service at /private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/ObjectService.php.
generated ServiceProvider at /private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Providers/ObjectServiceProvider.php.
generated ServiceFacade at /private/var/www/html/PackageDevelopment/app/Services/ObjectService/src/Facades/ObjectService.php.
~~~~

The default Service folders is located in: 
~~~
/app/Services/
~~~

Here is the service sub folders and php files you want.

![Image of Yaktocat](https://cdn.jsdelivr.net/gh/ArtisanCloud/PackageResource/ServiceMaker/guide-result.jpeg)


---------------------------

Also it can be customized by: 
~~~~
 php artisan service:make ObjectService --path {your/custom/path}
~~~~

You can also replase the {Object}Service with your Service Name, like UserService.





