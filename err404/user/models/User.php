<?php

namespace Err404\User\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use RainLab\User\Models\User as UserBase;

class User extends UserBase implements JWTSubject
{

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	public function getMorphClass()
	{
		return UserBase::class;
	}
}
