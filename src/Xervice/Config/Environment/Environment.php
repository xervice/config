<?php
declare(strict_types=1);


namespace Xervice\Config\Environment;


class Environment
{
    public const ENV_ENVIRONMENT = 'APPLICATION_ENV';

    /**
     * @return string
     */
    public function getEnvironment() : string
    {
        return getenv(self::ENV_ENVIRONMENT, true) ?: 'production';
    }
}
