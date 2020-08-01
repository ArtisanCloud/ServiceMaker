<?php

namespace ArtisanCloud\ServiceMaker\Console\Commands;

use ArtisanCloud\ServiceMaker\Traits\ServiceMakerHelper;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;


class ServiceMakerCommand extends Command
{
    use ServiceMakerHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:make {serviceName} {--M|model} {--D|driver} {--path=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'service:make {serviceName} --path={custom path}';

    public string $strServiceName;
    public string $strServicePath;
    public string $strServiceNamespace;

    const FOLDER_CONTRACT = 'Contracts';
    const FOLDER_PROVIDERS = 'Providers';
    const FOLDER_FACADE = 'Facades';
    const FOLDER_MODELS = 'Models';
    const FOLDER_DATABASES = 'Databases';
    const FOLDER_DRIVERS = 'Drivers';
    const FOLDER_CHANNELS = 'Channels';
    const ARRAY_FOLDER = [
        self::FOLDER_CONTRACT,
        self::FOLDER_PROVIDERS,
        self::FOLDER_FACADE,
        self::FOLDER_MODELS,
        self::FOLDER_DATABASES,
        self::FOLDER_DRIVERS,
        self::FOLDER_CHANNELS,
    ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
//        dd($this->arguments());
//        dd($this->options());

        $this->strServiceName = $this->formatServiceName($this->argument('serviceName'));
        $arraySubFolder = ServiceMakerCommand::ARRAY_FOLDER;
        $this->strServicePath = $this->createServiceSkeleton($this->strServiceName, $arraySubFolder, $this->option('path'));
        $this->strServiceNamespace = $this->getNameSpace($this->strServiceName, $this->option('path'));

        $this->generateContract();
        $this->generateService();
        $this->generateServiceProvider();
        $this->generateFacade();
        $this->option('model') ? null : $this->generateModel();
        $this->option('path') ? null : $this->generateDriver();

        return 0;
    }


    /**
     * generate contract.
     *
     * @return bool
     */
    protected function generateContract(): bool
    {
        $templateName = 'ServiceContract';
        $serviceTemplate = str_replace(
            ["{{serviceName}}", "{{serviceNamespace}}"],
            [$this->strServiceName, $this->strServiceNamespace],
            $this->getStub($templateName)
        );

        $filePath = $this->getServiceContractFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }

    /**
     * generate service.
     *
     * @return bool
     */
    protected function generateService(): bool
    {
        $templateName = 'Service';
        $serviceTemplate = str_replace(
            ["{{serviceName}}", "{{serviceNamespace}}"],
            [$this->strServiceName, $this->strServiceNamespace],
            $this->getStub($templateName)
        );

        $filePath = $this->getServiceFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }

    /**
     * generate service provider.
     *
     * @return bool
     */
    protected function generateServiceProvider(): bool
    {
        $templateName = 'ServiceProvider';
        $serviceTemplate = str_replace(
            ["{{serviceName}}", "{{serviceNamespace}}"],
            [$this->strServiceName, $this->strServiceNamespace],
            $this->getStub($templateName)
        );

        $filePath = $this->getServiceProviderFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }


    /**
     * generate facade.
     *
     * @return bool
     */
    protected function generateFacade(): bool
    {
        $templateName = 'ServiceFacade';
        $serviceTemplate = str_replace(
            ["{{serviceName}}", "{{serviceNamespace}}"],
            [$this->strServiceName, $this->strServiceNamespace],
            $this->getStub($templateName)
        );

        $filePath = $this->getServiceFacadeFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }

    /**
     * generate model.
     *
     * @return bool
     */
    protected function generateModel(): bool
    {
        return true;
    }

    /**
     * generate driver.
     *
     * @return bool
     */
    protected function generateDriver(): bool
    {
        return true;
    }


    protected function getServiceContractFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_CONTRACT
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}Contract.php";
    }

    protected function getServiceFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}.php";
    }

    protected function getServiceProviderFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_PROVIDERS
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}ServiceProvider.php";
    }

    protected function getServiceFacadeFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_FACADE
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}.php";
    }
}
