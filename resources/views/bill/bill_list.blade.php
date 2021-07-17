@extends((Auth::user()->is_admin == 1) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bill List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Bill List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('bill.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Create Bill
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bill_no_filter">Bill No</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="bill_no_filter" id="bill_no_filter">
                                            <option value="">Select Bill</option>
                                            @foreach($bill_nos as $bill_no)
                                                <option value="{{ $bill_no->bill_no }}">{{ $bill_no->bill_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="po_no_filter">PO</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="po_no_filter" id="po_no_filter">
                                            <option value="">Select PO</option>
                                            @foreach($po_nos as $po_no)
                                                <option value="{{ $po_no->po_no }}">{{ $po_no->po_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="plant_filter">Plant</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="plant_filter" id="plant_filter">
                                            <option value="">Select Plant</option>
                                            @foreach($plants as $plant)
                                                <option value="{{ $plant->id }}">{{ $plant->plant_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="party_filter">Party</label>
                                        <input type="text" class="form-control" id="party_filter">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cheque_no_filter">Cheque No</label>
                                        <input type="text" class="form-control" id="cheque_no_filter">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bill_status_filter">Bill Status</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="bill_status_filter" id="bill_status_filter">
                                            <option value="">Select Status</option>
                                            <option value="100">Return to AP</option>
                                            <option value="200">Receipt by TR</option>
                                            <option value="300">Payment Proposal</option>
                                            <option value="301">Payment Approve</option>
                                            <option value="400">Check Printed</option>
                                            <option value="401">Cheque Handover</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Bill Date Range <span class="badge badge-danger" onclick="return $('#bill_date_range_filter').val('');"><i class="far fa-calendar-times"></i></span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" autocomplete="off" class="form-control float-right reservationtime" id="bill_date_range_filter">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">TR Receipt Date Range <span class="badge badge-danger" onclick="return $('#receipt_date_range_filter').val('');"><i class="far fa-calendar-times"></i></span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" class="form-control float-right reservationtime" id="receipt_date_range_filter">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Cheque Handover Date Range <span class="badge badge-danger" onclick="return $('#cheque_handover_date_range_filter').val('');"><i class="far fa-calendar-times"></i></span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" class="form-control float-right reservationtime" id="cheque_handover_date_range_filter">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="search_btn"><span style="color: #ffffff;">.</span></label>
                                        <button class="form-control btn btn-primary" id="search_btn" onclick="searchBills()">SEARCH</button>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1">
                                    <label for=""><span style="color: #ffffff;">.</span></label>
                                    <div class="loader" style="display: none;"></div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            </div>
                        </div>
                    <button class="btn btn-secondary" style="color: #FFF;" onclick="ExportToExcel('table_id')"><b>Export Excel</b></button>
                        <div class="card-body table-responsive p-0">
                            <table id="table_id" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        {{--<th>SL</th>--}}
                                        <th>Action</th>
                                        <th>Track#</th>
                                        <th>Party</th>
                                        <th>PO#</th>
                                        <th>Bill#</th>
                                        <th>Bill Date</th>
                                        <th>Gross Value</th>
                                        <th>Curr</th>
                                        <th>Plant</th>
                                        <th>Cheque#</th>
                                        <th>Status</th>
                                        <th>AP-Return</th>
                                        <th>TR-Receipt</th>
                                        <th>Payment Proposal</th>
                                        <th>Payment Approval</th>
                                        <th>Cheque Print</th>
                                        <th>Handover</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_id">
                                    @foreach($bills as $k => $bill)
                                        <tr>
                                            {{--<td>{{ $k+1 }}</td>--}}
                                            <td>
                                                <a href="{{ route('bill.edit', $bill->id) }}" class="btn btn-xs btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($bill->status == 100)
                                                    <span class="btn btn-xs btn-warning" title="TR Receipt" onclick="receiptByTRModal('{{ $bill->id }}')">
                                                        TR~Receipt
                                                    </span>
                                                @elseif($bill->status == 200)
                                                    <span class="btn btn-xs btn-warning" title="Payment Proposal" onclick="paymentProposalModal('{{ $bill->id }}')">
                                                        Proposal
                                                    </span>
                                                    <span class="btn btn-xs btn-danger" title="Return to AP" onclick="returnToAPModal('{{ $bill->id }}')">
                                                        AP~Return
                                                    </span>
                                                @elseif($bill->status == 300)
                                                    <span class="btn btn-xs btn-success" title="Payment Approve" onclick="paymentApprovalModal('{{ $bill->id }}')">
                                                        Approve
                                                    </span>
                                                @elseif($bill->status == 301)
                                                    <span class="btn btn-xs btn-info" title="Cheque Print" onclick="chequePrintModal('{{ $bill->id }}', '{{ $bill->bill_no }}')">
                                                        Cheque
                                                    </span>
                                                @elseif($bill->status == 400)
                                                    <span class="btn btn-xs btn-info" title="Cheque Handover" onclick="chequeHandoverModal('{{ $bill->id }}')">
                                                        Handover
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $bill->tracking_no }}</td>
                                            <td>{{ $bill->party_name }}</td>
                                            <td>{{ $bill->po_no }}</td>
                                            <td>{{ $bill->bill_no }}</td>
                                            <td>{{ $bill->bill_date }}</td>
                                            <td>{{ $bill->bill_gross_value }}</td>
                                            <td>{{ $bill->currency->currency }}</td>
                                            <td>{{ $bill->plant->plant_name }}</td>
                                            <td>{{ $bill->cheque_no }}</td>
                                            <td>
                                                @if($bill->status == 100)
                                                    Return to AP
                                                @elseif($bill->status == 200)
                                                    Receipt by TR
                                                @elseif($bill->status == 300)
                                                    Payment Proposal
                                                @elseif($bill->status == 301)
                                                    Approved for Payment
                                                @elseif($bill->status == 400)
                                                    Check Printed
                                                @elseif($bill->status == 401)
                                                    Check Handover
                                                @endif
                                            </td>
                                            <td>
                                                {!! $bill->return_to_ap_date !!}
                                             </td>
                                            <td>
                                                {!! $bill->receipt_date_by_tr !!}
                                            </td>
                                            <td>
                                                {!! $bill->payment_proposal_date !!}
                                            </td>
                                            <td>
                                                {!! $bill->approved_for_payment_date !!}
                                            </td>
                                            <td>
                                                {!! $bill->cheque_print_date !!}
                                            </td>
                                            <td>
                                                {!! $bill->cheque_handover_date !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6 offset-lg-3 d-flex">
                    <ul class="pagination mx-auto">
                        {{ $bills->links() }}
                    </ul>
                </div>
            </div>

        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cheque Print</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bill_no">Bill No: </label>
                            <input type="text" class="form-control" id="bill_no" name="bill_no" readonly="readonly">
                            <input type="hidden" class="form-control" id="bill_id" name="bill_id" readonly="readonly">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cheque_no">Cheque No <span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="cheque_no" name="cheque_no">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="chequePrint()">SAVE</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Return to AP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="return_to_ap_remarks">Remarks</label>
                            <textarea class="form-control" id="return_to_ap_remarks" name="return_to_ap_remarks"></textarea>
                            <input type="hidden" class="form-control" id="bill_id_return_to_ap" name="bill_id_return_to_ap">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="returnToAP()">SAVE</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg-2">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Are You Sure to Receipt by TR?</h5>
                            <input type="hidden" class="form-control" id="bill_id_receipt_by_tr" name="bill_id_receipt_by_tr">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" onclick="receiptByTR()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg-3">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Are You Sure to Payment Proposal?</h5>
                            <input type="hidden" class="form-control" id="bill_id_payment_proposal" name="bill_id_payment_proposal">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" onclick="paymentProposal()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg-4">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Are You Sure to Approve Payment Proposal?</h5>
                            <input type="hidden" class="form-control" id="bill_id_approve_payment_proposal" name="bill_id_approve_payment_proposal">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" onclick="paymentApproval()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg-5">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Are You Sure to Handover Cheque?</h5>
                            <input type="hidden" class="form-control" id="bill_id_cheque_handover" name="bill_id_cheque_handover">
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" onclick="chequeHandover()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg-6">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5 id="warning_message">No Options are Selected!</h5>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">


    function returnToAPModal(bill_id) {
        $("#bill_id_return_to_ap").val(bill_id);

        $("#modal-lg-1").modal('show');
    }

    function returnToAP() {
        var bill_id = $("#bill_id_return_to_ap").val();
        var return_to_ap_remarks = $("#return_to_ap_remarks").val();

        $.ajax({
            url: "{{ route("return_to_ap") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", bill_id: bill_id, return_to_ap_remarks: return_to_ap_remarks},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    $("#bill_id_return_to_ap").val('');
                    $("#return_to_ap_remarks").val('');
                    $("#modal-lg-1").modal('hide');
                    $("#search_btn").click();
                }
            }
        });
    }

    function receiptByTRModal(bill_id) {
        $("#bill_id_receipt_by_tr").val(bill_id);

        $("#modal-lg-2").modal('show');
    }

    function receiptByTR() {
        var bill_id = $("#bill_id_receipt_by_tr").val();

        $.ajax({
            url: "{{ route("receipt_by_tr") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", bill_id: bill_id},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    $("#bill_id_receipt_by_tr").val('');
                    $("#modal-lg-2").modal('hide');
                    $("#search_btn").click();
                }
            }
        });
    }

    function paymentProposalModal(bill_id) {
        $("#bill_id_payment_proposal").val(bill_id);

        $("#modal-lg-3").modal('show');
    }

    function paymentProposal() {
        var bill_id = $("#bill_id_payment_proposal").val();

        $.ajax({
            url: "{{ route("payment_proposal") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", bill_id: bill_id},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    $("#bill_id_payment_proposal").val('');
                    $("#modal-lg-3").modal('hide');
                    $("#search_btn").click();
                }
            }
        });
    }

    function paymentApprovalModal(bill_id) {
        $("#bill_id_approve_payment_proposal").val(bill_id);

        $("#modal-lg-4").modal('show');
    }

    function paymentApproval() {
        var bill_id = $("#bill_id_approve_payment_proposal").val();

        $.ajax({
            url: "{{ route("payment_approval") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", bill_id: bill_id},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    $("#bill_id_approve_payment_proposal").val('');
                    $("#modal-lg-4").modal('hide');
                    $("#search_btn").click();
                }
            }
        });
    }

    function chequePrintModal(bill_id, bill_no) {
        $("#bill_no").val(bill_no);
        $("#bill_id").val(bill_id);
        $("#cheque_no").val('');

        $("#modal-lg").modal('show');
    }

    function chequePrint() {
        var bill_id = $("#bill_id").val();
        var cheque_no = $("#cheque_no").val();

        if(cheque_no != ''){
            $.ajax({
                url: "{{ route("cheque_print") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", bill_id: bill_id, cheque_no: cheque_no},
                dataType: "html",
                success: function (data) {
                    if(data == 'done'){
                        $("#bill_id").val('');
                        $("#cheque_no").val('');
                        $("#modal-lg").modal('hide');
                        $("#search_btn").click();
                    }
                }
            });
        }else{
            $("#modal-lg").modal('hide');
            $("#warning_message").text('Please Input the Cheque Information!');
            $("#modal-lg-6").modal('show');
        }

    }

    function chequeHandoverModal(bill_id) {
        $("#bill_id_cheque_handover").val(bill_id);

        $("#modal-lg-5").modal('show');
    }
    
    function chequeHandover() {
        var bill_id = $("#bill_id_cheque_handover").val();

        $.ajax({
            url: "{{ route("cheque_handover") }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}", bill_id: bill_id},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    $("#bill_id_cheque_handover").val('');
                    $("#modal-lg-5").modal('hide');
                    $("#search_btn").click();
                }
            }
        });
    }

    function searchBills() {
        var bill_no = $("#bill_no_filter").val();
        var po_no = $("#po_no_filter").val();
        var plant_id = $("#plant_filter").val();
        var cheque_no = $("#cheque_no_filter").val();
        var bill_status = $("#bill_status_filter").val();
        var party_name = $("#party_filter").val();

//        Bill Date Range Start
        var bill_dt_range_filter = $("#bill_date_range_filter").val();
        var bill_date_range_filter = bill_dt_range_filter.split(" - ");

        var bill_date_from = bill_date_range_filter[0];
        var bill_date_to = (bill_date_range_filter[1] != undefined ? bill_date_range_filter[1] : '');
//        Bill Date Range End

//        Receipt Date Range Start
        var receipt_dt_range_filter = $("#receipt_date_range_filter").val();
        var receipt_date_range_filter = receipt_dt_range_filter.split(" - ");

        var receipt_date_from = receipt_date_range_filter[0];
        var receipt_date_to = (receipt_date_range_filter[1] != undefined ? receipt_date_range_filter[1] : '');
//        Receipt Date Range End

//        Cheque Handover Date Range Start
        var cheque_handover_dt_range_filter = $("#cheque_handover_date_range_filter").val();
        var cheque_handover_date_range_filter = cheque_handover_dt_range_filter.split(" - ");

        var cheque_handover_date_from = cheque_handover_date_range_filter[0];
        var cheque_handover_date_to = (cheque_handover_date_range_filter[1] != undefined ? cheque_handover_date_range_filter[1] : '');
//        Cheque Handover Date Range End


//        if(bill_no=='' && po_no=='' && party_name=='' && plant_id=='' && cheque_no=='' && bill_status=='' && bill_date_from=='' && bill_date_to==undefined && receipt_date_from=='' && receipt_date_to==undefined && cheque_handover_date_from=='' && cheque_handover_date_to==undefined){
//            $("#modal-lg-6").modal('show');
//        }else{
            $(".loader").css('display', 'block');
            $("#tbody_id").empty();

            $.ajax({
                url: "{{ route("search_bill") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", bill_no: bill_no, po_no: po_no, party_name: party_name, plant_id: plant_id, cheque_no: cheque_no, status: bill_status, bill_date_from: bill_date_from, bill_date_to: bill_date_to, receipt_date_from: receipt_date_from, receipt_date_to: receipt_date_to, cheque_handover_date_from: cheque_handover_date_from, cheque_handover_date_to: cheque_handover_date_to},
                dataType: "html",
                success: function (data) {
                    $("#tbody_id").append(data);
                    $(".loader").css('display', 'none');
                }
            });
//        }

    }

    function ExportToExcel(tableid) {
        var tab_text = "<table border='2px'><tr>";
        var textRange; var j = 0;
        tab = document.getElementById(tableid);//.getElementsByTagName('table'); // id of table
        if (tab==null) {
            return false;
        }
        if (tab.rows.length == 0) {
            return false;
        }

        for (j = 0 ; j < tab.rows.length ; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "download.xls");
        }
        else                 //other browser not tested on IE 11
        //sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            try {
                var blob = new Blob([tab_text], { type: "application/vnd.ms-excel" });
                window.URL = window.URL || window.webkitURL;
                link = window.URL.createObjectURL(blob);
                a = document.createElement("a");
                if (document.getElementById("caption")!=null) {
                    a.download=document.getElementById("caption").innerText;
                }
                else
                {
                    a.download = 'download';
                }

                a.href = link;

                document.body.appendChild(a);

                a.click();

                document.body.removeChild(a);
            } catch (e) {
            }


        return false;
        //return (sa);
    }
</script>
@endsection
