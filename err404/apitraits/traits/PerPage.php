<?php

namespace Err404\Apitraits\Traits;

trait PerPage {

    public $perPage = 999999;

    public function _resultsPerPage()
    {
        return get('results_per_page') ?? $this->perPage;
    }

}
