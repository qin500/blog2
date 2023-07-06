<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;


class AdminController extends Controller
{


    function qngenerate_token()
    {


        // 初始化签权对象
        $auth = new Auth(env('QINIU_AK'), env('QINIU_SK'));



        // 指定上传目录
        $uploadDir = env('QINIU_DEFAULT_DIR');  // 替换为您想要上传的目录

        // 生成上传Token，并指定上传目录
        $token = $auth->uploadToken(env('QINIU_BUCKET'), null, 3600, ['saveKey' => $uploadDir . '/$(etag)']);


        $bucketMgr=new BucketManager($auth);


        return ResponseHelper::returnJSON('成功', ['token' => $token]);


    }


    function index()
    {


        return view('admin.index');
    }

    function uploading(Request $request)
    {


        $file = $_FILES['file'];
        if ($file['error'] != 0) {
            $errno = [
                "上传的文件超过了 upload_max_filesize 指令在 php.ini 中的设置。",
                "上传文件的大小超过了 HTML 表单中指定的 MAX_FILE_SIZE 指令。",
                "文件只有部分被上传。",
                "PHP 扩展阻止了文件上传。",
                "没有文件被上传。",
                "找不到临时文件夹。",
                "文件写入失败。"];

            return response()->json(['code' => 422, 'msg' => $errno[$file['error'] + 1]]);
        }

        $filename = pathinfo($file['name']);

        $filename = date('YmdHis') . "_" . ceil(microtime(true)) . "." . $filename['extension'];

        $pdir = "/static/res/images/";
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $pdir)) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . $pdir, 0777, true);
        }


        $real_url = public_path($pdir) . "/" . $filename;
        if (move_uploaded_file($file['tmp_name'], $real_url)) {
            return response()->json(['code' => 200, 'data' => ['url' => $pdir . $filename], 'msg' => "文件上传成功"]);
        }
        return response()->json(['code' => 422, 'msg' => "文件上传失败"]);


    }

    function logout()
    {

        \Auth::logout();
        return ResponseHelper::returnJSON('退出成功', [], 201);
    }
}
