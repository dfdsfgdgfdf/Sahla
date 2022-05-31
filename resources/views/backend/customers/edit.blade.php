@extends('layouts.auth_admin_app')

@section('title', 'تعديل مستخدم')

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary">تعديل مستخدم </h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">المستخدمين | العملاء</span>
                    </a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.customers.update', $customer->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="first_name">Customer First Name</label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', $customer->first_name) }}" class="form-control">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="last_name">Customer Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}"
                                    class="form-control">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="username">Customer UserName</label>
                                <input type="text" name="username" value="{{ old('username', $customer->username) }}"
                                    class="form-control">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="email">Customer E-Mail</label>
                                <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                    class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="mobile">Customer Mobile</label>
                                <input type="text" name="mobile" value="{{ old('mobile', $customer->mobile) }}"
                                    class="form-control">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="password">Customer Password</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-4">
                            <label for="country_id">الدولة</label>
                            <select name="country_id" class="form-control" id="country_id" required>
                                <option value="">---</option>
                                @if ($customer_address && $customer_address->country_id != '')
                                    @forelse (\App\Models\Country::whereStatus(true)->get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $customer_address->country_id) == $country->id ? 'selected' : null }}>
                                            {{ $country->name }}</option>
                                    @empty
                                    @endforelse
                                @else
                                    @forelse (\App\Models\Country::whereStatus(true)->get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : null }}>
                                            {{ $country->name }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                            @error('country_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="state_id">المحافظة</label>
                            <select name="state_id" id="state_id" class="form-control" required>
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="city_id">المدينة</label>
                            <select name="city_id" id="city_id" class="form-control" required>
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 pt-2">
                            <div class="form-group">
                                <label for="address">تفاصيل العنوان</label>
                                @if ($customer_address && $customer_address->country_id != '')
                                    <textarea name="address" class="form-control" rows="3" placeholder="تفاصيل العنوان"
                                        required>{{ old('address', $customer_address->address) }}</textarea>
                                @else
                                    <textarea name="address" class="form-control" rows="3" placeholder="تفاصيل العنوان"
                                        required>{{ old('address') }}</textarea>
                                @endif
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="zip_code">ZIP Code</label>
                                @if ($customer_address && $customer_address->country_id != '')
                                    <input type="text" name="zip_code" value="{{ old('zip_code', $customer_address->zip_code) }}"
                                        class="form-control">
                                @else
                                    <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                                        class="form-control">
                                @endif
                                @error('zip_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="po_box">POST Code</label>
                                @if ($customer_address && $customer_address->country_id != '')
                                    <input type="text" name="po_box" value="{{ old('po_box', $customer_address->po_box) }}"
                                        class="form-control">
                                @else
                                    <input type="text" name="po_box" value="{{ old('po_box') }}"
                                        class="form-control">
                                @endif
                                @error('po_box')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <label for="status">حالة المستخدم</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $customer->status) == 1 ? 'selected' : null }}>نشط
                                </option>
                                <option value="0" {{ old('status', $customer->status) == 0 ? 'selected' : null }}>غير
                                    نشط</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_image">صورة البروفيل</label>
                                <input type="file" name="user_image" id="category_image" class="file-input-overview">
                                <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                                @error('user_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
        $(function() {
            $('#category_image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($customer->user_image != '')
                        "{{ asset($customer->user_image) }}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($customer->user_image != '')
                        {
                        caption: "{{ $customer->user_image }}",
                        size: '1000',
                        width: "120px",
                        url: "{{ route('admin.customers.removeImage', ['customer_id' => $customer->id, '_token' => csrf_token()]) }}",
                        key: "{{ $customer->id }}"
                        },
                    @endif
                ],
            });
        });
    </script>
    <script>
        $(function() {
            populateStates();
            populateCities();

            $("#country_id").change(function() {
                populateStates();
                populateCities();
                return false;
            });

            $("#state_id").change(function() {
                populateCities();
                return false;
            });

            function populateStates() {
                let countryIdVal = $('#country_id').val() != null ? $('#country_id').val() :
                    '{{ old('country_id', $customer_address->country_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.backend.get_state') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $customer_address->state_id) }}' ? "selected" : "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                    '{{ old('state_id', $customer_address->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.backend.get_city') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $customer_address->city_id) }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
