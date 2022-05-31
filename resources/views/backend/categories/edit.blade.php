@extends('layouts.auth_admin_app')

@section('title', 'تعديل القسم')

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6">
                <h6 class="m-0 font-weight-bold text-primary">تعديل القسم</h6>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">الأقسام</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name_ar">اسم القسم (العربية)</label>
                            <input type="text" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" class="form-control" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name_en">اسم القسم (الانجليزية)</label>
                            <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" class="form-control" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name_ur">اسم القسم (أوردو)</label>
                            <input type="text" name="name_ur" value="{{ old('name_ur', $category->name_ur) }}" class="form-control" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description_ar">الوصف (العربية)</label>
                            <textarea  name="description_ar" rows="3" class="form-control" required>{{ old('description_ar', $category->description_ar) }}</textarea>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description_en">الوصف (الانجليزية)</label>
                            <textarea  name="description_en" rows="3" class="form-control" required>{{ old('description_en', $category->description_en) }}</textarea>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description_ur">الوصف (أوردو)</label>
                            <textarea  name="description_ur" rows="3" class="form-control" required>{{ old('description_ur', $category->description_ur) }}</textarea>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="parent_id">متفرع من قسم</label>
                        <select name="parent_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($main_categories as $main_category)
                                <option value="{{ $main_category->id }}" {{ old('parent_id', $category->parent_id) == $main_category->id ? 'selected' : null }}>{{ $main_category->name_ar }}</option>
                            @empty

                            @endforelse
                        </select>
                        @error('parent_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-6">
                        <label for="status">الحالة</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : null }}>نشط</option>
                            <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : null }}>غير نشط</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="cover">صورة القسم</label>
                            <input type="file" name="cover" id="category_image" class="file-input-overview">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4 text-center">
                    <button type="submit" name="submit" class="btn btn-primary">تعديل البيانات</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script>
        $(function () {
            $('#category_image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview:[
                    @if ($category->cover != '')
                        "{{asset($category->cover)}}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($category->cover != '')
                    {
                         caption: "{{ $category->cover }}",
                         size: '1000',
                         width: "120px",
                         url: "{{ route('admin.categories.removeImage', ['category_id'=>$category->id, '_token' => csrf_token()]) }}",
                         key: "{{ $category->id }}"
                    },
                    @endif
                ],
            });
        });
    </script>
@endsection
