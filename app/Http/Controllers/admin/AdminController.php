<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {


        return view('admin.index');
    }

    function uploading(Request $request)
    {

    }

    function logout()
    {

        \Auth::logout();
        return returnJSON('退出成功', [], 201);
    }
}
