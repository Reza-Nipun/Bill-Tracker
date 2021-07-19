<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Currency;
use App\Plant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | Bill List';
        $bills = Bill::where('status', '<>', 401)->orderBy('bill_date', 'ASC')->get();
        $bill_nos = Bill::groupBy('bill_no')->get();
        $po_nos = Bill::groupBy('po_no')->get();
        $plants = Plant::where('status', 1)->get();

        return view('bill.bill_list', compact('title', 'bills', 'bill_nos', 'po_nos', 'plants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Create Bill';
        $plants = Plant::where('status', 1)->get();
        $currencies = Currency::where('status', 1)->get();

        return view('bill.create_bill', compact('title', 'plants', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
//            'bill_no' => 'required|unique:bills',
//            'po_no' => 'required|unique:bills',
            'bill_no' => 'required',
            'po_no' => 'required',
            'bill_date' => 'required|date_format:Y-m-d',
            'bill_gross_value' => 'required|regex:/^\d*(\.\d{2})?$/',
            'currency' => 'required',
            'plant' => 'required',
        ]);

        $bill = new Bill();
        $bill->party_name = $request->party_name;
        $bill->bill_no = $request->bill_no;
        $bill->po_no = $request->po_no;
        $bill->bill_date = $request->bill_date;
        $bill->bill_gross_value = $request->bill_gross_value;
        $bill->currency_id = $request->currency;
        $bill->plant_id = $request->plant;
        $bill->details = $request->details;
        $bill->receipt_date_by_tr = date('Y-m-d');
        $bill->tr_remarks = $request->tr_remarks;
        $bill->status = 200;
        $bill->user_id = Auth::user()->id;
        $bill->save();

        $bill_id = $bill->id;
        $bill_tracking_no_update = Bill::find($bill_id);
        $bill_tracking_no_update->tracking_no = $bill_id.'-'.date('Y-m');
        $bill_tracking_no_update->save();

        return redirect()->back()->with('success', 'Bill Successfully Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = ' | Edit Bill';
        $plants = Plant::where('status', 1)->get();
        $bill = Bill::find($id);
        $currencies = Currency::where('status', 1)->get();

        return view('bill.edit_bill', compact('title', 'plants', 'bill', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
//            'bill_no' => 'required|unique:bills,bill_no,'.$id,
//            'po_no' => 'required|unique:bills,po_no,'.$id,
            'bill_no' => 'required',
            'po_no' => 'required',
            'bill_date' => 'required|date_format:Y-m-d',
            'bill_gross_value' => 'required|regex:/^\d*(\.\d{2})?$/',
            'currency' => 'required',
            'plant' => 'required',
        ]);

        $bill = Bill::find($id);
        $bill->party_name = $request->party_name;
        $bill->bill_no = $request->bill_no;
        $bill->po_no = $request->po_no;
        $bill->bill_date = $request->bill_date;
        $bill->bill_gross_value = $request->bill_gross_value;
        $bill->currency_id = $request->currency;
        $bill->plant_id = $request->plant;
        $bill->details = $request->details;
        $bill->receipt_date_by_tr = date('Y-m-d');
        $bill->tr_remarks = $request->tr_remarks;
        $bill->user_id = Auth::user()->id;
        $bill->save();

        return redirect()->back()->with('success', 'Bill Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function searchBill(Request $request)
    {
        $bill_no = $request->bill_no;
        $po_no = $request->po_no;
        $plant_id = $request->plant_id;
        $cheque_no = $request->cheque_no;
        $party_name = $request->party_name;
        $status = $request->status;
        $bill_date_from = $request->bill_date_from;
        $bill_date_to = $request->bill_date_to;
        $receipt_date_from = $request->receipt_date_from;
        $receipt_date_to = $request->receipt_date_to;
        $cheque_handover_date_from = $request->cheque_handover_date_from;
        $cheque_handover_date_to = $request->cheque_handover_date_to;

        $query = Bill::query();

        if(($bill_no==null) && ($po_no==null) && ($plant_id==null) && ($cheque_no==null) && ($party_name==null) && ($status==null) && ($bill_date_from==null) && ($bill_date_to==null) && ($receipt_date_from==null) && ($receipt_date_to==null) && ($cheque_handover_date_from==null) && ($cheque_handover_date_to==null)){
            $query = $query->where('status', '<>', 401);
        }

        if ($bill_no!=null) {
            $query = $query->where('bill_no', $bill_no);
        }

        if ($po_no!=null) {
            $query = $query->where('po_no', $po_no);
        }

        if ($plant_id!=null) {
            $query = $query->where('plant_id', $plant_id);
        }

        if ($cheque_no!=null) {
            $query = $query->where('cheque_no', 'LIKE', '%' . $cheque_no . '%');
        }

        if ($party_name!=null) {
            $query = $query->where('party_name', 'LIKE', '%' . $party_name . '%');
        }

        if ($status!=null) {
            $query = $query->where('status', $status);
        }

        if (($bill_date_from!=null) && ($bill_date_to!=null)) {
            $query = $query->whereBetween('bill_date', [$bill_date_from, $bill_date_to]);
        }

        if (($receipt_date_from!=null) && ($receipt_date_to!=null)) {
            $query = $query->whereBetween('receipt_date_by_tr', [$receipt_date_from, $receipt_date_to]);
        }

        if (($cheque_handover_date_from!=null) && ($cheque_handover_date_to!=null)) {
            $query = $query->whereBetween('cheque_handover_date', [$cheque_handover_date_from, $cheque_handover_date_to]);
        }

        $query = $query->orderBy('bill_date', 'ASC');

        $bills = $query->get();

        return view('bill.bill_filter', compact('bills'));
    }

    public function returnToAP(Request $request){
        $bill_id = $request->bill_id;
        $return_to_ap_remarks = $request->return_to_ap_remarks;

        $bill = Bill::find($bill_id);
        $bill->status = 100;
        $bill->receipt_date_by_tr = NULL;
        $bill->return_to_ap_date = date('Y-m-d');
        $bill->return_to_ap_remarks = $return_to_ap_remarks;
        $bill->save();

        echo 'done';
    }

    public function receiptByTR(Request $request){
        $bill_id = $request->bill_id;

        $bill = Bill::find($bill_id);
        $bill->status = 200;
        $bill->receipt_date_by_tr = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function paymentProposal(Request $request){
        $bill_id = $request->bill_id;

        $bill = Bill::find($bill_id);
        $bill->status = 300;
        $bill->payment_proposal_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function paymentApproval(Request $request){
        $bill_id = $request->bill_id;

        $bill = Bill::find($bill_id);
        $bill->status = 301;
        $bill->approved_for_payment_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function chequePrint(Request $request){
        $bill_id = $request->bill_id;
        $cheque_no = $request->cheque_no;

        $bill = Bill::find($bill_id);
        $bill->status = 400;
        $bill->cheque_no = $cheque_no;
        $bill->cheque_print_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function chequeHandover(Request $request){
        $bill_id = $request->bill_id;

        $bill = Bill::find($bill_id);
        $bill->status = 401;
        $bill->cheque_handover_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function excelUpload(){
        $title = ' | Excel Upload';
        $plants = Plant::where('status', 1)->get();
        $currencies = Currency::where('status', 1)->get();

        return view('bill.excel_upload', compact('title', 'plants', 'currencies'));
    }

    public function uploadFile(Request $request){
        $this->validate(request(), [
            'plant'   => 'required',
            'currency'   => 'required',
            'upload_file'   => 'required|mimes:xls,xlsx',
        ]);

        $plant = $request->plant;
        $currency = $request->currency;
        $path = $request->file('upload_file')->getRealPath();

        $spreadsheet = IOFactory::load($path);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

//        Checking Date
        Carbon::macro('checkDate', function (
            $date,
            $month = null,
            $day = null
        ) {
            if (!is_null($day)) {
                $date = "{$date}-{$month}-{$day}";
            }

            $parsed = date_parse($date);

            return $parsed['error_count'] == 0 &&
                ($parsed['warning_count'] == 0 ||
                    !in_array(
                        'The parsed date was invalid',
                        $parsed['warnings']
            ));
        });
//        Checking Date

        foreach ($sheetData as $row => $value) {

            if($row > 1){

                if(!empty($value['B']) && !empty($value['C']) && (Carbon::checkDate($value['D']) == true)){
                    $bill = new Bill();
                    $bill->party_name = $value['A'];
                    $bill->po_no = $value['B'];
                    $bill->bill_no = $value['C'];
                    $bill->bill_date = Carbon::parse($value['D'])->format('Y-m-d');
                    $bill->bill_gross_value = $value['E'];
                    $bill->plant_id = $plant;
                    $bill->currency_id = $currency;
                    $bill->status = 200;
                    $bill->receipt_date_by_tr = Carbon::now()->format('Y-m-d');
                    $bill->user_id = Auth::user()->id;
                    $bill->save();

                    $bill_id = $bill->id;
                    $bill_tracking_no_update = Bill::find($bill_id);
                    $bill_tracking_no_update->tracking_no = $bill_id.'-'.date('Y-m');
                    $bill_tracking_no_update->save();
                }

            }

        }

        return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function deleteBill(Request $request){
        $bill_ids = $request->bill_ids;

        foreach($bill_ids as $bill_id){
            Bill::destroy($bill_id);
        }

        return response()->json('success', 200);
    }
}
