<?php

namespace Err404\Location\Http\Controllers;

use Err404\Apitraits\Traits\PerPage;
use Err404\Location\Http\Resources\CountryResource;
use Err404\Location\Http\Resources\StateResource;
use Illuminate\Routing\Controller;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;

class LocationController extends Controller
{
    use PerPage;

    public function country()
    {
        $this->perPage = 10;

        return CountryResource::collection(
            Country::isEnabled()
                ->paginate($this->_resultsPerPage())
                ->appends(request()->query())
        );
    }

    public function state()
    {
        $this->perPage = 10;

        return StateResource::collection(
            State::isEnabled()
                ->paginate($this->_resultsPerPage())
                ->appends(request()->query())
        );
    }
}
