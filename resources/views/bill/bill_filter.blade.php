@foreach($bills as $k => $bill)
    <tr>
        @if(Auth::user()->is_admin == 1)
            <td>
                <input type="checkbox" class="checkItem" id="" name="checkItem[]" style="width:2vw; height:3vh;" value="{{ $bill->id }}">
            </td>
        @endif
        <td class="td">
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
        <td class="td">{{ $bill->tracking_no }}</td>
        <td>{{ $bill->party_name }}</td>
        <td>{{ $bill->po_no }}</td>
        <td>{{ $bill->bill_no }}</td>
        <td class="td">{{ $bill->bill_date }}</td>
        <td>{{ $bill->bill_gross_value }}</td>
        <td>{{ $bill->currency->currency }}</td>
        <td>{{ $bill->plant->plant_name }}</td>
        <td>{{ $bill->cheque_no }}</td>
        <td class="td">
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
        <td class="td">
            {!! $bill->return_to_ap_date !!}
        </td>
        <td class="td">
            {!! $bill->receipt_date_by_tr !!}
        </td>
        <td class="td">
            {!! $bill->payment_proposal_date !!}
        </td>
        <td class="td">
            {!! $bill->approved_for_payment_date !!}
        </td>
        <td class="td">
            {!! $bill->cheque_print_date !!}
        </td>
        <td class="td">
            {!! $bill->cheque_handover_date !!}
        </td>
    </tr>
@endforeach