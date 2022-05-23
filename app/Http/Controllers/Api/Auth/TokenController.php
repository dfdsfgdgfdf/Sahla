<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Traits\GeneralTrait;

class TokenController extends Controller
{
    use GeneralTrait;

    //Login
    public function store(LoginRequest $request)
    {
        // $this->validate($request, [
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required',
        // ]);
        if (!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
        }
        $token = auth()->user()->createToken($request->deviceId)->plainTextToken;
        return $this->successMessage($token, 'Auth User Token');
    }

    //User Data
    public function userLoginData(Request $request)
    {
        $user = $request->user();
        $token = $request->bearerToken();
        $user->token = $token;
        return $this->successMessage($user, 'Data for Login User');
    }

    //Logout
    public function destroy(Request $request)
    {
        auth()->user()->tokens()->where('name', $request->deviceId)->delete();
        return $this->successMessage('', 'User Logout Successfully');
    }

}
