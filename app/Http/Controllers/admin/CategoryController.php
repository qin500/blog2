<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        $categorys = Category::get();

        return view('admin.category.index', compact('categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'name' => 'required'
        ],
            ['name.required' => "名称不能为空"]);


        if ($validator->errors()->count() > 0) {
            return response()->json(['code' => 422, 'msg' => "名称不能为空"]);
        }

        //查询分类是否存在
        $category = Category::where(['name' => $request->input('name')])->get();

        if (count($category)) {
            return response()->json(['code' => 422, 'msg' => "分类已存在"]);
        }


        $res = Category::create([
            'name' => $request->input('name'),
            'total' => 0
        ]);

        if ($res) {
            $res->edit_link = route('Admin::category.edit', [$res]);
            $res->cat_link = route('Home::category', [$res]);
            return response()->json(['code' => 200, 'data' => $res, 'msg' => "分类添加成功"]);
        } else {
            return response()->json(['code' => 422, 'msg' => "添加失败"]);

        }

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
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($category->name == $request->input('name')) {
            return response()->json(['code' => 422, 'msg' => "您未修改名称,和原来相同"]);
        }

        $validator = \Validator::make($request->input(),
            ['name' => [
                'required',
                Rule::unique('categories')->ignore($request->input('name'))
            ]]);

        if($validator->fails()){
            return response()->json(['code' => 422, 'msg' => "该名称已存在,更新失败"]);
        }

        $category->update(['name'=>$request->input('name')]);
        return response()->json(['code' => 200, 'msg' => "更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $articles = Article::where(['cid' => $category->id])->get();
        if ($articles->count()) {
            return response()->json(['code' => 422, 'msg' => "删除失败,该分类下已有文章"]);
        }

        // 如果没有文章,删除分类
        $category->delete();
        return response()->json(['code' => 200]);
    }
}
