<?php

namespace Err404\ApiException\Classes\Handlers;

use October\Rain\Auth\AuthException;

class AuthExceptionHandler extends BaseExceptionHandler
{
	protected static $processableExceptions = [
		AuthException::class
	];

	public function getStatusCode()
	{
		return 401;
	}
}
