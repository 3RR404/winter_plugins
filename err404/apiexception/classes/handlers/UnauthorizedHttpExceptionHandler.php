<?php

namespace Err404\ApiException\Classes\Handlers;

use October\Rain\Auth\AuthException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UnauthorizedHttpExceptionHandler extends BaseExceptionHandler
{
	protected static $processableExceptions = [
		UnauthorizedHttpException::class
	];

	public function getStatusCode()
	{
		return 401;
	}
}
