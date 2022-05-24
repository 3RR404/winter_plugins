<?php

namespace Err404\Blog\Http\Resources;

use Illuminate\Support\Facades\Event;

class CategoryResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'title' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'articles' => SimpleArticleResource::collection(
                $this->posts()->where('published', true)->get()
            ),
        ];

        Event::fire('err404.blog.category.beforeReturnResource', [&$response, $this->resource]);

        return $response;
    }
}
