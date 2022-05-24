<?php

namespace Err404\User\Classes;

use Err404\User\Models\User;
use RainLab\User\Classes\AuthManager as AuthManagerBase;

class AuthManager extends AuthManagerBase
{
	protected $userModel = User::class;
}
