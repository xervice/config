<?php
declare(strict_types=1);


namespace Xervice\Config\Business\Parser;


use Xervice\Config\Business\Container\ConfigContainer;

class Parser
{
    /**
     * @var \Xervice\Config\Business\Container\ConfigContainer
     */
    private $configContainer;

    /**
     * Parser constructor.
     *
     * @param \Xervice\Config\Business\Container\ConfigContainer $configContainer
     */
    public function __construct(ConfigContainer $configContainer)
    {
        $this->configContainer = $configContainer;
    }

    /**
     * @param string $file
     */
    public function parseFile(string $file): void
    {
        $config = $this->configContainer->toArray();
        if (file_exists($file)) {
            require $file;
            $this->configContainer->fromArray($config);
        }
    }
}
