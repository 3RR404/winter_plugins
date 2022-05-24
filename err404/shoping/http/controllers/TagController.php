<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Apitraits\Traits\PerPage;
use Err404\Shoping\Http\Resources\TagResource;
use Illuminate\Routing\Controller;
use Lovata\TagsShopaholic\Models\Tag;

class TagController extends Controller
{
    use PerPage;

    public function index()
    {
        $this->perPage = 6;

        $tag = Tag::active()
            ->paginate($this->_resultsPerPage())
            ->appends(request()->query());

        $resourceClass = config('err404.shoping::resources.tag');

        return $resourceClass::collection($tag);
    }

    public function show( $key )
    {
        $tag = Tag::active()
            ->where('slug', $key)
            ->orWhere('id', $key)
            ->firstOrFail();

        $resourceClass = config('err404.shoping::resources.tag');

        return new $resourceClass($tag);
    }
}
