<?php

namespace Err404\Shoping\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BrandResource extends Resource
{
	public function toArray($request)
	{
		return [
			'id' 				=> $this->id,
			'slug' 				=> $this->slug,
			'name'				=> $this->name,
			'code' 				=> $this->code,
			'preview_text' 		=> $this->preview_text,
			'description' 		=> $this->description,
			'preview_image' 	=> $this->preview_image,
			'icon' 				=> $this->icon,
			'images' 			=> $this->images,
			'updated_at' 		=> $this->updated_at->toDateTimeString(),
			'created_at' 		=> $this->created_at->toDateTimeString(),
            'products'          => SimpleProductResource::collection(
                $this->product()->where('active', true)->get()
            )
		];
	}
}
