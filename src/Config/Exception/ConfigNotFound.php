<?php


namespace Config\Exception;


use Throwable;

class ConfigNotFound extends \Exception
{
    /**
     * ConfigNotFound constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = 'Config not found for key ' . $message;

        parent::__construct($message, $code, $previous);
    }

}