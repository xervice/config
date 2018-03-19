<?php


namespace Xervice\Config\Parser;


use Xervice\Config\Container\ConfigContainer;
use Xervice\Config\Exception\FileNotFound;

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
     *
     * @throws \Xervice\Config\Exception\FileNotFound
     */
    public function parseFile(string $file)
    {
        $config = [];
        if (!file_exists($file)) {
            throw new FileNotFound($file);
        }

        require $file;
        foreach ($config as $key => $value) {
            $this->configContainer->set($key, $value);
        }
    }
}