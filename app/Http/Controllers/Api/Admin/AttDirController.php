<?php

namespace App\Http\Controllers\Api\Admin;

use App\AttDir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttDirController extends Controller
{

    public function index(Request $request)
    {
        return AttDir::with('allChildren')->where(['is_sys' => 'F', 'parent_id' => 0])->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(AttDir $attDir)
    {
        //
    }

    public function edit(AttDir $attDir)
    {
        //
    }

    public function update(Request $request, AttDir $attDir)
    {
        //
    }

    public function destroy(AttDir $attDir)
    {
        //
    }
}
