<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Loc;
use Illuminate\Http\Request;

class LocController extends Controller
{
    public function index(Request $request)
    {
        $parent_id = $request->get('parent_id', 0);
        return Loc::where('parent_id', $parent_id)->get();
    }
}
