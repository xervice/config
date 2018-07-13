<?php
declare(strict_types=1);


namespace Xervice\Config\Container;


class ConfigContainer
{
    /**
     * @var array
     */
    private $configs = [];

    /**
     * @param string $name
     * @param mixed $val
     *
     * @return \Xervice\Config\Container\ConfigContainer
     */
    public function set(string $name, $val): ConfigContainer
    {
        $this->configs[$name] = $val;

        return $this;
    }

    /**
     * @param array $config
     */
    public function fromArray(array $config): void
    {
        $this->configs = array_merge($this->configs, $config);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->configs;
    }

    /**
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $name, $default = null)
    {
        if (!isset($this->configs[$name])) {
            $this->set($name, $default);
        }
        return $this->configs[$name];
    }
}
