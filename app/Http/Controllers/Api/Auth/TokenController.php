<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use App\Http\Requests\Api\ResetRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


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

        /////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////
    public  function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);

        $code = rand(1000,9999);
        $created_at = Carbon::now();
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],

            [
                'token' => $code,
                'created_at' => $created_at
            ]);

        $reset_code =  DB::table('password_resets')->where("token", $code)->first();
        Mail::to($reset_code->email)->send(new ResetPasswordMail($reset_code));
        if (Mail::failures()) {
            return $this->returnErrorMessage('Sorry! Please Try Again Latter');
        }else{
            return $this->returnSuccessMessage('Great! Code Successfully Send In Your Mail');
        }

    }

    public function resetPassword(ResetRequest $request){
        $Token = DB::table('password_resets')->where("token", $request->token)
            ->where("token", "!=", null)->first();

        if(empty($Token->email)){
            return $this->returnErrorMessage('Sorry! Invalid Code', '422');
        }

        $user= User::where("email",$Token->email)->first();
        if ($user) :
            $user->password = bcrypt($request->password);
            if ($user->save()) :
                return $this->returnSuccessMessage("Password Changed Successfully");

            else :
                return $this->returnErrorMessage('Sorry! Please Try Again');
            endif;
        else:
            return $this->returnErrorMessage('Sorry! Invalid Code', '422');
        endif;
    }

}
