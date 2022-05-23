<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductReviewRequest;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,show_productReviews')) {
            return redirect('admin/index');
        }

        $productReviews = ProductReview::query()

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.productReviews.index', compact('productReviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,create_productReviews')) {
            return redirect('admin/index');
        }

        return view('backend.productReviews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,create_productReviews')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        ProductReview::create($input);

        Alert::success('Product Review Created Successfully', 'Success Message');
        return redirect()->route('admin.productReviews.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,show_productReviews')) {
            return redirect('admin/index');
        }

        return view('backend.productReviews.show', compact('productReview'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,update_productReviews')) {
            return redirect('admin/index');
        }

        return view('backend.productReviews.edit', compact('productReview'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductReviewRequest $request, ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,update_productReviews')) {
            return redirect('admin/index');
        }

        $productReview->update($request->validated());

        Alert::success('Product Review Updated Successfully', 'Success Message');
        return redirect()->route('admin.productReviews.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReview $productReview)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_productReviews,delete_productReviews')) {
            return redirect('admin/index');
        }

        $productReview->delete();

        Alert::success('Product Review Deleted Successfully', 'Success Message');
        return redirect()->route('admin.productReviews.index');
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $productReview = ProductReview::findorfail($id);
            $productReview->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $productReview = ProductReview::find($request->cat_id);
        $productReview->status = $request->status;
        $productReview->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}
