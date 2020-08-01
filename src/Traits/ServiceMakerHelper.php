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

    public function createServiceSkeleton(string $strServiceName, array $arraySubFolder, string $customPath = null): string
    {
        // pre-setup service folder parent location
        if (isset($customPath)) {
            $strServiceFolder = $customPath . DIRECTORY_SEPARATOR . $strServiceName;
        } else {
            $strServiceFolder = $this->getDefaultServiceFolder() . DIRECTORY_SEPARATOR . $strServiceName;
        }

        // create service folder
        $bResult = $this->createServiceFolder($strServiceFolder);
        if(!$bResult)    exit(-1);

        // create service subfolders
        foreach ($arraySubFolder as $strFolderName) {
            $strFolder = $strServiceFolder.DIRECTORY_SEPARATOR.$strFolderName;
            $bResult = $this->createServiceFolder($strFolder);
            if(!$bResult)  exit(-1);
        }

        return $strServiceFolder;
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


    public function getNameSpace(string $strServiceName, string $strCustomizedPath = null): string
    {

        if (is_null($strCustomizedPath)) {
            return $this->getDefaultServiceNamespace();
        }


        $arrayArrayDir = File::directories();
        dd($arrayArrayDir);
        $namespace = new Namespace_();
        $namespace->addStmts($arrayArrayDir);

        $strNamespace = $namespace->getNode();
        return $strNamespace;
    }

    protected function getDefaultServiceFolder()
    {
        return app_path('Services');
    }

    protected function getDefaultServiceNamespace()
    {
        return 'App\Services';
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
