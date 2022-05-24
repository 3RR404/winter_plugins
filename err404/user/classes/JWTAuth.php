<?php

namespace Err404\User\Classes;

use Tymon\JWTAuth\JWTAuth as JWTAuthBase;

class JWTAuth extends JWTAuthBase
{
	/**
	 * Get the authenticated user.
	 *
	 * @return \Tymon\JWTAuth\Contracts\JWTSubject
	 */
	public function getUser()
	{
		return $this->user();
	}
}
