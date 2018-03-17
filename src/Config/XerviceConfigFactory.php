<?php


namespace Xervice\Config;


use Xervice\Config\Container\ConfigContainer;
use Xervice\Config\Environment\Environment;
use Xervice\Config\Parser\Parser;

class XerviceConfigFactory
{
    /**
     * @var ConfigContainer
     */
    private $configContainer;

    /**
     * @return \Xervice\Config\Container\ConfigContainer
     */
    public function getConfigContainer()
    {
        if ($this->configContainer === null) {
            $this->configContainer = new ConfigContainer();
        }
        return $this->configContainer;
    }

    /**
     * @return \Xervice\Config\Parser\Parser
     */
    public function createParser()
    {
        return new Parser(
            $this->getConfigContainer()
        );
    }

    /**
     * @return \Xervice\Config\Environment\Environment
     */
    public function createEnvironment()
    {
        return new Environment();
    }
}