@extends('layouts.auth_admin_app')

@section('title', 'Create E-Mail')

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create E-Mail</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.emails.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">E-Mail</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.emails.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="type">E-Mail Type</label>
                        <select name="type" class="form-control">
                            <option value="E-Mail" {{ old('type') == "E-Mail" ? 'selected' : null }}>E-Mail</option>
                            <option value="HR" {{ old('type') == "HR" ? 'selected' : null }}>HR</option>
                        </select>
                        @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-4">
                        <label for="status">E-Mail Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group pt-4 text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Add E-Mail</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

