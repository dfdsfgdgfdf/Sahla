<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductCouponRequest;
use App\Models\ProductCoupon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,show_productCoupons')) {
            return redirect('admin/index');
        }

        $productCoupons = ProductCoupon::query()

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.productCoupons.index', compact('productCoupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,create_productCoupons')) {
            return redirect('admin/index');
        }

        return view('backend.productCoupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCouponRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,create_productCoupons')) {
            return redirect('admin/index');
        }

        $productCoupons = ProductCoupon::create($request->validated());

        Alert::success('Product Coupon Created Successfully', 'Success Message');
        return redirect()->route('admin.productCoupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCoupon $productCoupon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,show_productCoupons')) {
            return redirect('admin/index');
        }

        return view('backend.tags.show', compact('productCoupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCoupon $productCoupon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,update_productCoupons')) {
            return redirect('admin/index');
        }

        return view('backend.productCoupons.edit', compact('productCoupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCouponRequest $request, ProductCoupon $productCoupon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,update_productCoupons')) {
            return redirect('admin/index');
        }

        $productCoupon->update($request->validated());

        Alert::success('Product Coupon Updated Successfully', 'Success Message');
        return redirect()->route('admin.productCoupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCoupon $productCoupon)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productCoupons,delete_productCoupons')) {
            return redirect('admin/index');
        }

        $productCoupon->delete();

        Alert::success('Product Coupon Deleted Successfully', 'Success Message');
        return redirect()->route('admin.productCoupons.index');
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $productCoupon = ProductCoupon::findorfail($id);
            $productCoupon->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $productCoupon = ProductCoupon::find($request->cat_id);
        $productCoupon->status = $request->status;
        $productCoupon->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}
