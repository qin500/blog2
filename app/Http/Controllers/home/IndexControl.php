<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexControl extends Controller
{
    function index()
    {


        $list = Article::orderBy('created_at', 'desc')->paginate(10);

        return view("home.index", compact("list"));
    }


    function article(Request $request, Article $article)
    {

        //自增
        $article->increment("views");
        //上一篇
        $article_prev = Article::where('id', '<', $article->id)->orderBy("id", 'desc')->first();
        $article_next = Article::where('id', '>', $article->id)->orderBy("id", 'asc')->first();


        return view('home.article', compact('article', 'article_prev', 'article_next'));
    }

    function tag(Request $request, $name)
    {
        $tags = Tag::where(['name' => $name])->select('aid')->get()->toArray();
        if (count($tags) > 0) {
            $tags = array_column($tags, "aid");
            $articles = Article::whereIn("id", $tags)->get();

            return view('home.tag', compact('articles'));
        }

//        return  redirect("")

    }

    function category(Category $category)
    {
        $articles = Article::whereIn("cid", $category)->get();
        return view('home.category', compact('articles'));
    }
}
