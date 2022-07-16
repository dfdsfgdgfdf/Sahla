@extends('layouts.auth_admin_app')

@section('title', 'الفواتير المعلقة')

@section('style')
    <style>
        table.dataTable tbody td.select-checkbox:before,
        table.dataTable tbody th.select-checkbox:before {
            content: " ";
            margin-top: 22px;
            margin-left: 0;
            bpendingInvoice: 1px solid darkblue;
            bpendingInvoice-radius: 3px;
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
        <div class="row mb-5">
            <div class="col-6 d-flex text-left">
                <h1 class=" text-left">الفواتير المعلقة</h1>
            </div>
            <div class="col-6 d-flex justify-content-end">
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col-12">
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-12">
                <table class="table table-bpendingInvoiceed table-hover table-striped table-light yajra-datatable">
                    <thead class="table-dark ">
                        <tr class="text-light">
                            <th class="text-light">الرقم</th>
                            <th class="text-light">رقم الفاتورة</th>
                            <th class="text-light">بيانات الشخص</th>
                            <th class="text-light">تفاصيل الطلبات</th>
                            <th class="text-light">الفاتورة (PDF)</th>
                            <th class="text-light">تاريخ الفاتورة</th>
                            <th class="text-light">الحالة</th>
{{--                            <th class="text-light">العمليات</th>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingInvoices as $k => $pendingInvoice)
                            <tr data-entry-id="{{ $pendingInvoice->id }}">
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $pendingInvoice->invoice_number }}</td>
                                <td>
                                    <strong>{!! $pendingInvoice->user_id != '' ? $pendingInvoice->user->full_name : '' !!}</strong> <br>
                                    {{ $pendingInvoice->user->mobile }} <br>
                                    {{ $pendingInvoice->user->email }}
                                </td>
                                <td class="text-center">
{{--                                    <a href="{{ route('admin.orders.show', $pendingInvoice) }}" >عرض محتويات الطلب </a>--}}
                                    <a href="{{ route('admin.orders.showInvoiceOrdersTable', $pendingInvoice->id) }}" target="_blank" >طلبات الفاتورة </a>

                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.showInvoiceOrdersPdf', $pendingInvoice->id) }}" >عرض الفاتورة </a>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($pendingInvoice->created_at)->translatedFormat('l j F Y H:i a') }}</td>
                                <td class="text-center">
                                    {{ $pendingInvoice->paid != 1 ? 'لم تسدد' : 'تم السداد' }}
                                </td>
{{--                                <td class="text-center">--}}
{{--                                    <div style="display: flex" class="text-center justify-content-between">--}}
{{--                                        @ability('superAdmin', 'manage_orders')--}}
{{--                                            <a href="javascript:void(0)"--}}
{{--                                                onclick="--}}
{{--                                                    if (confirm('Are You Sure You Want To Delete This Record ?') )--}}
{{--                                                        { document.getElementById('record_delete_{{ $pendingInvoice->id }}').submit(); }--}}
{{--                                                    else--}}
{{--                                                        { return false; }"--}}
{{--                                                class="btn btn-danger"><i class="fa fa-trash"></i>--}}
{{--                                            </a>--}}
{{--                                        @endability--}}
{{--                                    </div>--}}
{{--                                    <form action="{{ route('admin.pendingInvoices.destroy', $pendingInvoice->id) }}" method="post" id="record_delete_{{ $pendingInvoice->id }}" class="d-none">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                    </form>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $pendingInvoices->appends(request()->input())->links() !!}
                </div>
            </div>
        </div>
    </div>
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
                    pendingInvoiceable: false,
                    className: 'select-checkbox',
                    targets: 0
                }, {
                    pendingInvoiceable: false,
                    searchable: false,
                    targets: -1
                }],
                select: {
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                pendingInvoice: [],
                scrollX: false,
                dom: 'lBfrtip<"actions">',
                buttons: [
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
                    {{--{--}}
                    {{--    className: 'btn btn-light-danger px-6 font-weight-bold',--}}
                    {{--    text: 'Delete All',--}}
                    {{--    url: "{{ route('admin.pendingInvoices.massDestroy') }}",--}}
                    {{--    action: function(e, dt, node, config) {--}}

                    {{--        var ids = $.map(dt.rows({--}}
                    {{--            selected: true--}}
                    {{--        }).nodes(), function(entry) {--}}
                    {{--            return $(entry).data('entry-id')--}}
                    {{--        });--}}

                    {{--        if (ids.length === 0) {--}}
                    {{--            Swal.fire('No Data Selected')--}}
                    {{--            return--}}
                    {{--        }--}}
                    {{--        Swal.fire({--}}
                    {{--            title: 'Do You Want To Save This Changes?',--}}
                    {{--            showDenyButton: true,--}}
                    {{--            showCancelButton: true,--}}
                    {{--            confirmButtonText: 'Save',--}}
                    {{--            denyButtonText: `Don't save`,--}}
                    {{--        }).then((result) => {--}}
                    {{--            /* Read more about isConfirmed, isDenied below */--}}
                    {{--            if (result.isConfirmed) {--}}
                    {{--                $.ajaxSetup({--}}
                    {{--                    headers: {--}}
                    {{--                        'X-CSRF-TOKEN': $(--}}
                    {{--                            'meta[name="csrf-token"]').attr(--}}
                    {{--                            'content')--}}
                    {{--                    }--}}
                    {{--                })--}}
                    {{--                $.ajax({--}}
                    {{--                        // headers: {'x-csrf-token': _token},--}}
                    {{--                        method: 'POST',--}}
                    {{--                        url: config.url,--}}
                    {{--                        data: {--}}
                    {{--                            ids: ids,--}}
                    {{--                            _method: 'POST'--}}
                    {{--                        }--}}
                    {{--                    })--}}
                    {{--                    .done(function() {--}}
                    {{--                        location.reload()--}}
                    {{--                    })--}}
                    {{--                Swal.fire('Saved!', '', 'success')--}}
                    {{--            } else if (result.isDenied) {--}}
                    {{--                Swal.fire('Changes are not saved', '', 'info')--}}
                    {{--            }--}}
                    {{--        })--}}
                    {{--    }--}}
                    {{--}--}}
                ],
            });
        });
    </script>


{{--    <script>--}}
{{--        $(function () {--}}
{{--            $('.status-class').change(function() {--}}
{{--                console.log("success");--}}
{{--                var status = $(this).val();--}}
{{--                var cat_id = $(this).data('id');--}}

{{--                $.ajax({--}}
{{--                    type: "GET",--}}
{{--                    dataType: "json",--}}
{{--                    url: '{{ route('admin.pendingInvoices.changeStatus') }}',--}}
{{--                    data: {--}}
{{--                        'status': status,--}}
{{--                        'cat_id': cat_id--}}
{{--                    },--}}
{{--                    success: function(data) {--}}
{{--                        Swal.fire({--}}
{{--                            title: 'Status Change Successfully',--}}
{{--                            showClass: {--}}
{{--                                popup: 'animate__animated animate__fadeInDown'--}}
{{--                            },--}}
{{--                            hideClass: {--}}
{{--                                popup: 'animate__animated animate__fadeOutUp'--}}
{{--                            }--}}
{{--                        })--}}
{{--                    }--}}
{{--                });--}}
{{--            })--}}
{{--        });--}}
{{--    </script>--}}


@endsection
