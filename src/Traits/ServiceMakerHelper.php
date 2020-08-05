<?php

namespace ArtisanCloud\ServiceMaker\Traits;

use ArtisanCloud\ServiceMaker\Console\Commands\ServiceMakerCommand;
use Illuminate\Support\Facades\File;
use PhpParser\Builder\Namespace_;

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

    public function createServiceSkeleton(string $strServiceName, array $arraySubFolders, string $customPath = null): string
    {
        // pre-setup service folder parent location
        $strServicePath = $this->getServicePath($strServiceName, $customPath);

        // create service folder
        $bResult = $this->createServiceFolder($strServicePath);
        if (!$bResult) exit(-1);

        // create service subfolders
        $this->createServiceSubFolder($strServicePath, $arraySubFolders);

        return $strServicePath;
    }

    public function createServiceFolder(string $strServicePath): bool
    {
        $bResult = File::exists($strServicePath);
        // create service path
        if (!$bResult) {
            $this->warn("ready to create folder:{$strServicePath}");
            $bResult = File::makeDirectory($strServicePath, 0755, true);
            if ($bResult) {
                $this->info("success to creat folder:{$strServicePath}");
            } else {
                $this->error("failed to creat folder:{$strServicePath}");
            }
        }

        return $bResult;
    }

    public function createServiceSubFolder($strCurrentFolder, array $arrayFolders): bool
    {
        $bResult = false;
        foreach ($arrayFolders as $key => $strFolderName) {
            $arraySubFolders = null;
            if (is_array($strFolderName)) {
                // this folder has sub folders too.
                $arraySubFolders = $strFolderName;

                // use key as this folder name, defined in const array.
                $strFolderName = $key;
            }

            $strThisFolder = $strCurrentFolder . DIRECTORY_SEPARATOR . $strFolderName;
            $bResult = $this->createServiceFolder($strThisFolder);
            if (!$bResult) exit(-1);
            // recursively to create sub folders
            if (!is_null($arraySubFolders)) {
                $bResult = $this->createServiceSubFolder($strThisFolder, $arraySubFolders);
            }
        }

        return $bResult;
    }


    public function getServiceNameSpace(string $strServiceName, string $strCustomizedPath = null): string
    {
        if (is_null($strCustomizedPath)) {
            return $this->getDefaultServiceNamespace();
        } else {
            return $this->getCustomServiceNamespace($strCustomizedPath);
        }
    }

    protected function getServicePath(string $strServiceName, string $customPath = null): string
    {
        if (isset($customPath)) {
            $strServicePath = $this->getCustomServicePath($customPath) . DIRECTORY_SEPARATOR . $strServiceName;
        } else {
            $strServicePath = $this->getDefaultServicePath() . DIRECTORY_SEPARATOR . $strServiceName;
        }
        return $strServicePath;
    }

    protected function getCustomServicePath(string $strCustomizedPath): string
    {
        return app_path($strCustomizedPath);
    }

    protected function getDefaultServicePath(): string
    {
        return app_path('Services');
    }

    protected function getDefaultServiceNamespace(): string
    {
        return 'App\Services';
    }

    protected function getCustomServiceNamespace(string $strCustomPath): string
    {
        return 'App' . '\\' . str_replace('/', '\\', $strCustomPath);
    }

    protected function getStub(string $class): string
    {
        return File::get(__DIR__ . "/../Console/stubs/{$class}.stub");
    }

    public function saveServiceTemplateToFile(string $serviceTemplate, string $filePath, string $strTemplateName): bool
    {
        $bResult = false;

        if (File::exists($filePath)) {
            $this->error("{$filePath} already exist!");
            exit(-1);
        } else {
            $bResult = File::put($filePath, $serviceTemplate);
            if ($bResult) {
                $this->info("generated {$strTemplateName} at {$filePath}.");
            } else {
                $this->error("Failed to generate {$strTemplateName} at {$filePath}.");
            }
        }

        return $bResult;
    }


}
