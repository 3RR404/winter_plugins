<?php

namespace Err404\ApiException\Classes\Handlers;

use October\Rain\Exception\ValidationException;

class ValidationExceptionHandler extends BaseExceptionHandler
{
	protected static $processableExceptions = [
		ValidationException::class
	];

	public function getMessage()
	{
		return $this->exception->getErrors();
	}

	public function getStatusCode()
	{
		return 422;
	}
}
