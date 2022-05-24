<?php

namespace Err404\User\Http\Resources;

use Err404\Location\Http\Resources\CountryResource;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{

	public function toArray($request)
	{

		$arUserData = [
            'general' => [
			    'email'         => $this->email,
                'firstName'     => $this->is_superuser == true ? $this->first_name : $this->name,
                'lastName'      => $this->is_superuser == true ? $this->last_name : $this->surname,
                'phone'         => $this->phone,
            ],
            'company' => [
                'name'          => @$this->companyName ?: '',
                'ico'           => $this->ico,
                'dic'           => $this->dic,
                'icdph'         => $this->icdph,
            ],
            'avatar'        => $this->avatar,
            'last_login'    => $this->last_login,
            'last_seen'     => $this->last_seen,
            'created_at'    => $this->created_at,
		];

		Event::fire('err404.user.user.beforeReturnResource', [&$arUserData, $this->resource]);

		return $arUserData;
	}
}
