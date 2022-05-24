<?php

namespace Err404\Shoping\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Lovata\Shopaholic\Models\Product;

class ProductController extends Controller
{
    protected $resourceClass;

    public function setResourceClass( $resourceClass )
    {
        $this->resourceClass = $resourceClass;
    }

    public function show($key)
    {
        $product = Product::isActive()
            ->where('slug', $key)
            ->orWhere('id', $key)
            ->firstOrFail();

        $this->setResourceClass( config('err404.shoping::resources.product') );

        Event::fire('err404.shoping.beforeReturnResource', [$this]);

        $productResourceClass = $this->resourceClass;

        return new $productResourceClass($product);
    }
}
