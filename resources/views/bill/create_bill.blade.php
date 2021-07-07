@extends((Auth::user()->is_admin == 1) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Bill</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bill.index') }}">Bill List</a></li>
                            <li class="breadcrumb-item active">Create Bill</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Form</h3>

                        <div class="card-tools">
                            <a href="{{ route('file_upload') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-file-upload"></i> Excel Upload
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('bill.store') }}" method="post">

                        @csrf

                    <div class="card-body">

                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li >{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bill_no">Bill No <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="bill_no" name="bill_no" placeholder="Enter Bill No" value="{{ old('bill_no') }}">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="po_no">PO <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="po_no" name="po_no" placeholder="Enter PO" value="{{ old('po_no') }}">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="party_name">Party Name</label>
                                    <input type="text" class="form-control" id="party_name" name="party_name" placeholder="Enter Party Name" value="{{ old('party_name') }}">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bill_date">Bill Date <span style="color: red">*</span></label>
                                    <input type="date" class="form-control" id="bill_date" name="bill_date" placeholder="YYYY-mm-dd" value="{{ old('bill_date') }}">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bill_gross_value">Bill Gross Value <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="bill_gross_value" name="bill_gross_value" placeholder="Enter Bill Gross Value" value="{{ old('bill_gross_value') }}">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="currency">Currency <span style="color: red">*</span></label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="currency" id="currency">
                                        <option value="">Select Currency</option>

                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->currency }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="plant">Plant <span style="color: red">*</span></label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="plant" id="plant">
                                        <option value="">Select Plant</option>

                                        @foreach($plants as $plant)
                                            <option value="{{ $plant->id }}">{{ $plant->plant_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="details">Details</label>
                                    <textarea class="form-control" id="details" name="details" placeholder="Enter Details">{{ old('details') }}</textarea>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tr_remarks">TR Remarks</label>
                                    <textarea class="form-control" id="tr_remarks" name="tr_remarks" placeholder="Enter TR Remarks">{{ old('tr_remarks') }}</textarea>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                    <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <script>

    </script>
@endsection