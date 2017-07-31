<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }

    public function logout(Request $request)
    {
        $user = $this->guard()->user();
        $user->api_token = str_random(60);
        $user->save();
        return response()->json(['msg' => trans('auth.logout')]);
    }

    protected function attemptLogin(Request $request)
    {
        $arr = array_merge($this->credentials($request), ['disable_at' => null]);
        return $this->guard()->attempt($arr, $request->has('remember'));
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        $user = $this->guard()->user();
        $user->api_token = str_random(60);
        $user->save();
        return $user;
    }

}
