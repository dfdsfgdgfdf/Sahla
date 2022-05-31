@extends('layouts.auth_admin_app')

@section('title', 'انشاء منتج جديد')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6">
                <h3 class="m-0 font-weight-bold text-primary">{{__('انشاء منتج جديد') }}</h3>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">{{__('المنتجات') }}</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name_ar">اسم القسم (العربية)</label>
                            <input type="text" name="name_ar" value="{{ old('name') }}" class="form-control" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name_en">اسم القسم (الانجليزية)</label>
                            <input type="text" name="name_en" value="{{ old('name') }}" class="form-control" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name_ur">اسم القسم (أوردو)</label>
                            <input type="text" name="name_ur" value="{{ old('name') }}" class="form-control" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description_ar">الوصف (العربية)</label>
                            <textarea  name="description_ar" rows="5" class="form-control" required>{{ old('description_ar') }}</textarea>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description_en">الوصف (الانجليزية)</label>
                            <textarea  name="description_en" rows="5" class="form-control" required>{{ old('description_en') }}</textarea>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description_ur">الوصف (أوردو)</label>
                            <textarea  name="description_ur" rows="5" class="form-control" required>{{ old('description_ur') }}</textarea>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-3">
                        <label for="category_id">القسم التابع له</label>
                        <select name="category_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : null }}>{{ $category->name_ar }}
                                </option>
                            @empty

                            @endforelse
                        </select>
                        @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="stock">الكمية الموجودة بالمخازن</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" class="form-control" min="0">
                        @error('stock')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <label for="status">الحالة</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="featured">منتج مميز</label>
                        <select name="featured" class="form-control">
                            <option value="1" {{ old('featured') == 1 ? 'selected' : null }}>مميز</option>
                            <option value="0" {{ old('featured') == 0 ? 'selected' : null }}>عادي</option>
                        </select>
                        @error('featured')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-3">
                        <label for="quantity">الكمية</label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control" min="0">
                        @error('quantity')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="unit_id">الوحدة</label>
                        <select name="unit_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id') == $unit->id ? 'selected' : null }}>{{ $unit->name_ar }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('unit_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <label for="price">السعر</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="form-control"  min="0">
                        @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="currency">العملة</label>
                        @include('backend.products.currency_create')
                        @error('currency')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4 mt-4">
                    <div class="col-12">
                        <div class="form-group file-loading">
                            <label for="images">Product Images</label>
                            <input type="file" name="images[]" id="product_images" class="file-input-overview" multiple="multiple">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            @error('images')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4 text-center">
                    <button type="submit" name="submit" class="btn btn-primary">حفظ البيانات</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` should be the term that is used for searching
            // `data.text` is the text that is displayed for the data object
            if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.text += ' (matched)';

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(".select2").select2({
            tags:true,
            closeOnSelect: false,
            minimumResultForsearch: Infinity,
            matcher: matchCustom
        });

        $(function() {
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#product_images').fileinput({
                theme: "fas",
                maxFileCount: 10,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });
        });
    </script>
@endsection
