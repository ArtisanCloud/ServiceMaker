<?php

namespace ArtisanCloud\ServiceMaker\Console\Commands;

use ArtisanCloud\ServiceMaker\Traits\ServiceMakerHelper;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;


class ServiceMakerCommand extends Command
{
    use ServiceMakerHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:make {serviceName} {--s|simple} {--m|model} {--d|driver} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'service:make {serviceName}';

    public string $strServiceName;
    public string $strServicePath;
    public string $strServiceNamespace;
    public string $strModel;

    const FOLDER_CONFIG = 'config';
    const FOLDER_RESOURCE = 'resources';
    const FOLDER_DATABASE = 'databases';
    const FOLDER_FACTORY = 'factories';
    const FOLDER_MIGRATION = 'migrations';
    const FOLDER_SEED = 'seeds';
    const FOLDER_SOURCE = 'src';
    const FOLDER_CONSOLE = 'Console';
    const FOLDER_EXCEPTION = 'Exceptions';
    const FOLDER_HTTP = 'Http';
    const FOLDER_CONTROLLER = 'Controllers';
    const FOLDER_MIDDLEWARE = 'Middleware';
    const FOLDER_CONTRACT = 'Contracts';
    const FOLDER_PROVIDER = 'Providers';
    const FOLDER_FACADE = 'Facades';
    const FOLDER_MODEL = 'Models';
    const FOLDER_DRIVER = 'Drivers';
    const FOLDER_CHANNEL = 'Channels';


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
        $this->strServicePath = $this->createServiceSkeleton($this->strServiceName, $this->getServiceSkelegon());
        $this->strServiceNamespace = $this->getServiceNameSpace($this->strServiceName);
        $this->strModel = $this->getModel($this->strServiceName);

        $this->generateContract();
        $this->generateService();
        $this->generateServiceProvider();
        $this->generateFacade();
        $this->generateConfig();
        if ($this->option('model')) {
            $this->generateModel();
            $this->generateMigration();
            $this->generateFactory();
        }

//        $this->option('path') ? null : $this->generateDriver();

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
        $serviceTemplate = $this->generateContentFromStub($templateName);

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
        $serviceTemplate = $this->generateContentFromStub($templateName);

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
        $serviceTemplate = $this->generateContentFromStub($templateName);

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
        $serviceTemplate = $this->generateContentFromStub($templateName);

        $filePath = $this->getServiceFacadeFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }

    /**
     * generate facade.
     *
     * @return bool
     */
    public function generateConfig()
    {
        $templateName = 'Config';
        $serviceTemplate = $this->generateContentFromStub($templateName);

        $filePath = $this->getServiceConfigFile();
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
        $templateName = 'Model';
        $serviceTemplate = $this->generateContentFromStub($templateName);

        $filePath = $this->getServiceModelFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }

    /**
     * generate migration.
     *
     * @return bool
     */
    protected function generateMigration()
    {
        $templateName = 'Migration';
        $serviceTemplate = $this->generateContentFromStub($templateName);

        $filePath = $this->getServiceMigrationFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
    }

    /**
     * generate factory.
     *
     * @return bool
     */
    protected function generateFactory()
    {
        $templateName = 'Factory';
        $serviceTemplate = $this->generateContentFromStub($templateName);

        $filePath = $this->getServiceFactoryFile();
        $bResult = $this->saveServiceTemplateToFile($serviceTemplate, $filePath, $templateName);

        return $bResult;
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
            . DIRECTORY_SEPARATOR . self::FOLDER_SOURCE
            . DIRECTORY_SEPARATOR . self::FOLDER_CONTRACT
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}Contract.php";
    }

    protected function getServiceFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_SOURCE
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}.php";
    }

    protected function getServiceProviderFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_SOURCE
            . DIRECTORY_SEPARATOR . self::FOLDER_PROVIDER
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}Provider.php";
    }

    protected function getServiceFacadeFile(): string
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_SOURCE
            . DIRECTORY_SEPARATOR . self::FOLDER_FACADE
            . DIRECTORY_SEPARATOR . "{$this->strServiceName}.php";
    }

    protected function getServiceConfigFile()
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_CONFIG
            . DIRECTORY_SEPARATOR . Str::lower("{$this->strModel}.php");
    }

    protected function getServiceModelFile()
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_SOURCE
            . DIRECTORY_SEPARATOR . self::FOLDER_MODEL
            . DIRECTORY_SEPARATOR . "{$this->strModel}.php";
    }

    protected function getServiceMigrationFile()
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_DATABASE
            . DIRECTORY_SEPARATOR . self::FOLDER_MIGRATION
            . DIRECTORY_SEPARATOR . "create_" . Str::lower($this->strModel) . "_table.php";
    }

    protected function getServiceFactoryFile()
    {
        return $this->strServicePath
            . DIRECTORY_SEPARATOR . self::FOLDER_DATABASE
            . DIRECTORY_SEPARATOR . self::FOLDER_FACTORY
            . DIRECTORY_SEPARATOR . "{$this->strModel}Factory.php";
    }

    protected function getServiceSkelegon(): array
    {
        return [
            self::FOLDER_CONFIG,
            self::FOLDER_DATABASE => [
                self::FOLDER_FACTORY,
                self::FOLDER_MIGRATION,
                self::FOLDER_SEED,
            ],
            self::FOLDER_RESOURCE,
            self::FOLDER_SOURCE => [
                self::FOLDER_CONSOLE,
                self::FOLDER_EXCEPTION,
                self::FOLDER_HTTP => [
                    self::FOLDER_CONTROLLER,
                    self::FOLDER_MIDDLEWARE,
                ],
                self::FOLDER_CONTRACT,
                self::FOLDER_PROVIDER,
                self::FOLDER_FACADE,
                self::FOLDER_MODEL,
                self::FOLDER_DRIVER,
                self::FOLDER_CHANNEL,
            ],
        ];
    }
}
