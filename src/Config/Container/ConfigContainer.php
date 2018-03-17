<?php


namespace Xervice\Config\Container;



use Xervice\Config\Exception\ConfigNotFound;

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
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function get(string $name, string $default = null)
    {
        if (!isset($this->configs[$name])) {
            if ($default === null) {
                throw new ConfigNotFound($name);
            }
            $this->set($name, $default);
        }
        return $this->configs[$name];
    }
}