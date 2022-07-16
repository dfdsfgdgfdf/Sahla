@extends('layouts.auth_admin_app')

@section('title', 'الفواتير')

@section('content')

    <div class="container">
        <div class="row mb-5">
            <div class="col-6 d-flex text-left">
                <h1 class=" text-left">فواتير ( {{ $user->full_name }} )</h1>
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
                <table class="table table-bordered table-hover table-striped table-light yajra-datatable">
                    <thead class="table-dark ">
                        <tr class="text-light">
                            <th class="text-light">الرقم</th>
                            <th class="text-light">رقم الفاتورة</th>
                            <th class="text-light">تفاصيل الطلبات</th>
                            <th class="text-light">الفاتورة (PDF)</th>
                            <th class="text-light">تاريخ الفاتورة</th>
                            <th class="text-light">الدفع</th>
                            <th class="text-light">الحالة</th>
{{--                            <th class="text-light">العمليات</th>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $k => $invoice)
                            <tr data-entry-id="{{ $invoice->id }}">
                                <td class="text-center">{{ $loop->index+1 }}</td>
                                <td class="text-center">{{ $invoice->invoice_number }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.merchant_invoices.orders', ['id' => $invoice->id]) }}" target="_blank" >طلبات الفاتورة </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.merchant_invoices.invoices', ['id' => $invoice->id]) }}" target="_blank">عرض الفاتورة </a>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($invoice->created_at)->translatedFormat('l j F Y H:i a') }}</td>
                                <td class="text-center">{{ $invoice->paid == "1" ? 'تم السداد' : 'لم يتم السداد' }}</td>
                                <td class="text-center">{{ $invoice->status == "completed" ? 'مكتملة' : 'غير مكتملة' }}</td>
{{--                                <td class="text-center">--}}
{{--                                    <div style="display: flex" class="text-center justify-content-between">--}}
{{--                                        @ability('superAdmin', 'manage_orders,delete_orders')--}}
{{--                                            <a href="javascript:void(0)"--}}
{{--                                                onclick="--}}
{{--                                                    if (confirm('Are You Sure You Want To Delete This Record ?') )--}}
{{--                                                        { document.getElementById('record_delete_{{ $invoice->id }}').submit(); }--}}
{{--                                                    else--}}
{{--                                                        { return false; }"--}}
{{--                                                class="btn btn-danger"><i class="fa fa-trash"></i>--}}
{{--                                            </a>--}}
{{--                                        @endability--}}
{{--                                    </div>--}}
{{--                                    <form action="{{ route('admin.orders.destroy', $invoice->id) }}" method="post" id="record_delete_{{ $invoice->id }}" class="d-none">--}}
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
                    {!! $invoices->appends(request()->input())->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
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
                order: [],
                scrollX: false,
                dom: 'lBfrtip<"actions">',
            });
        });
    </script>


    <script>
        $(function () {
            $('.status-class').change(function() {
                console.log("success");
                var status = $(this).val();
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.orders.changeStatus') }}',
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
