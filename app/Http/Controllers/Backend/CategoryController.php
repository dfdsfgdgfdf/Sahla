<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,show_categories')) {
            return redirect('admin/index');
        }

        $categories = Category::withCount('products')

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,create_categories')) {
            return redirect('admin/index');
        }

        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);

        return view('backend.categories.create', compact('main_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,create_categories')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        if ($image = $request->file('cover')) {
            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('images/category/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $input['cover']  = $path;
        }

        Category::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        Alert::success('Category Created Successfully', 'Success Message');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,display_categories')) {
            return redirect('admin/index');
        }

        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,update_categories')) {
            return redirect('admin/index');
        }

        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);

        return view('backend.categories.edit', compact('main_categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,update_categories')) {
            return redirect('admin/index');
        }

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['parent_id'] = $request->parent_id;
        $input['status']    = $request->status;

        if ($image = $request->file('cover')) {

            if ($category->cover != null && File::exists($category->cover)) {
                unlink($category->cover);
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('images/category/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['cover']  = $path;
        }

        $category->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        Alert::success('Category Updated Successfully', 'Success Message');

        return redirect()->route('admin.categories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,delete_categories')) {
            return redirect('admin/index');
        }

        if ($category->cover != null && File::exists($category->cover)) {
            unlink($category->cover);
        }
        $category->delete();

        Alert::success('Category Deleted Successfully', 'Success Message');

        return redirect()->route('admin.categories.index');

    }


    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_categories,delete_categories')) {
            return redirect('admin/index');
        }

        $category = Category::whereId($request->category_id)->first();
        if ($category) {
            if (File::exists($category->cover)) {
                unlink($category->cover);

                $category->cover = null;
                $category->save();
            }
        }
        return true;
    }


    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $category = Category::findorfail($id);
            if (File::exists($category->cover)) :
                unlink($category->cover);
            endif;
            $category->delete();
        }
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function changeStatus(Request $request)
    {
        $category = Category::find($request->cat_id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }

}

