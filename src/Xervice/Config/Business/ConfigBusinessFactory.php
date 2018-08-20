<?php
declare(strict_types=1);


namespace Xervice\Config\Business;


use Xervice\Config\Business\Container\ConfigContainer;
use Xervice\Config\Business\Environment\Environment;
use Xervice\Config\Business\Parser\Parser;

class ConfigBusinessFactory
{
    /**
     * @var ConfigContainer
     */
    private $configContainer;

    /**
     * @return \Xervice\Config\Business\Container\ConfigContainer
     */
    public function getConfigContainer(): ConfigContainer
    {
        if ($this->configContainer === null) {
            $this->configContainer = new ConfigContainer();
        }
        return $this->configContainer;
    }

    /**
     * @return \Xervice\Config\Business\Parser\Parser
     */
    public function createParser(): Parser
    {
        return new Parser(
            $this->getConfigContainer()
        );
    }

    /**
     * @return \Xervice\Config\Business\Environment\Environment
     */
    public function createEnvironment(): Environment
    {
        return new Environment();
    }
}
