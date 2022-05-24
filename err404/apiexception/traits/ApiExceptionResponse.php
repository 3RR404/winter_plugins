<?php

namespace Err404\ApiException\Traits;

use Err404\ApiException\Classes\Handlers\SQLExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Err404\ApiException\Classes\Handlers\AuthExceptionHandler;
use Err404\ApiException\Classes\Handlers\ExceptionHandler;
use Err404\ApiException\Classes\Handlers\ModelNotFoundExceptionHandler;
use Err404\ApiException\Classes\Handlers\UnauthorizedHttpExceptionHandler;
use Err404\ApiException\Classes\Handlers\ValidationExceptionHandler;

trait ApiExceptionResponse
{
	protected $exceptionHandlers = [
		ModelNotFoundExceptionHandler::class,
		UnauthorizedHttpExceptionHandler::class,
		ValidationExceptionHandler::class,
		AuthExceptionHandler::class,
        SQLExceptionHandler::class,
		ExceptionHandler::class
	];

	public function apiExceptionResponse($exception, $statusCode = null)
	{
        $message = $exception->getMessage();

        $exceptionStatusCode = 500;
        if (method_exists($exception, 'getStatusCode')) {
            $exceptionStatusCode = $exception->getStatusCode();
        } elseif (method_exists($exception, 'getCode')) {
            $exceptionStatusCode = $exception->getCode();
        }

        if ($exceptionStatusCode < 100 || $exceptionStatusCode > 511) {
            $exceptionStatusCode = 500;
        }

        if ($exception instanceof ModelNotFoundException) {
            $message = sprintf('%s not found',
                array_last(explode('\\', $exception->getModel()))
            );
            $exceptionStatusCode = 404;
        } elseif ($exception instanceof ValidationException) {
            $message = $exception->getErrors();
            $exceptionStatusCode = 422;
        } else {
            Event::fire('exception.report', [$exception]);
        }

        if ($statusCode) {
            $exceptionStatusCode = $statusCode;
        }

        $content = [
            'error' => $message,
            'statusCode' => $exceptionStatusCode
        ];

        $response = Event::fire('err404.apicore.error.response', [$content, $exception], true);
        if ($response) {
            if ($response instanceof Response) {
                return $response;
            }

            $content = $response;
        }

        return new Response($content, @$content['statusCode'] ?? $exceptionStatusCode);
	}
}
