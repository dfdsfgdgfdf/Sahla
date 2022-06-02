<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Tag;
use App\Models\Unit;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
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

        $products = Product::with('category', 'tags', 'firstMedia')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);

        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,create_products')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name_ar']);
        $units = Unit::whereStatus(1)->get(['id', 'name_ar']);
        return view('backend.products.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,create_products')) {
            return redirect('admin/index');
        }

        $input['name_ar']          = $request->name_ar;
        $input['name_en']          = $request->name_en;
        $input['name_ur']          = $request->name_ur;
        $input['description_ar']   = $request->description_ar;
        $input['description_en']   = $request->description_en;
        $input['description_ur']   = $request->description_ur;
        $input['stock']      = $request->stock;
        $input['quantity']      = $request->quantity;
        $input['currency']      = $request->currency;
        $input['price']         = $request->price;
        $input['unit_id']   = $request->unit_id;
        $input['category_id']   = $request->category_id;
        $input['featured']      = $request->featured;
        $input['status']        = $request->status;

        $product = Product::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('images/product/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                    'file_name'     => $path,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }

        Alert::success('Product Created Successfully', 'Success Message');
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,display_products')) {
            return redirect('admin/index');
        }

        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,update_products')) {
            return redirect('admin/index');
        }

        $categories = Category::whereStatus(1)->get(['id', 'name_ar']);
        $units = Unit::whereStatus(1)->get(['id', 'name_ar']);

        return view('backend.products.edit', compact('categories', 'units', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,update_products')) {
            return redirect('admin/index');
        }

        $input['name_ar']          = $request->name_ar;
        $input['name_en']          = $request->name_en;
        $input['name_ur']          = $request->name_ur;
        $input['description_ar']   = $request->description_ar;
        $input['description_en']   = $request->description_en;
        $input['description_ur']   = $request->description_ur;
        $input['stock']      = $request->stock;
        $input['quantity']      = $request->quantity;
        $input['currency']      = $request->currency;
        $input['price']         = $request->price;
        $input['unit_id']   = $request->unit_id;
        $input['category_id']   = $request->category_id;
        $input['featured']      = $request->featured;
        $input['status']        = $request->status;

        $product->update($input);

        if ($request->images && count($request->images) > 0) {
            $i = $product->media()->count() + 1;
            foreach ($request->images as $file) {
                $filename = $product->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = ('images/product/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $product->media()->create([
                    'file_name'     => $path,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => true,
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }
        Alert::success('Product Updated Successfully', 'Success Message');
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,delete_products')) {
            return redirect('admin/index');
        }

        if($product->media()->count() > 0 )
        {
            foreach ($product->media as $media)
            {
                if (File::exists($media->file_name)) {
                    unlink($media->file_name);
                }
                $media->delete();
            }
        }
        $product->delete();
        Alert::success('Product Deleted Successfully', 'Success Message');
        return redirect()->route('admin.products.index');
    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,delete_products')) {
            return redirect('admin/index');
        }

        $product = Product::findOrFail($request->product_id);
        $image   = $product->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists($image->file_name)) {
                unlink($image->file_name);
            }
        }
        $image->delete();
        return true;
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $product = Product::findorfail($id);
            if (File::exists($product->media->file_name)) :
                unlink($product->media->file_name);
            endif;

            $product->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $product = Product::find($request->cat_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success'=>'Product Status Change Successfully.']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviewsIndex(Product $product)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_products,show_products')) {
            return redirect('admin/index');
        }

        $productReviews = ProductReview::whereProductId($product->id)

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
}
