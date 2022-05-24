<?php

namespace Err404\Shoping\Http\Controllers;

use Err404\Apitraits\Traits\PerPage;
use Err404\Shoping\Http\Resources\ProductResource;
use Illuminate\Routing\Controller;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Models\Product;

class FilterController extends Controller
{

    use PerPage;

    public function filter()
    {
        $this->perPage = 12;

        if ( @get('categories') ) {
            $categories_ids = explode(',', get('categories'));

            return ProductResource::collection(
                $this->getByCategories(Product::isActive(), $categories_ids)
                    ->paginate($this->_resultsPerPage())
                    ->appends(request()->query())
            );
        } else if ( @get('tags') ) {
            $tag = get('tags');

            return ProductResource::collection(
                ProductCollection::make()->tag(1)
            );

        }
    }

    protected function getByCategories($obQuery, $sData)
    {
        if (!empty($sData)) {
            foreach ($sData as $category) {
                $obQuery->where('category_id', $category)->orWhereHas('additional_category', function ($obQuery) use ($category) {
                    $obQuery->where('category_id', $category);
                });
            }
        }

        return $obQuery;
    }

    public function onSearch()
    {
        $searching = get('s');

        $products = ProductCollection::make();

        $arProductsID = $products->search($searching)->getIDList();

        $results = Product::whereIn('id', $arProductsID);

        return ProductResource::collection( $results->get() );
    }
}
