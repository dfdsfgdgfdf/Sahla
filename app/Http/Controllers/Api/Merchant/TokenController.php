<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserInfoResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\UserAddress;
use App\Models\UserMaxLimit;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use App\Http\Requests\Api\ResetRequest;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;


class TokenController extends Controller
{
    use GeneralTrait;

    //Login
    public function store(LoginRequest $request)
    {
         $this->validate($request, [
             'email' => 'required|email|exists:users,email',
             'password' => 'required',
         ]);
        if (!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
        }
        if(auth()->user()->roles()->first()->name != "merchant"){
            throw new AuthenticationException();
        }
        $token = auth()->user()->createToken($request->deviceId)->plainTextToken;
        return $this->successMessage($token, 'Auth User Token');
    }

    //Register
    public function createMerchantAccount(Request $request)
    {
        $this->validate($request, [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'username'      => 'required|max:50|unique:users',
            'email'         => 'required|email|max:255|unique:users',
            'mobile'        => 'required|numeric|unique:users',
            'password'      => 'nullable|min:8',
            'status'        => '0',
            'account_status'=> '1',
            'order_status'  => '0',
            'user_image'    => 'required|mimes:png,jpg,jpeg,svg|max:5048'
        ]);

        DB::beginTransaction();
        try {
            $input['first_name']    = $request->first_name;
            $input['last_name']     = $request->last_name;
            $input['username']      = $request->username;
            $input['email']         = $request->email;
            $input['email_verified_at']  = \Illuminate\Support\Carbon::now();
            $input['mobile']        = $request->mobile;
            $input['password']      = bcrypt($request->password);
            $input['status']        = 1;
            $input['account_status']= 1;
            $input['order_status']  = 1;

            if ($image = $request->file('user_image')) {
                $filename = time().Str::slug($request->username).'.'.$image->getClientOriginalExtension();
                $path = ('images/merchant/' . $filename);
                Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $input['user_image']  = $path;
            }

            $customer = User::create($input);
            $customer->markEmailAsVerified();
            $customer->attachRole(Role::whereName('merchant')->first()->id);

            ### ِAddress
            $address['user_id']       = $customer->id;
            $address['address']       = $request->address;
            $address['country_id']    = $request->country_id;
            $address['state_id']      = $request->state_id;
            $address['city_id']       = $request->city_id;
            $address['zip_code']      = $request->zip_code;
            $address['po_box']        = $request->po_box;
            UserAddress::create($address);

            ### ِMax Limit
            $max_limit['user_id']       = $customer->id;
            $max_limit['max_limit']     = '10000';
            $max_limit['status']        = 1;
            UserMaxLimit::create($max_limit);

            DB::commit(); // insert data
            if (!auth()->attempt($request->only('email', 'password'))) {
                throw new AuthenticationException();
            }
            if(auth()->user()->roles()->first()->name != "merchant"){
                throw new AuthenticationException();
            }
            $token = auth()->user()->createToken($request->deviceId)->plainTextToken;
            return $this->successMessage($token, 'Merchant Account Created Successfully');

        }catch (\Exception $e){
            DB::rollback();
            return $this->returnErrorMessage('Sorry! Invalid Data, Please Try again', '422');
        }
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

    public function updateImage(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            "user_image" => "required|file|mimes:png,jpg,svg,gif",
        ]);

        $merchant = \auth()->user();

        if ($merchant->user_image != null && File::exists( $merchant->user_image )) {
            unlink( $merchant->user_image );
        }
        $image = $request->file('user_image');
        $filename = time().Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        $path = ('images/merchant/' . $filename);
        Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $input['user_image']  = $path;

        $merchant->update($input);
        return $this->successMessage(new UserResource($merchant), 'Profile Image Updated Successfully');
    }

    //Register
    public function updateMerchantinfo(Request $request)
    {
        $this->validate($request, [
            'first_name'    => 'nullable|min:3',
            'last_name'     => 'nullable|min:3',
            'username'      => 'nullable|min:3|max:50|unique:users,username,' . \auth()->id(),
            'email'         => 'nullable|email|max:255|unique:users,email,' . \auth()->id(),
            'mobile'        => 'nullable|numeric|unique:users,mobile,' . \auth()->id(),
            'password'      => 'nullable|min:8',

            'address'       => 'nullable|min:3',
            'country_id'    => 'nullable|exists:countries,id',
            'state_id'      => 'nullable|exists:states,id',
            'city_id'       => 'nullable|exists:cities,id',
            'zip_code'      => 'nullable|min:3',
            'po_box'        => 'nullable|min:3',
        ]);
        $merchant = \auth()->user();

        DB::beginTransaction();
        try {
            $input['first_name']    = $request->first_name;
            $input['last_name']     = $request->last_name;
            $input['username']      = $request->username;
            $input['email']         = $request->email;
            $input['mobile']        = $request->mobile;
            $input['password']      = bcrypt($request->password);
            $merchant->update($input);

            ### ِAddress
            $merchant_address = UserAddress::whereUserId(\auth()->id())->first();
            if (!empty($merchant_address)){
                $address['address']       = $request->address;
                $address['country_id']    = $request->country_id;
                $address['state_id']      = $request->state_id;
                $address['city_id']       = $request->city_id;
                $address['zip_code']      = $request->zip_code;
                $address['po_box']        = $request->po_box;
                $merchant_address->update($address);
            }else{
                $address['user_id']       = $merchant->id;
                $address['address']       = $request->address;
                $address['country_id']    = $request->country_id;
                $address['state_id']      = $request->state_id;
                $address['city_id']       = $request->city_id;
                $address['zip_code']      = $request->zip_code;
                $address['po_box']        = $request->po_box;
                UserAddress::create($address);
            }

            return $this->successMessage(new UserInfoResource($merchant), 'Profile Information Updated Successfully');

        }catch (\Exception $e){
            DB::rollback();
            return $this->returnErrorMessage('Sorry! Invalid Data, Please Try again', '422');
        }
    }

}
