@extends('layouts.auth_admin_app')

@section('title', 'تعديل محافظة')

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6">
                <h6 class="m-0 font-weight-bold text-primary">تعديل محافظة </h6>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.states.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">المحافظات</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.states.update', $state->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">اسم المحافظة</label>
                            <input type="text" name="name" value="{{ old('name', $state->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="country_id">اسم الدولة</label>
                        <select name="country_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $state->country_id) == $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('country_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <label for="status">حالة المحافظة</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $state->status) == 1 ? 'selected' : null }}>نشط</option>
                            <option value="0" {{ old('status', $state->status) == 0 ? 'selected' : null }}>غير نشط</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
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

