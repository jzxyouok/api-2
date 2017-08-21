<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebController extends Controller
{

    public function index()
    {
        return config('web');
    }

    public function update(Request $request)
    {
        $arr = var_export($request->all(), true);
        $text = '<?php' . PHP_EOL;
        $text .= 'return ' . $arr . ';';
        file_put_contents(config_path() . '/web.php', $text);
        return $arr;
    }
}
