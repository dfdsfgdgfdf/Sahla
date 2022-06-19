<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductUnitRequest;
use App\Models\Unit;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UnitController extends Controller
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
        $units = Unit::query()
            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        return view('backend.units.index', compact('units'));
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
    public function store(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products')) {
            return redirect('admin/index');
        }
        $input['name_ar']    = $request->name_ar;
        $input['name_en']    = $request->name_en;
        $input['name_ur']    = $request->name_ur;
        $input['status']     = $request->status;
        Unit::create($input);
        Alert::success('Unit Created Successfully', 'Success Message');
        return redirect()->route('admin.units.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit, Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products')) {
            return redirect('admin/index');
        }
        $unit->delete();
        Alert::success('Unit Deleted Successfully', 'Success Message');
        return redirect()->route('admin.units.index');
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
        $unit = Unit::find($request->cat_id);
        $unit->status = $request->status;
        $unit->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}

