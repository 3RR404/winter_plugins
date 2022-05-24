<?php

namespace Err404\Shoping\Http\Resources;

class SimpleProductResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id' 				=> $this->id,
            'slug' 				=> $this->slug,
            'name'				=> $this->name,
            'code' 				=> $this->code,
            'preview_text' 		=> $this->preview_text,
            'preview_image' 	=> $this->preview_image,
            'description' 		=> $this->description,
            'images' 			=> $this->images,
            'created_at' 		=> $this->created_at->toDateTimeString(),
            'updated_at' 		=> $this->updated_at->toDateTimeString(),
        ];
    }
}
