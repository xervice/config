<?php


namespace Xervice\Config\Environment;


class Environment
{
    const ENV_ENVIRONMENT = 'APPLICATION_ENV';

    /**
     * @return string
     */
    public function getEnvironment() : string
    {
        return getenv(self::ENV_ENVIRONMENT, true) ?: 'production';
    }
}