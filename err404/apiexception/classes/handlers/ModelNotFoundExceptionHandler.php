<?php

namespace Err404\ApiException\Classes\Handlers;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelNotFoundExceptionHandler extends BaseExceptionHandler
{
	protected static $processableExceptions = [
		ModelNotFoundException::class
	];

	public function getMessage()
	{
		return sprintf(
			'%s not found',
			array_last(explode('\\', $this->exception->getModel()))
		);
	}

	public function getStatusCode()
	{
		return 404;
	}
}
