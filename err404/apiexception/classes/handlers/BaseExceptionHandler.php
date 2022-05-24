<?php

namespace Err404\ApiException\Classes\Handlers;

use Exception;
use Illuminate\Support\Facades\Event;

abstract class BaseExceptionHandler
{
    protected $exception;

    protected $report = true;

    protected static $processableExceptions = [
        Exception::class
    ];

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;

        if ($this->report) {
            $this->report();
        }
    }

    public static function isProcessable($exception)
    {
        return collect(static::$processableExceptions)->some(function ($processableException) use ($exception) {
            return $exception instanceof $processableException;
        });
    }

    public function getMessage()
    {
        return $this->exception->getMessage();
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getStatusCode()
    {
        $exceptionStatusCode = 500;
        if (method_exists($this->exception, 'getStatusCode')) {
            $exceptionStatusCode = $this->exception->getStatusCode();
        } elseif (method_exists($this->exception, 'getCode')) {
            $exceptionStatusCode = $this->exception->getCode();
        }

        if ($exceptionStatusCode < 100 || $exceptionStatusCode > 511) {
            $exceptionStatusCode = 500;
        }

        return $exceptionStatusCode;
    }

    public function getResponseContent()
    {
        return [
            'error' => $this->getMessage(),
            'status_code' => $this->getStatusCode()
        ];
    }

    public function report()
    {
        Event::fire('exception.report', [$this->exception]);
    }
}
