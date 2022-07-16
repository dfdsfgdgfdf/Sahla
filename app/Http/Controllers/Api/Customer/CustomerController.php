<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserMaxLimit;
use App\Traits\GeneralTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class CustomerController extends Controller
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
        if(auth()->user()->roles()->first()->name != "customer"){
            throw new AuthenticationException();
        }
        $token = auth()->user()->createToken($request->deviceId)->plainTextToken;
        return $this->successMessage($token, 'Auth User Token');
    }

    //Register
    public function createCustomerAccount(Request $request)
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
                $path = ('images/customer/' . $filename);
                Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $input['user_image']  = $path;
            }

            $customer = User::create($input);
            $customer->markEmailAsVerified();
            $customer->attachRole(Role::whereName('customer')->first()->id);

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
            if(auth()->user()->roles()->first()->name != "customer"){
                throw new AuthenticationException();
            }
            $token = auth()->user()->createToken($request->deviceId)->plainTextToken;
            return $this->successMessage($token, 'Customer Account Created Successfully');

        }catch (\Exception $e){
            DB::rollback();
            return $this->returnErrorMessage('Sorry! Invalid Data, Please Try again', '422');
        }
    }

    //updateImage
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
        $path = ('images/customer/' . $filename);
        Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $input['user_image']  = $path;

        $merchant->update($input);
        return $this->successMessage(new UserResource($merchant), 'Customer Profile Image Updated Successfully');
    }



}
