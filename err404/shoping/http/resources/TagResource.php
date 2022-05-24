<?php

namespace Err404\Shoping\Http\Resources;

class TagResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'preview_text' => $this->preview_text,
            'description' => $this->description,
            'preview_image' => $this->preview_image,
            'images' => $this->images,
            'products' => SimpleProductResource::collection(
                $this->product()->isActive()->get()
            ),
            'category' => SimpleCategoryResource::collection(
                $this->category()->active()->get()
            )
        ];
    }
}
