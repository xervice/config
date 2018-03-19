<?php


namespace Xervice\Config\Exception;


use Throwable;

class FileNotFound extends \Exception
{
    /**
     * FileNotFound constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = 'Config file not found ' . $message;

        parent::__construct($message, $code, $previous);
    }

}