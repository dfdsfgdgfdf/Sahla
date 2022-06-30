@extends('layouts.auth_admin_app')

@section('title', $information->type.'تعديل ')

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6">
                <h6 class="m-0 font-weight-bold text-primary">{{ $information->type }}</h6>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.informations.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">المعلومات</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.informations.update', $information->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="text_ar">الوصف (العربية)</label>
                            <textarea  name="text_ar" class="form-control" rows="10" required>{{ old('text_ar', $information->text_ar) }}</textarea>
                            @error('text_ar')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="text_en">الوصف (الانجليزية)</label>
                            <textarea  name="text_en" class="form-control" rows="10" required>{{ old('text_en', $information->text_en) }}</textarea>
                            @error('text_en')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="text_ur">الوصف (أوردو)</label>
                            <textarea  name="text_ur" class="form-control" rows="10" required>{{ old('text_ur', $information->text_ur) }}</textarea>
                            @error('text_ur')<span class="text-danger">{{ $message }}</span>@enderror
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

