@extends('layouts.auth_admin_app')

@section('title', 'Edit Phone')

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Phone {{ $phone->type }}</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.phones.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Phone</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.phones.update', $phone->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="number">Phone Number</label>
                            <input type="text" name="number" value="{{ old('number', $phone->number) }}" class="form-control">
                            @error('number')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="type">Phone Type</label>
                        <select name="type" class="form-control">
                            <option value="WhatsApp" {{ old('type', $phone->type) == "WhatsApp" ? 'selected' : null }}>WhatsApp</option>
                            <option value="Phone" {{ old('type', $phone->type) == "Phone" ? 'selected' : null }}>Phone</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-4">
                        <label for="status">Phone Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $phone->status) == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status', $phone->status) == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group pt-4 text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Update Phone</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

