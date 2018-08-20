<?php
declare(strict_types=1);


namespace Xervice\Config\Business\Environment;


class Environment
{
    public const ENV_ENVIRONMENT = 'APPLICATION_ENV';
    public const ENV_SCOPE = 'APPLICATION_SCOPE';

    /**
     * @return string
     */
    public function getEnvironment() : string
    {
        return getenv(self::ENV_ENVIRONMENT, true) ?: 'production';
    }

    /**
     * @return string
     */
    public function getScope() : string
    {
        return getenv(self::ENV_SCOPE, true) ?: 'main';
    }
}
