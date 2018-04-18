<?php


namespace Xervice\Config;


use Xervice\Config\XerviceConfigFactory;

class XerviceConfig
{
    const APPLICATION_PATH = 'APPLICATION_PATH';

    const ADDITIONAL_CONFIG_FILES = 'ADDITIONAL_CONFIG_FILES';

    /**
     * @var \Xervice\Config\XerviceConfig
     */
    static $instance;

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
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self(new XerviceConfigFactory());
        }
        return self::$instance;
    }

    /**
     * @return \Xervice\Config\Container\ConfigContainer
     * @throws \Xervice\Config\Exception\FileNotFound
     */
    public function getConfig()
    {
        return $this->factory->getConfigContainer();
    }

    /**
     * @param string $file
     *
     * @throws \Xervice\Config\Exception\FileNotFound
     */
    private function parseFileIfExist(string $file)
    {
        if (file_exists($file)) {
            $this->parser->parseFile($file);
        }
    }

    private function init(): void
    {
        $environment = $this->factory->createEnvironment();
        $rootPath = getenv('APPLICATION_PATH') ?: getcwd();
        $configDir = $rootPath . '/config/';

        $this->parseFileIfExist($configDir . '/config_default.php');
        $this->parseFileIfExist($configDir . '/config_' . $environment->getEnvironment() . '.php');
        $this->parseFileIfExist($configDir . '/config_local.php');

        $additionalFiles = $this->getConfig()->get(self::ADDITIONAL_CONFIG_FILES, []);
        if ($additionalFiles) {
            foreach ($additionalFiles as $file) {
                $this->parseFileIfExist($file);
            }
        }

        $this->factory->getConfigContainer()->set(self::APPLICATION_PATH, $rootPath);
    }


}