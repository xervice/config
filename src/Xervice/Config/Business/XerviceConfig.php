<?php
declare(strict_types=1);


namespace Xervice\Config\Business;


use Xervice\Config\Business\Container\ConfigContainer;

class XerviceConfig
{
    public const APPLICATION_PATH = 'APPLICATION_PATH';

    public const ADDITIONAL_CONFIG_FILES = 'ADDITIONAL_CONFIG_FILES';

    /**
     * @var \Xervice\Config\Business\XerviceConfig
     */
    private static $instance;

    /**
     * @var \Xervice\Config\Business\ConfigBusinessFactory
     */
    private $factory;

    /**
     * @var \Xervice\Config\Business\Parser\Parser
     */
    private $parser;

    /**
     * XerviceConfig constructor.
     *
     * @param \Xervice\Config\Business\ConfigBusinessFactory $factory
     */
    public function __construct(ConfigBusinessFactory $factory)
    {
        $this->factory = $factory;
        $this->parser = $this->factory->createParser();
        $this->init();
    }

    /**
     * @return \Xervice\Config\Business\XerviceConfig
     */
    public static function getInstance(): XerviceConfig
    {
        if (self::$instance === null) {
            self::$instance = new self(new ConfigBusinessFactory());
        }
        return self::$instance;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function get(string $key)
    {
        return self::getInstance()->getConfig()->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Xervice\Config\Business\Container\ConfigContainer
     */
    public static function set(string $key, $value)
    {
        return self::getInstance()->getConfig()->set($key, $value);
    }

    /**
     * @return \Xervice\Config\Business\Container\ConfigContainer
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
        $rootPath = $this->getRootPath();
        $configDir = $this->getConfigPath($rootPath);

        $this->parseFileIfExist($configDir . '/config_default.php');
        $this->parseFileIfExist($configDir . '/config_' . $environment->getEnvironment() . '.php');
        $this->parseFileIfExist(
            $configDir . '/config_' . $environment->getEnvironment() . '_' . $environment->getScope() . '.php'
        );
        $this->parseFileIfExist($configDir . '/config_local.php');

        $this->parseAdditionalFiles();

        $this->factory->getConfigContainer()->set(self::APPLICATION_PATH, $rootPath);
    }

    /**
     * @return string
     */
    private function getRootPath(): string
    {
        return getenv('APPLICATION_PATH') ?: getcwd();
    }

    /**
     * @param string $rootPath
     *
     * @return string
     */
    private function getConfigPath(string $rootPath): string
    {
        return getenv('CONFIG_PATH') ?: $rootPath . '/config/';
}

    private function parseAdditionalFiles(): void
    {
        $additionalFiles = $this->getConfig()->get(self::ADDITIONAL_CONFIG_FILES, []);

        if (\is_array($additionalFiles)) {
            foreach ($additionalFiles as $file) {
                $this->parseFileIfExist($file);
            }
        }
    }
}
