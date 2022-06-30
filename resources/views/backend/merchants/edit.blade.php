@extends('layouts.auth_admin_app')

@section('title', 'تعديل تاجر')

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary">تعديل تاجر </h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.merchants.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">التجار</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.merchants.update', $merchant->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="first_name">الاسم الاول</label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', $merchant->first_name) }}" class="form-control">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="last_name">الاسم الاخير</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $merchant->last_name) }}"
                                    class="form-control">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="username">اسم التاجر</label>
                                <input type="text" name="username" value="{{ old('username', $merchant->username) }}"
                                    class="form-control">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price">أقصي سعر لفاتورة الشراء</label>
                                <input type="number" name="max_limit" value="{{ old('max_limit', $merchant_max_limit->max_limit) }}" class="form-control"  min="0">
                                @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="email">البريد الالكتروني</label>
                                <input type="email" name="email" value="{{ old('email', $merchant->email) }}"
                                    class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="mobile">رقم الهاتف</label>
                                <input type="text" name="mobile" value="{{ old('mobile', $merchant->mobile) }}"
                                    class="form-control">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="password">كلمة المرور</label>
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
                            <select name="country_id" class="form-control" id="country_id">
                                <option value="">---</option>
                                @if ($merchant_address && $merchant_address->country_id != '')
                                    @forelse (\App\Models\Country::whereStatus(true)->get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $merchant_address->country_id) == $country->id ? 'selected' : null }}>
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
                            <select name="state_id" id="state_id" class="form-control">
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="city_id">المدينة</label>
                            <select name="city_id" id="city_id" class="form-control">
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 pt-2">
                            <div class="form-group">
                                <label for="address">تفاصيل العنوان</label>
                                @if ($merchant_address && $merchant_address->country_id != '')
                                    <textarea name="address" class="form-control" rows="3" placeholder="تفاصيل العنوان">{{ old('address', $merchant_address->address) }}</textarea>
                                @else
                                    <textarea name="address" class="form-control" rows="3" placeholder="تفاصيل العنوان">{{ old('address') }}</textarea>
                                @endif
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="zip_code">ZIP Code</label>
                                @if ($merchant_address && $merchant_address->country_id != '')
                                    <input type="text" name="zip_code" value="{{ old('zip_code', $merchant_address->zip_code) }}"
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
                                @if ($merchant_address && $merchant_address->country_id != '')
                                    <input type="text" name="po_box" value="{{ old('po_box', $merchant_address->po_box) }}"
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
                            <label for="status">حالة التاجر</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $merchant->status) == 1 ? 'selected' : null }}>نشط
                                </option>
                                <option value="0" {{ old('status', $merchant->status) == 0 ? 'selected' : null }}>غير
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
                    @if ($merchant->user_image != '')
                        "{{ asset($merchant->user_image) }}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($merchant->user_image != '')
                        {
                        caption: "{{ $merchant->user_image }}",
                        size: '1000',
                        width: "120px",
                        url: "{{ route('admin.merchants.removeImage', ['merchant_id' => $merchant->id, '_token' => csrf_token()]) }}",
                        key: "{{ $merchant->id }}"
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
                    '{{ old('country_id', $merchant_address && $merchant_address->country_id != "" ? $merchant_address->country_id : "" ) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.backend.get_state') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $merchant_address && $merchant_address->state_id != "" ? $merchant_address->state_id : "" ) }}' ? "selected" : "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                    '{{ old('state_id', $merchant_address && $merchant_address->state_id != "" ? $merchant_address->state_id : "" ) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.backend.get_city') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $merchant_address && $merchant_address->city_id != "" ? $merchant_address->city_id : "" ) }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
