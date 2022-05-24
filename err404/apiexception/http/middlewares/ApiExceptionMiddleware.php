<?php

namespace Err404\ApiException\Http\Middlewares;

use Closure;
use Err404\ApiException\Traits\ApiExceptionResponse;

class ApiExceptionMiddleware
{
	use ApiExceptionResponse;

	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);

		$exception = $response->exception;
		if (!$exception && $response->original instanceof \Exception) {
			$exception = $response->original;
		}

		if ($exception) {
			return $this->apiExceptionResponse($exception);
		}

		return $response;
	}
}
