<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductUnitRequest;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,show_products')) {
            return redirect('admin/index');
        }

        $productUnits = ProductUnit::query()

            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

            ->paginate(\request()->limit_by ?? 10);

        return view('backend.productUnits.index', compact('productUnits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductUnitRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products')) {
            return redirect('admin/index');
        }
        $input['product_id']    = $request->product_id;
        $input['unit_id']       = $request->unit_id;
        $input['price']         = $request->price;
        $input['currency']      = $request->currency;
        $input['status']        = $request->status;
        ProductUnit::create($input);
        Alert::success('Product Unit Created Successfully', 'Success Message');
        return redirect()->route('admin.products.unitsIndex', $request->product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUnitRequest $request, ProductUnit $productUnit)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products')) {
            return redirect('admin/index');
        }
        $productUnit->update($request->validated());
        Alert::success('Product Unit Updated Successfully', 'Success Message');
        return redirect()->route('admin.products.unitsIndex', $request->product_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductUnit $productUnit, Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products')) {
            return redirect('admin/index');
        }
        $productUnit->delete();
        Alert::success('Product Unit Deleted Successfully', 'Success Message');
        return redirect()->route('admin.products.unitsIndex', $productUnit->product_id);
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $productUnit = ProductUnit::findorfail($id);
            $productUnit->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $productUnit = ProductUnit::find($request->cat_id);
        $productUnit->status = $request->status;
        $productUnit->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }
}
