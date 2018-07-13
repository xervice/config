<?php
declare(strict_types=1);


namespace Xervice\Config\Parser;


use Xervice\Config\Container\ConfigContainer;

class Parser
{
    /**
     * @var \Xervice\Config\Container\ConfigContainer
     */
    private $configContainer;

    /**
     * Parser constructor.
     *
     * @param \Xervice\Config\Container\ConfigContainer $configContainer
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
