<?php

namespace Err404\Location\Http\Resources;

use October\Rain\Support\Facades\Event;

class CountryResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        $response = [
            'id'        => $this->id,
            'name'      => $this->name,
            'code'      => $this->code,
            'is_pinned' => $this->is_pinned,
            'states'    => SimpleStateResource::collection(
                $this->states->where('is_enabled', true)
            )
        ];

        Event::fire('err404.location.location.beforeReturnResponse', [$response]);

        return $response;
    }
}
