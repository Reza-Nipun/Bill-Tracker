<?php

namespace App\Http\Controllers;

use App\Bill;
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
        $bill_nos = Bill::all();
        $plants = Plant::where('status', 1)->get();

        return view('bill.bill_list', compact('title', 'bills', 'bill_nos', 'plants'));
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

        return view('bill.create_bill', compact('title', 'plants'));
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
            'bill_no' => 'required|unique:bills',
            'po_no' => 'required|unique:bills',
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
        $bill->currency = $request->currency;
        $bill->plant_id = $request->plant;
        $bill->details = $request->details;
        $bill->receipt_date_by_tr = date('Y-m-d');
        $bill->tr_remarks = $request->tr_remarks;
        $bill->status = 0;
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

        return view('bill.edit_bill', compact('title', 'plants', 'bill'));
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
            'bill_no' => 'required|unique:bills,bill_no,'.$id,
            'po_no' => 'required|unique:bills,po_no,'.$id,
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
        $bill->currency = $request->currency;
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
        $bill_id = $request->bill_id;
        $plant_id = $request->plant_id;
        $cheque_no = $request->cheque_no;
        $status = $request->status;
        $bill_date_from = $request->bill_date_from;
        $bill_date_to = $request->bill_date_to;
        $receipt_date_from = $request->receipt_date_from;
        $receipt_date_to = $request->receipt_date_to;
        $cheque_handover_date_from = $request->cheque_handover_date_from;
        $cheque_handover_date_to = $request->cheque_handover_date_to;

        $query = Bill::query();

        if (!empty($bill_id)) {
            $query = $query->where('id', $bill_id);
        }

        if (!empty($plant_id)) {
            $query = $query->where('plant_id', $plant_id);
        }

        if (!empty($cheque_no)) {
            $query = $query->where('cheque_no', 'LIKE', '%' . $cheque_no . '%');
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

            if ($bill->status == 0){
                $change_status_btn .= '<span class="btn btn-xs btn-warning ml-1" title = "Payment Proposal" onclick = "paymentProposal('."'".$bill->id."'".')" ><i class="fas fa-hand-holding-usd" ></i >Proposal</span>';
            }
            elseif($bill->status == 1){
                $change_status_btn .= '<span class="btn btn-xs btn-success ml-1" title = "Payment Approve" onclick = "paymentApproval('."'".$bill->id."'".')" ><i class="fas fa-money-check-alt" ></i >Approve</span>';
            }
            elseif($bill->status == 2){
                $change_status_btn .= '<span class="btn btn-xs btn-info ml-1" title = "Cheque Handover" onclick = "chequeHandoverModal('."'".$bill->id."'".', '."'".$bill->bill_no."'".')" ><i class="fas fa-money-check" ></i >Cheque</span>';
            }

            $new_row .= '<tr>';
            $new_row .= '<td>'.($k+1).'</td>';
            $new_row .= '<td>'.$bill->tracking_no.'</td>';
            $new_row .= '<td>'.$bill->party_name.'</td>';
            $new_row .= '<td>'.$bill->po_no.'</td>';
            $new_row .= '<td>'.$bill->bill_no.'</td>';
            $new_row .= '<td>'.$bill->bill_date.'</td>';
            $new_row .= '<td>'.$bill->bill_gross_value.'</td>';
            $new_row .= '<td>'.$bill->currency.'</td>';
            $new_row .= '<td>'.$bill->plant->plant_name.'</td>';
            $new_row .= '<td>'.$bill->cheque_no.'</td>';
            $new_row .= '<td>'.($bill->status == 0 ? 'Received by TR' : ($bill->status == 1 ? 'Payment Proposal' : ($bill->status == 2 ? 'Approved for Payment' : ($bill->status == 3 ? 'Check Handover' : '')))).'</td>';
            $new_row .= '<td>'.'<span class="badge badge-secondary">Receipt: '.$bill->receipt_date_by_tr.'</span><br /> <span class="badge badge-info">Proposal: '.$bill->payment_proposal_date.'</span><br /> <span class="badge badge-warning">Approve: '.$bill->approved_for_payment_date.'</span><br /> <span class="badge badge-success">Cheque: '.$bill->cheque_handover_date.'</span></td>';
            $new_row .= '<td><a href="'.route('bill.edit', $bill->id).'" class="btn btn-xs btn-primary" title="Edit"><i class="fas fa-edit"></i></a>'.$change_status_btn.'</td>';
            $new_row .= '</tr>';

        }

        return $new_row;

    }
}
