<?php
declare(strict_types=1);


namespace Xervice\Config;


use Xervice\Config\Container\ConfigContainer;

class XerviceConfig
{
    public const APPLICATION_PATH = 'APPLICATION_PATH';

    public const ADDITIONAL_CONFIG_FILES = 'ADDITIONAL_CONFIG_FILES';

    /**
     * @var \Xervice\Config\XerviceConfig
     */
    private static $instance;

    /**
     * @var \Xervice\Config\XerviceConfigFactory
     */
    private $factory;

    /**
     * @var \Xervice\Config\Parser\Parser
     */
    private $parser;

    /**
     * XerviceConfig constructor.
     *
     * @param \Xervice\Config\XerviceConfigFactory $factory
     */
    public function __construct(XerviceConfigFactory $factory)
    {
        $this->factory = $factory;
        $this->parser = $this->factory->createParser();
        $this->init();
    }

    /**
     * @return \Xervice\Config\XerviceConfig
     */
    public static function getInstance(): XerviceConfig
    {
        if (self::$instance === null) {
            self::$instance = new self(new XerviceConfigFactory());
        }
        return self::$instance;
    }

    /**
     * @return \Xervice\Config\Container\ConfigContainer
     */
    public function getConfig(): ConfigContainer
    {
        return $this->factory->getConfigContainer();
    }

    /**
     * @param string $file
     */
    private function parseFileIfExist(string $file): void
    {
        $this->parser->parseFile($file);
    }

    private function init(): void
    {
        $environment = $this->factory->createEnvironment();
        $rootPath = getenv('APPLICATION_PATH') ?: getcwd();
        $configDir = $rootPath . '/config/';

        $this->parseFileIfExist($configDir . '/config_default.php');
        $this->parseFileIfExist($configDir . '/config_' . $environment->getEnvironment() . '.php');
        $this->parseFileIfExist($configDir . '/config_local.php');

        $additionalFiles = (array) $this->getConfig()->get(self::ADDITIONAL_CONFIG_FILES, []);
        if ($additionalFiles) {
            foreach ($additionalFiles as $file) {
                $this->parseFileIfExist($file);
            }
        }

        $this->factory->getConfigContainer()->set(self::APPLICATION_PATH, $rootPath);
    }
}
