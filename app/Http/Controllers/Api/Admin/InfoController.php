<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoController extends Controller
{

    public function __invoke(Request $request)
    {
        $info = [
            '版本号' => env('SYS_VERSION'),
            '操作系统' => PHP_OS,
            'PHP版本' => PHP_VERSION,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            '主机名' => $_SERVER["SERVER_NAME"],
            '网站端口' => $_SERVER['SERVER_PORT'],
            '网站文件目录' => $_SERVER['DOCUMENT_ROOT'],
            '浏览器信息' => $_SERVER['HTTP_USER_AGENT'],
            '上传附件限制' => ini_get('upload_max_filesize'),
            '服务器时间' => \Carbon\Carbon::now()->toDateTimeString(),
        ];
        return $info;
    }
}
