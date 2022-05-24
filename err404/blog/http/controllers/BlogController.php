<?php namespace Err404\Blog\Http\Controllers;

use Err404\Apitraits\Traits\PerPage;
use Illuminate\Routing\Controller;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;

class BlogController extends Controller
{
    use PerPage;

    public function index()
    {
        $this->perPage = 6;

        $articleResourceClass = config('err404.blog::resources.article');
        return $articleResourceClass::collection(
            Post::isPublished()
                ->with('categories')
                ->orderBy('published_at', 'desc')
                ->paginate($this->_resultsPerPage())
                ->appends(request()->query())
        ) ?: [];
    }

    public function show($key)
    {
        $articleResourceClass = config('err404.blog::resources.article');

        $article = Post::isPublished()
            ->where('slug', $key)
            ->orWhere('id', $key)
            ->firstOrFail();

        return new $articleResourceClass($article) ?: [];
    }

    public function categories()
    {
        $categoryResourceClass = config('err404.blog::resources.category');

        return $categoryResourceClass::collection(
            Category::with('posts')->get()
        ) ?: [];
    }
}
