<?php


namespace Xervice\Config\Container;


use Config\Exception\ConfigNotFound;

class ConfigContainer
{
    /**
     * @var array
     */
    private $configs;

    /**
     * @param string $name
     * @param $val
     *
     * @return \Xervice\Config\Container\ConfigContainer
     */
    public function set(string $name, $val)
    {
        $this->configs[$name] = $val;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Config\Exception\ConfigNotFound
     */
    public function get(string $name)
    {
        if (!isset($this->configs[$name])) {
            throw new ConfigNotFound($name);
        }
        return $this->configs[$name];
    }
}