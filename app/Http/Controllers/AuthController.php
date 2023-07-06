<?php

namespace App\Http\Controllers;


use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    function register()
    {

    }

    function login(Request $request)
    {

        if($request->method() == "GET"){

            //判断是否登录
            if(\auth()->check()){
                if($request->query("redirect")){
                    return  redirect( $request->query("redirect"));
                }else{
                    return  redirect( route('Admin::index'));
                }

            }
            return  view('admin.login');
        }

//        $validator = Validator::make($request->all(), [
//            'username' => 'required',
//            'password' => 'required',
//            'type' => 'required',
//        ],[] ,[
//            'username'=>"用户名",
//            'password'=>"密码"
//        ]);

//        if ($validator->fails()) {
//            return  ResponseHelper::returnJSON($validator->errors()->first());
//        }

        if (\auth()->check()) {
            return  ResponseHelper::returnJSON("已经登录了", "", 201);
        }

        $username = $request->input("username");
        $password = $request->input("password");


        if ($username == "") {
            return  ResponseHelper::returnJSON("请输入用户名", "", 422);
        }
        if ($password == "") {
            return  ResponseHelper::returnJSON("请输入密码", "", 422);
        }
        $a = Auth::attempt(['username' => $username, 'password' => $password]);
        if ($a) {
//            $data=["menu"=>['exit'=>route()]];
            return  ResponseHelper::returnJSON("登录成功", "", 200);
        } else {
            return  ResponseHelper::returnJSON("验证失败,用户名或者密码错误", "", 422);
        }
//
//        dd($credentials->errors()->first());
//        var_dump(get_class_methods($request));
//        $credentials = $request->validate([
//            'username' => 'required',
//            'password' => 'required',
//        ]);
//
//        if (Auth::attempt($credentials)) {
//            dd(2);
//            // 用户通过身份验证
//        } else {
//            dd(3);
//            // 用户身份验证失败
//        }

    }
}
