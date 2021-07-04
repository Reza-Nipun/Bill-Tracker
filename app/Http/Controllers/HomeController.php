<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = ' | Dashboard';
        return view('home', compact('title'));
    }

    public function paymentProposal(Request $request){
        $bill_id = $request->bill_id;

        $bill = Bill::find($bill_id);
        $bill->status = 1;
        $bill->payment_proposal_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function paymentApproval(Request $request){
        $bill_id = $request->bill_id;

        $bill = Bill::find($bill_id);
        $bill->status = 2;
        $bill->approved_for_payment_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }

    public function chequeHandover(Request $request){
        $bill_id = $request->bill_id;
        $cheque_no = $request->cheque_no;

        $bill = Bill::find($bill_id);
        $bill->status = 3;
        $bill->cheque_no = $cheque_no;
        $bill->cheque_handover_date = date('Y-m-d');
        $bill->save();

        echo 'done';
    }
}
