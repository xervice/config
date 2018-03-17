<?php


namespace Xervice\Config;


class XerviceConfig
{
    /**
     * @var \Xervice\Config\XerviceConfig
     */
    static $instance;

    /**
     * @var \Xervice\Config\XerviceConfigFactory
     */
    private $factory;

    /**
     * XerviceConfig constructor.
     *
     * @param \Xervice\Config\XerviceConfigFactory $factory
     */
    public function __construct(\Xervice\Config\XerviceConfigFactory $factory)
    {
        $this->factory = $factory;
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
     */
    public function getConfig()
    {
        $parser = $this->factory->createParser();
        $environment = $this->factory->createEnvironment();

        $configDir = realpath(getcwd() . '/config/');

        $parser->parseFile($configDir . '/config_default.php');
        $parser->parseFile($configDir . '/config_' . $environment->getEnvironment() . '.php');
        $parser->parseFile($configDir . '/config_local.php');

        return $this->factory->getConfigContainer();
    }


}