<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,show_customers')) {
            return redirect('admin/index');
        }

        $customers = User::whereHas('roles', function($query){
            $query->where('name', 'customer');
        })

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,create_customers')) {
            return redirect('admin/index');
        }

        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,create_customers')) {
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

            DB::commit(); // insert data
            Alert::success('Customer Created Successfully', 'Success Message');
            return redirect()->route('admin.customers.index');

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
    public function show(User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,show_customers')) {
            return redirect('admin/index');
        }

        return view('backend.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,update_customers')) {
            return redirect('admin/index');
        }

        $customer_address = UserAddress::whereUserId($customer->id)->first();
        return view('backend.customers.edit', compact('customer', 'customer_address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,update_customers')) {
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

                if ($customer->user_image != null && File::exists( $customer->user_image )) {
                    unlink( $customer->user_image );
                }

                $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
                $path = ('images/customer/' . $filename);
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $input['user_image']  = $path;
            }
            $customer->update($input);

            $customer_address = UserAddress::whereUserId($customer->id)->first();
            ### ِAddress
            $address['user_id']       = $customer->id;
            $address['address']       = $request->address;
            $address['country_id']    = $request->country_id;
            $address['state_id']      = $request->state_id;
            $address['city_id']       = $request->city_id;
            $address['zip_code']      = $request->zip_code;
            $address['po_box']        = $request->po_box;
            $customer_address->update($address);

            DB::commit(); // insert data
            Alert::success('Customer Updated Successfully', 'Success Message');
            return redirect()->route('admin.customers.index');

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
    public function destroy(User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,delete_customers')) {
            return redirect('admin/index');
        }

        if ($customer->user_image != null && File::exists( $customer->user_image)) {
            unlink( $customer->user_image);
        }
        $customer->delete();

        Alert::success('Customer Deleted Successfully', 'Success Message');
        return redirect()->route('admin.customers.index');
    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,delete_customers')) {
            return redirect('admin/index');
        }

        $customer = User::whereId($request->customer_id)->first();
        if ($customer) {
            if (File::exists( $customer->user_image)) {
                unlink( $customer->user_image);

                $customer->user_image = null;
                $customer->save();
            }
        }
        return true;
    }


    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $customer = User::findorfail($id);
            if (File::exists($customer->user_image)) :
                unlink($customer->user_image);
            endif;
            $customer->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $customer = User::find($request->cat_id);
        $customer->status = $request->status;
        $customer->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }


    public function getCustomerSearch()
    {
        $customers = User::whereHas('roles', function($query){
            $query->where('name', 'customer');
        })
        ->when(\request()->input('query') != '', function ($query){
            $query->search(\request()->input('query'));
        })
        ->get(['id', 'first_name', 'last_name', 'email'])->toArray();

        return response()->json($customers);
    }
}
