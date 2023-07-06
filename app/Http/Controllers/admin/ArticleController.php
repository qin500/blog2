<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function index(Request $request)
    {


        $articles = Article::where('title', "like", "%" . $request->input('title') . "%")->orderBy('created_at','desc')->paginate(10);

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::get();
        return view('admin.article.create', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|string[]
     */
    public function store(Request $request)
    {

        $validat = \Validator::make($request->input(), [
            'title' => 'required',
            'cid' => 'not_in:0|numeric',
            'log_text' => 'required'
        ], [], [
            'cid' => '分类',
            'title' => '标题',
            'log_text' => '文章内容'
        ]);

        if ($validat->errors()->count() > 0) {
            return ['code' => '422', 'msg' => $validat->errors()->first()];
        }
        if ($request->input('cover') == "") {
            $name = str_pad(rand(1, 10), 2, "0", STR_PAD_LEFT) . "jpg"; //文件名称
            $dir = "/static/res/rnd" . $name;
            $request->input('cover', $dir);
        }


        $article = Article::create($request->input());

        if ($article) {
            $article->link=route('Admin::article.update', [$article]);
            $article->preview=route('Home::article',[$article]);
            return ['code' => '200', 'msg' => '文章发布成功', "data" => $article];
        }
        return ['code' => '422', 'msg' => '文章发布失败'];


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $cats = Category::get();
        return view('admin.article.edit', compact('article', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validat = \Validator::make($request->input(), [
            'title' => 'required',
            'cid' => 'not_in:0|numeric',
            'log_text' => 'required'
        ], [], [
            'cid' => '分类',
            'title' => '标题',
            'log_text' => '文章内容'
        ]);

        if ($validat->errors()->count() > 0) {
            return ['code' => '422', 'msg' => $validat->errors()->first()];
        }
        if ($request->input('cover') == "") {
            $name = str_pad(rand(1, 10), 2, "0", STR_PAD_LEFT) . "jpg"; //文件名称
            $dir = "/static/res/rnd" . $name;
            $request->input('cover', $dir);
        }
        $article->title=$request->input('title');
        $article->cid=$request->input('cid');
        $article->log_text=$request->input('log_text');
        $article->strip_text=$request->input('strip_text');
        $article->cover=$request->input('cover');
        $article->publish=$request->input('publish');
        $article->update();
        return ['code' => '200', 'msg' => "更新成功"];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request,Article $article)
    {
       $d= $article->delete();
       if($d){
           return  ResponseHelper::returnJSON("删除成功");
       }else{
           return  ResponseHelper::returnJSON("删除失败",[],400);
       }
    }
}
