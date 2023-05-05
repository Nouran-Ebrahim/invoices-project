@extends('layouts.master')
@section('title')
    قائمه الفواتير
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتوره</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="panel panel-primary tabs-style-2">
        <div class=" tab-menu-heading">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتوره</a></li>
                    <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                    <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                <div class="tab-pane active" id="tab4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">رقم الفاتورة</th>
                                        <th class="border-bottom-0">تاريخ القاتورة</th>
                                        <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">القسم</th>
                                        <th class="border-bottom-0">الخصم</th>
                                        <th class="border-bottom-0">مبلغ التحصيل</th>
                                        <th class="border-bottom-0">مبلغ العموله</th>
                                        <th class="border-bottom-0">نسبة الضريبة</th>
                                        <th class="border-bottom-0">قيمة الضريبة</th>
                                        <th class="border-bottom-0">الاجمالي</th>
                                        <th class="border-bottom-0">الحاله الحالية</th>
                                        <th class="border-bottom-0">ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $invoices->invoice_number }} </td>
                                        <td>{{ $invoices->invoice_date }}</td>
                                        <td>{{ $invoices->due_date }}</td>
                                        <td>{{ $invoices->product }}</td>
                                        <td>{{ $invoices->section->section_name }}</td>
                                        <td>{{ $invoices->discount }}</td>
                                        <td>{{ $invoices->Amount_collection }}</td>
                                        <td>{{ $invoices->Amount_commission }}</td>
                                        <td>{{ $invoices->rate_vat }}</td>
                                        <td>{{ $invoices->value_vat }}</td>
                                        <td>{{ $invoices->Total }}</td>
                                        <td>
                                            @if ($invoices->value_status == 1)
                                                <span class="text-success">{{ $invoices->status }}</span>
                                            @elseif($invoices->value_status == 2)
                                                <span class="text-danger">{{ $invoices->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoices->status }}</span>
                                            @endif

                                        </td>
                                        <td>{{ $invoices->note }}</td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>رقم الفاتورة</th>
                                        <th>نوع المنتج</th>
                                        <th>القسم</th>
                                        <th>حالة الدفع</th>
                                        <th>تاريخ الدفع </th>
                                        <th>ملاحظات</th>
                                        <th>تاريخ الاضافة </th>
                                        <th>المستخدم</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($details as $detail)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $detail->invoice_number }} </td>
                                            <td>{{ $detail->product }}</td>
                                            <td>{{ $detail->invoice->section->section_name }}</td>
                                            <td>
                                                @if ($detail->value_status == 1)
                                                    <span class="text-success">{{ $detail->status }}</span>
                                                @elseif($detail->value_status == 2)
                                                    <span class="text-danger">{{ $detail->status }}</span>
                                                @else
                                                    <span class="text-warning">{{ $detail->status }}</span>
                                                @endif

                                            </td>
                                            <td>{{ $detail->Payment_Date }}</td>
                                            <td>{{ $detail->note }}</td>
                                            <td>{{ $detail->created_at }}</td>
                                            <td>{{ $detail->user }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab6">
                    <div class="card card-statistics">
                        @can('اضافة مرفق')
                            <div class="card-body">
                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                <h5 class="card-title">اضافة مرفقات</h5>
                                <form method="post" action="{{ url('InvoiceAttachments') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_name"
                                            required>
                                        <input type="hidden" id="customFile" name="invoice_number"
                                            value="{{ $invoices->invoice_number }}">
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoices->id }}">
                                        <label class="custom-file-label" for="customFile">حدد
                                            المرفق</label>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary btn-sm " name="uploadedFile">تاكيد</button>
                                </form>
                            </div>
                        @endcan
                        <br>

                        <div class="table-responsive mt-15">
                            <table class="table center-aligned-table mb-0 table table-hover" style="text-align:center">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">م</th>
                                        <th scope="col">اسم الملف</th>
                                        <th scope="col">قام بالاضافة</th>
                                        <th scope="col">تاريخ الاضافة</th>
                                        <th scope="col">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($attachments as $attachment)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $attachment->file_name }}</td>
                                            <td>{{ $attachment->created_by }}</td>
                                            <td>{{ $attachment->created_at }}</td>
                                            <td colspan="2">

                                                <a class="btn btn-outline-success btn-sm"
                                                    href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                    role="button"><i class="fas fa-eye"></i>&nbsp;
                                                    عرض</a>

                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                    role="button"><i class="fas fa-download"></i>&nbsp;
                                                    تحميل</a>

                                                @can('حذف المرفق')
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                        data-file_name="{{ $attachment->file_name }}"
                                                        data-invoice_number="{{ $attachment->invoice_number }}"
                                                        data-id_file="{{ $attachment->id }}"
                                                        data-target="#delete_file">حذف</button>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- delete -->
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('delete_file') }}" method="post">

                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p class="text-center">
                                <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                </p>

                                <input type="hidden" name="id_file" id="id_file" value="">
                                <input type="hidden" name="file_name" id="file_name" value="">
                                <input type="hidden" name="invoice_number" id="invoice_number" value="">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
