<?php

namespace Err404\Shoping\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Event;

class ProductResource extends Resource
{
	public function toArray($request)
	{

//        $offersTree = [];
//        $arrOffers = $this->offer()->where('active', true)->get();
//
//        foreach ( $arrOffers as $offer )
//        {
//            foreach ( $offer->property_value()->where('element_id', $offer->id)->get() as $prop)
//                $offersTree[$prop->property->slug][] = [
//                    'offer_id' => $offer->id,
//                    'property_id' => $prop->property->id,
//                    'slug' => $prop->value->slug,
//                    'value' => $prop->value->value,
//                    'price' => $offer->price
//                ];
//        }

        $resource = [
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
            'category'			=> SimpleCategoryResource::collection(
                $this->category()->where('active', true)->get()
            ),
            'additional_category' => SimpleCategoryResource::collection(
                $this->additional_category()->where('active', true)->get()
            ),
            'brand' 			=> BrandResource::collection(
                $this->brand()->where('active', true)->get()
            ),
            'offers'			=> SimpleOfferResource::collection(
                $this->offer()->where('active', true)->get()
            ),
//            'property_offer'    => $offersTree,
            'property'          => PropertyResource::collection(
                $this->property_value()->get()
            ),
        ];

        return $resource;
	}
}
