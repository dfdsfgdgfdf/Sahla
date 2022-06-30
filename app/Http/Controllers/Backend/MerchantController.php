<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MerchantRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserMaxLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,show_merchants')) {
            return redirect('admin/index');
        }

        $merchants = User::whereHas('roles', function($query){
            $query->where('name', 'merchant');
        })

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.merchants.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,create_merchants')) {
            return redirect('admin/index');
        }

        return view('backend.merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MerchantRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,create_merchants')) {
            return redirect('admin/index');
        }
        DB::beginTransaction();
        try {
            $input['first_name']    = $request->first_name;
            $input['last_name']     = $request->last_name;
            $input['username']      = $request->username;
            $input['email']         = $request->email;
            $input['email_verified_at']  = Carbon::now();
            $input['mobile']        = $request->mobile;
            $input['password']      = bcrypt($request->password);
            $input['status']        = $request->status;

            if ($image = $request->file('user_image')) {
                $filename = Str::slug($request->username).'.'.$image->getClientOriginalExtension();
                $path = ('images/merchant/' . $filename);
                Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $input['user_image']  = $path;
            }

            $merchant = User::create($input);
            $merchant->markEmailAsVerified();
            $merchant->attachRole(Role::whereName('merchant')->first()->id);

            ### ِAddress
            $address['user_id']       = $merchant->id;
            $address['address']       = $request->address;
            $address['country_id']    = $request->country_id;
            $address['state_id']      = $request->state_id;
            $address['city_id']       = $request->city_id;
            $address['zip_code']      = $request->zip_code;
            $address['po_box']        = $request->po_box;
            UserAddress::create($address);

            ### ِMax Limit
            $max_limit['user_id']       = $merchant->id;
            $max_limit['max_limit']     = $request->max_limit;
            $max_limit['status']        = $request->status;
            UserMaxLimit::create($max_limit);

            DB::commit(); // insert data
            Alert::success('Merchant Created Successfully', 'Success Message');
            return redirect()->route('admin.merchants.index');

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $merchant)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,show_merchants')) {
            return redirect('admin/index');
        }

        return view('backend.merchants.show', compact('merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $merchant)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,update_merchants')) {
            return redirect('admin/index');
        }

        $merchant_address = UserAddress::whereUserId($merchant->id)->first();
        $merchant_max_limit = UserMaxLimit::whereUserId($merchant->id)->first();
        return view('backend.merchants.edit', compact('merchant', 'merchant_address', 'merchant_max_limit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MerchantRequest $request, User $merchant)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,update_merchants')) {
            return redirect('admin/index');
        }
        DB::beginTransaction();
        try {
            $input['first_name']    = $request->first_name;
            $input['last_name']     = $request->last_name;
            $input['username']      = $request->username;
            $input['email']         = $request->email;
            $input['mobile']        = $request->mobile;
            $input['status']        = $request->status;

            if(trim($request->password) != ''){
                $input['password']      = bcrypt($request->password);
            }

            if ($image = $request->file('user_image')) {

                if ($merchant->user_image != null && File::exists( $merchant->user_image )) {
                    unlink( $merchant->user_image );
                }

                $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
                $path = ('images/merchant/' . $filename);
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $input['user_image']  = $path;
            }
            $merchant->update($input);

            ### ِAddress
            $merchant_address = UserAddress::whereUserId($merchant->id)->first();
            if(!empty($merchant_address)){
                $address['user_id']       = $merchant->id;
                $address['address']       = $request->address;
                $address['country_id']    = $request->country_id;
                $address['state_id']      = $request->state_id;
                $address['city_id']       = $request->city_id;
                $address['zip_code']      = $request->zip_code;
                $address['po_box']        = $request->po_box;
                $merchant_address->update($address);
            }

            ### ِMax Limit
            $user_max_limit = UserMaxLimit::whereUserId($merchant->id)->first();
            $max__limit['max_limit']     = $request->max_limit;
            $max__limit['status']        = $request->status;
            $user_max_limit->update($max__limit);

            DB::commit(); // insert data
            Alert::success('Merchant Updated Successfully', 'Success Message');
            return redirect()->route('admin.merchants.index');

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $merchant)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,delete_merchants')) {
            return redirect('admin/index');
        }

        if ($merchant->user_image != null && File::exists( $merchant->user_image)) {
            unlink( $merchant->user_image);
        }
        $merchant->delete();

        Alert::success('Merchant Deleted Successfully', 'Success Message');
        return redirect()->route('admin.merchants.index');
    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants,delete_merchants')) {
            return redirect('admin/index');
        }

        $merchant = User::whereId($request->merchant_id)->first();
        if ($merchant) {
            if (File::exists( $merchant->user_image)) {
                unlink( $merchant->user_image);

                $merchant->user_image = null;
                $merchant->save();
            }
        }
        return true;
    }


    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $merchant = User::findorfail($id);
            if (File::exists($merchant->user_image)) :
                unlink($merchant->user_image);
            endif;
            $merchant->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $merchant = User::whereId($request->cat_id)->first();
        $merchant->status = $request->status;
        $merchant->save();

        $user_max_limit = UserMaxLimit::whereUserId($request->cat_id)->first();
        $user_max_limit->status = $request->status;
        $user_max_limit->save();

        return response()->json(['success'=>'Status Change Successfully.']);
    }


    public function getCustomerSearch()
    {
        $merchants = User::whereHas('roles', function($query){
            $query->where('name', 'merchant');
        })
        ->when(\request()->input('query') != '', function ($query){
            $query->search(\request()->input('query'));
        })
        ->get(['id', 'first_name', 'last_name', 'email'])->toArray();

        return response()->json($merchants);
    }
}
