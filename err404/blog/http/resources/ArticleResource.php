<?php

namespace Err404\Blog\Http\Resources;

use Err404\User\Http\Resources\UserResource;
use Illuminate\Support\Facades\Event;

class ArticleResource extends \Illuminate\Http\Resources\Json\Resource
{
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'content_html' => $this->content_html,
            'excerpt' => $this->excerpt,
            'metadata' => $this->metadata,
            'author' => new UserResource( $this->user ),
            'categories' => CategoryResource::collection(
                $this->categories()->get()
            ),
            'featured_images' => $this->featured_images,
            'content_images' => $this->content_images,
            'published_at'  => $this->published_at->toDateTimeString(),
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];

        Event::fire('err404.blog.article.beforeReturnResource', [&$response, $this->resource]);

        return $response;
    }
}
