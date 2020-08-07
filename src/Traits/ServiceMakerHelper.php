<?php

namespace ArtisanCloud\ServiceMaker\Traits;

use ArtisanCloud\ServiceMaker\Console\Commands\ServiceMakerCommand;
use Illuminate\Support\Facades\File;

trait ServiceMakerHelper
{
    public function formatServiceName(string $argName): string
    {

        $strServiceName = ucfirst($argName);
        if (!preg_match("/Service$/", $strServiceName)) {
            $strServiceName .= "Service";
        }
        return $strServiceName;
    }

    public function createServiceSkeleton(string $strServiceName, array $arraySubFolders): string
    {
        // pre-setup service folder parent location
        $strServiceFolder = $this->getServiceFolder($strServiceName);

        // create service folder
        $bResult = $this->createServiceFolder($strServiceFolder);
        if (!$bResult) exit(-1);

        // create service subfolders
        $this->createServiceSubFolder($strServiceFolder, $arraySubFolders);

        return $strServiceFolder;
    }

    public function createServiceFolder(string $strServiceFolder): bool
    {
        $bResult = File::exists($strServiceFolder);
        // create service path
        if (!$bResult) {
            $this->warn("ready to create folder:{$strServiceFolder}");
            $bResult = File::makeDirectory($strServiceFolder, 0755, true);
            if ($bResult) {
                $this->info("success to creat folder:{$strServiceFolder}");
            } else {
                $this->error("failed to creat folder:{$strServiceFolder}");
            }
        }

        return $bResult;
    }

    public function createServiceSubFolder(string $strCurrentFolder, array $arrayFolders): bool
    {
        $bResult = false;

        // load config and set arrayRequiredFolders
        $arrayConfig = $this->loadConfigFile();
        $arrayRequiredFolders = $arrayConfig['skelegon'];
        foreach ($arrayFolders as $key => $strFolderName) {
            $arraySubFolders = null;
            if (is_array($strFolderName)) {
                // this folder has sub folders too.
                $arraySubFolders = $strFolderName;

                // use key as this folder name, defined in const array.
                $strFolderName = $key;
            }

            // check if user want to generate this folder in config file
            $bRequireFoler = $arrayRequiredFolders[$strFolderName] ?? false;
            if ($bRequireFoler) {
                $strThisFolder = $strCurrentFolder . DIRECTORY_SEPARATOR . $strFolderName;
                $bResult = $this->createServiceFolder($strThisFolder);
                if (!$bResult) exit(-1);
                // recursively to create sub folders
                if (!is_null($arraySubFolders)) {
                    $bResult = $this->createServiceSubFolder($strThisFolder, $arraySubFolders);
                }
            }
        }

        return $bResult;
    }


    public function getServiceNameSpace(string $strServiceName): string
    {
        $strPublishNamespace = $this->getPublishedServiceNamespace();
        // check if user use their own namespace in config file
        if (is_null($strPublishNamespace)) {
            // use default namespace
            return $this->getDefaultServiceNamespace($strServiceName);
        }
        return $strPublishNamespace;

    }

    protected function getServiceFolder(string $strServiceName): string
    {
        $strServicePath = $this->getPublishedServicePath();
        if (is_null($strServicePath)) {
            $strServicePath = $this->getDefaultServicePath();
        }else{
            $strServicePath = base_path($strPublishServicePath);
        }
        $strServicePath .=  DIRECTORY_SEPARATOR . $strServiceName;

        return $strServicePath;
    }

    protected function getDefaultConfigFile()
    {
        return __DIR__ . '/../../' . self::FOLDER_CONFIG . '/servicemaker.php';
    }

    protected function getPublishedServicePath(): ?string
    {
        return config('servicemaker.service_path');
    }

    protected function getDefaultServicePath(): string
    {
        return app_path('Services');
    }

    protected function getPublishedServiceNamespace(): ?string
    {
        return config('servicemaker.namespace');

    }

    protected function getDefaultServiceNamespace(string $strServiceName): string
    {
        return 'App\Services\\'.$strServiceName.'\src';
    }

    protected function getStub(string $class): string
    {
        return File::get(__DIR__ . "/../Console/stubs/{$class}.stub");
    }


    protected function loadConfigFile()
    {
        $arrayPublishConfig = config('servicemaker');
        if (is_null($arrayPublishConfig)) {
            $strDefaultConfigFile = $this->getDefaultConfigFile();
            $arrayPublishConfig = require $strDefaultConfigFile;

            return $arrayPublishConfig;
        }
        return $arrayPublishConfig;
    }

    public function saveServiceTemplateToFile(string $serviceTemplate, string $filePath, string $strTemplateName): bool
    {
        $bResult = false;

        if (File::exists($filePath)) {
            $this->error("{$filePath} already exist!");
            exit(-1);
        } else {

            $strFileDirectory = dirname($filePath);
            if ($this->createServiceFolder($strFileDirectory)) {
                $bResult = File::put($filePath, $serviceTemplate);
                if ($bResult) {
                    $this->info("generated {$strTemplateName} at {$filePath}.");
                } else {
                    $this->error("Failed to generate {$strTemplateName} at {$filePath}.");
                }
            } else {
                $this->error("{$filePath}parent folder not exist!");

            }


        }

        return $bResult;
    }


}
