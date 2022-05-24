<?php

namespace Err404\Blog\Classes\Extend;

use RainLab\Blog\Models\Post;

class ArticleExtend
{
    public static function _extendMethodIsActive()
    {
        Post::extend( function($model){

            $model->addDynamicMethod('isActive', function() use ($model) {

                return $model->where('active', true);

            });

        });
    }
}
