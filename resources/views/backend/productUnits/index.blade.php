@extends('layouts.auth_admin_app')

@section('title', 'أوزان المنتجات')

@section('style')
    <style>
        table.dataTable tbody td.select-checkbox:before,
        table.dataTable tbody th.select-checkbox:before {
            content: " ";
            margin-top: 22px;
            margin-left: 0;
            border: 1px solid darkblue;
            border-radius: 3px;
        }

        table.dataTable tr.selected td.select-checkbox:after,
        table.dataTable tr.selected th.select-checkbox:after {
            content: "✓";
            font-size: 20px;
            margin-top: 6px;
            margin-left: 0px;
            text-align: center;
            text-shadow: 1px 1px #b0bed9, -1px -1px #b0bed9, 1px -1px #b0bed9, -1px 1px #b0bed9;
        }
    </style>
@endsection

@section('content')


    <div class="container">
        <div class="row ">
            <div class="col-6 d-flex text-left">
                <h1 class=" text-left">أوزان المنتجات</h1>
            </div>
            <div class="col-6 d-flex justify-content-end">
                @ability('superAdmin', 'manage_products,create_products')
                <a href="javascript:void(0);" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target=".bd-example-modal-lg">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opaphone="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    عنصر جديد
                </a>
                @endability
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal fade bd-example-modal-lg">اضافة أسعار أوزان أخري لهذا المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.productUnits.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3"><label for="unit_id">الوحدة</label></div>
                                <div class="col-3"><label for="price">السعر</label></div>
                                <div class="col-3"><label for="currency">العملة</label></div>
                                <div class="col-3"><label for="status">الحالة</label></div>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}" >
                                <div class="repeater">
                                    <div data-repeater-list="List_Classes">
                                        <div data-repeater-item>
                                            <div class="row">
                                   <div class="col-3">
                                       <label for="unit_id"></label>
                                       <select name="unit_id" class="form-control">
                                           <option value="">---</option>
                                            @foreach($units as $unit)
                                                @php $is_unit = \App\Models\ProductUnit::whereProductId($product->id)->whereUnitId($unit->id)->first() @endphp
                                                @if(empty($is_unit))
                                                    <option value="{{ $unit->id }}" {{ old('unit_id') ==  $unit->id  ? 'selected' : null }}>{{ $unit->name_ar }}</option>
                                               @endif
                                           @endforeach
                                       </select>
                                       @error('unit_id')<span class="text-danger">{{ $message }}</span>@enderror
                                   </div>
                                   <div class="col-3">
                                       <label for="price"></label>
                                       <input type="number" name="price" value="{{ old('price') }}" class="form-control"  min="1">
                                       @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                                   </div>
                                   <div class="col-3">
                                       <label for="currency"></label>
                                       @include('backend.products.currency_create')
                                       @error('currency')<span class="text-danger">{{ $message }}</span>@enderror
                                   </div>
                                   <div class="col-3">
                                       <label for="status"></label>
                                       <select name="status" class="form-control">
                                           <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                                           <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                                       </select>
                                       @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                   </div>
                               </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">إغلاق</button>
                            <button type="submit" name="submit" class="btn btn-primary font-weight-bold">حفظ البيانات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('backend.productUnits.filter')

        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover table-striped table-light yajra-datatable">
                    <thead class="table-dark ">
                    <tr class="text-light">
                        <th class="text-light">الرقم</th>
                        <th class="text-light">الوزن</th>
                        <th class="text-light">السعر</th>
                        <th class="text-light">العملة</th>
                        <th class="text-light">الحالة</th>
                        <th class="text-light">العمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($productUnits as $k => $productUnit)
                        <tr data-entry-id="{{ $productUnit->id }}">
                            <td>{{ $loop->index+1 }}</td>
                            <td class="text-center">{{ $productUnit->unit->name_ar }}</td>
                            <td class="text-center">{{ $productUnit->price }}</td>
                            <td class="text-center">{{ $productUnit->currency }}</td>
                            <td class="text-center">
                                    <span class="switch switch-icon">
                                        <label>
                                            <input data-id="{{ $productUnit->id }}" class="status-class" type="checkbox"
                                                   data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On"
                                                   data-width="40" data-height="30" data-off="Off"
                                                {{ $productUnit->status == 1 ? 'checked' : '' }}>
                                            <span></span>
                                        </label>
                                    </span>
                            </td>
                            <td class="text-center">
                                <div style="display: flex" class="text-center justify-content-between">
                                    {{--                                        @ability('superAdmin', 'manage_productUnits,update_productUnits')--}}
                                    {{--                                            <a href="{{ route('admin.productUnits.edit', $productUnit->id) }}"--}}
                                    {{--                                                class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i>--}}
                                    {{--                                            </a>--}}
                                    {{--                                        @endability--}}

                                    {{-- @ability('superAdmin', 'manage_productUnits,show_productUnits')
                                        <a href="{{ route('admin.productUnits.show', $productUnit->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                    @endability --}}

                                    @ability('superAdmin', 'manage_productUnits,delete_productUnits')
                                    <a href="javascript:void(0)"
                                       onclick="
                                                    if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                        { document.getElementById('record_delete_{{ $productUnit->id }}').submit(); }
                                                    else
                                                        { return false; }"
                                       class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                    @endability
                                </div>
                                <form action="{{ route('admin.productUnits.destroy', $productUnit->id) }}" method="post" id="record_delete_{{ $productUnit->id }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $productUnits->appends(request()->input())->links() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.status-class').change(function() {
                console.log("success");
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.productUnits.changeStatus') }}',
                    data: {
                        'status': status,
                        'cat_id': cat_id
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Status Change Successfully',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        })
                    }
                });
            })
        });
    </script>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

    <script type="text/javascript">
        $(function() {
            let languages = {
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };
            var table = $('.yajra-datatable').DataTable({
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }, {
                    orderable: false,
                    searchable: false,
                    targets: -1
                }],
                select: {
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: false,
                dom: 'lBfrtip<"actions">',
                buttons: [{
                    extend: 'copy',
                    className: 'btn btn-light-primary px-6 font-weight-bold ml-20',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                    {
                        extend: 'csv',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-light-warning px-6 font-weight-bold',
                        text: 'Printf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-light-success px-6 font-weight-bold',
                        text: 'Column Visible',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                    },
                    {
                        className: 'btn btn-light-danger px-6 font-weight-bold',
                        text: 'Delete All',
                        url: "{{ route('admin.productUnits.massDestroy') }}",
                        action: function(e, dt, node, config) {

                            var ids = $.map(dt.rows({
                                selected: true
                            }).nodes(), function(entry) {
                                return $(entry).data('entry-id')
                            });

                            if (ids.length === 0) {
                                Swal.fire('No Data Selected')
                                return
                            }
                            Swal.fire({
                                title: 'Do You Want To Save This Changes?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Save',
                                denyButtonText: `Don't save`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]').attr(
                                                'content')
                                        }
                                    })
                                    $.ajax({
                                        // headers: {'x-csrf-token': _token},
                                        method: 'POST',
                                        url: config.url,
                                        data: {
                                            ids: ids,
                                            _method: 'POST'
                                        }
                                    })
                                        .done(function() {
                                            location.reload()
                                        })
                                    Swal.fire('Saved!', '', 'success')
                                } else if (result.isDenied) {
                                    Swal.fire('Changes are not saved', '', 'info')
                                }
                            })
                        }
                    }
                ],
            });
        });
    </script>


    <script>
        $(function () {
            $('.status-class').change(function() {
                console.log("success");
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.productUnits.changeStatus') }}',
                    data: {
                        'status': status,
                        'cat_id': cat_id
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Status Change Successfully',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        })
                    }
                });
            })
        });
    </script>


@endsection
