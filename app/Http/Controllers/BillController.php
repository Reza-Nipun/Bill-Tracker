<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Currency;
use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $bills = Bill::paginate(100);
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

        if (!empty($bill_no)) {
            $query = $query->where('bill_no', $bill_no);
        }

        if (!empty($po_no)) {
            $query = $query->where('po_no', $po_no);
        }

        if (!empty($plant_id)) {
            $query = $query->where('plant_id', $plant_id);
        }

        if (!empty($cheque_no)) {
            $query = $query->where('cheque_no', 'LIKE', '%' . $cheque_no . '%');
        }

        if (!empty($party_name)) {
            $query = $query->where('party_name', 'LIKE', '%' . $party_name . '%');
        }

        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        if (!empty($bill_date_from) && !empty($bill_date_to)) {
            $query = $query->whereBetween('bill_date', [$bill_date_from, $bill_date_to]);
        }

        if (!empty($receipt_date_from) && !empty($receipt_date_to)) {
            $query = $query->whereBetween('receipt_date_by_tr', [$receipt_date_from, $receipt_date_to]);
        }

        if (!empty($cheque_handover_date_from) && !empty($cheque_handover_date_to)) {
            $query = $query->whereBetween('cheque_handover_date', [$cheque_handover_date_from, $cheque_handover_date_to]);
        }

//        if ($this == $yet_another_thing) {
//            $query = $query->orderBy('this');
//        }

        $bills = $query->get();

        $change_status_btn = '';

        $new_row = '';

        foreach ($bills AS $k => $bill){

            if ($bill->status == 100){
                $change_status_btn .= '<span class="btn btn-xs btn-warning ml-1" title = "TR Receipt" onclick = "receiptByTRModal('."'".$bill->id."'".')" ><i class="fas fa-hand-holding-usd" ></i> TR Receipt</span>';
            }
            elseif ($bill->status == 200){
                $change_status_btn .= '<span class="btn btn-xs btn-warning ml-1" title = "Payment Proposal" onclick = "paymentProposalModal('."'".$bill->id."'".')" ><i class="fas fa-hand-holding-usd" ></i> Proposal</span><span class="btn btn-xs btn-danger ml-1" title="Return to AP" onclick="returnToAPModal('."'".$bill->id."'".')"><i class="fas fa-undo-alt"></i> Return to AP</span>';
            }
            elseif($bill->status == 300){
                $change_status_btn .= '<span class="btn btn-xs btn-success ml-1" title = "Payment Approve" onclick = "paymentApprovalModal('."'".$bill->id."'".')" ><i class="fas fa-money-check-alt" ></i> Approve</span>';
            }
            elseif($bill->status == 301){
                $change_status_btn .= '<span class="btn btn-xs btn-info ml-1" title = "Cheque Print" onclick = "chequePrintModal('."'".$bill->id."'".', '."'".$bill->bill_no."'".')" ><i class="fas fa-money-check"></i > Cheque</span>';
            }
            elseif($bill->status == 400){
                $change_status_btn .= '<span class="btn btn-xs btn-info ml-1" title = "Cheque Handover" onclick = "chequeHandoverModal('."'".$bill->id."'".')" ><i class="fas fa-money-check" ></i> Handover</span>';
            }

            $new_row .= '<tr>';
//            $new_row .= '<td>'.($k+1).'</td>';
            $new_row .= '<td><a href="'.route('bill.edit', $bill->id).'" class="btn btn-xs btn-primary" title="Edit"><i class="fas fa-edit"></i></a>'.$change_status_btn.'</td>';
            $new_row .= '<td>'.$bill->tracking_no.'</td>';
            $new_row .= '<td>'.$bill->party_name.'</td>';
            $new_row .= '<td>'.$bill->po_no.'</td>';
            $new_row .= '<td>'.$bill->bill_no.'</td>';
            $new_row .= '<td>'.$bill->bill_date.'</td>';
            $new_row .= '<td>'.$bill->bill_gross_value.'</td>';
            $new_row .= '<td>'.$bill->currency->currency.'</td>';
            $new_row .= '<td>'.$bill->plant->plant_name.'</td>';
            $new_row .= '<td>'.$bill->cheque_no.'</td>';
            $new_row .= '<td>'.($bill->status == 100 ? 'Return to AP' : ($bill->status == 200 ? 'Received by TR' : ($bill->status == 300 ? 'Payment Proposal' : ($bill->status == 301 ? 'Approved for Payment' : ($bill->status == 400 ? 'Check Print' : ($bill->status == 401 ? 'Check Handover' : '')))))).'</td>';
            $new_row .= '<td>'.'<span class="badge badge-danger">AP-Return: '.$bill->return_to_ap_date.'</span><br /> <span class="badge badge-secondary">TR-Receipt: '.$bill->receipt_date_by_tr.'</span><br /> <span class="badge badge-info">Proposal: '.$bill->payment_proposal_date.'</span><br /> <span class="badge badge-warning">Approve: '.$bill->approved_for_payment_date.'</span><br /> <span class="badge badge-primary">Cheque: '.$bill->cheque_print_date.'</span><br /> <span class="badge badge-success">Handover: '.$bill->cheque_handover_date.'</span></td>';
            $new_row .= '</tr>';

        }

        return $new_row;

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
}
