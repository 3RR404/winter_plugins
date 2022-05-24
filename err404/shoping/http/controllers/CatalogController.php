<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Apitraits\Traits\PerPage;
use Lovata\Shopaholic\Models\Product;
use Illuminate\Routing\Controller;

class CatalogController extends Controller
{
    use PerPage;

    public function index()
    {
        $this->perPage = 6;

        $catalog = Product::isActive()
            ->orderBy('created_at', 'desc')
            ->paginate($this->_resultsPerPage())
            ->appends(request()->query());

        $productResourceClass = config('err404.shoping::resources.product');

        return $productResourceClass::collection($catalog) ?: [];
    }
}
