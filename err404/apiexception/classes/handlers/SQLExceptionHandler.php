<?php

namespace Err404\ApiException\Classes\Handlers;

class SQLExceptionHandler extends BaseExceptionHandler
{
    public function getStatusCode()
    {
        return 500;
    }
}
