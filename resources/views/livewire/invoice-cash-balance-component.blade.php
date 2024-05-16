<div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h5>Date:
                    <input type="date" class="form-control" id="date" wire:model="date">
                </h5>
            </div>
            <div class="col-md-3">
                <h5>From Date:
                    <input type="date" class="form-control" id="from_date" wire:model="from_date">
                </h5>
            </div>
            <div class="col-md-3">
                <h5>To Date:
                    <input type="date" class="form-control" id="to_date" wire:model="to_date">
                </h5>
            </div>
            <div class="col-md-3">
                <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Customer</h5>
                <select name="customer_id" id="customer_id" id="customer_id" wire:model="customer_id" class="form-control " style="width: 100%!important;">
                    <option value="">--Select Customer--</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <button class="btn btn-secondary btn-sm float-right"
                        onclick="printDiv('printCustomerCashPaidReport')"
                >Print
                </button>
            </div>
        </div>
    </div>

    <style>
        #printable { display: none; }
        @media print
        {
            #non-printable { display: none; }
            #printable { display: block; }
        }
    </style>

    <div class="table-responsive"
         id="printCustomerCashPaidReport"
    >
        <div class="dt-entry__heading" id="printable">
            <h3 class="dt-entry__title text-center mb-3" style="font-size: 24px">{{@$SType?->getLabel()}}</h3>
            <br>
            <h3 class="dt-entry__title text-center mb-3" style="font-size: 24px">Cash Balance</h3>
            <br><br>
            @if($date)
                <span class="dt-entry__title text-center mb-3" style="font-size: 16px">Date: {{@$date}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
            @endif
            @if($from_date)
                <span class="dt-entry__title text-center mb-3" style="font-size: 16px">From Date: {{@$from_date}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endif
            @if($to_date)
                <span class="dt-entry__title text-center mb-3" style="font-size: 16px">To Date: {{@$to_date}}</span>
            @endif
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Invoice</th>
                <th>Customer Name</th>
                <th>Services</th>
                <th>Sales Price</th>
                <th>Total</th>
                <th>Cash Paid</th>
                <th>Due</th>
                <th>Due Payment Details</th>
            </tr>
            </thead>
            <tbody>
            @php
                $totalSalesPrice = 0;
                $totalSupplierRate = 0;
                $totalAgentCommission = 0;
                $totalBalance = 0;
                $grandTotalBalance = 0;
                $totalTaxAmount = 0;
                $totalAdvanced = 0;
                $totalDue = 0;
                $totalDuePaidAmount = 0;
                $totalFinalDueAmount = 0;
            @endphp
            @foreach($invoices as $index => $invoice)
                <tr>
                    <td>
                        NO: {{ $invoice->invoice_no }}
                        <br>
                        Issue Date: {{$invoice->issue_date ?? "N/A"}}
                        <br>
                        Ref Number: {{$invoice->ref_number ?? "N/A"}}
                    </td>
                    <td>
                        {{ $invoice->name }}
                        <br>
                        {{ $invoice->phone }}
                    </td>
                    <td>
                        @foreach($invoice->services as $index => $service)
                            <span>{{@$service->service->name}}</span>
                            <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                        @endforeach
                    </td>
                    <td>
                        @foreach($invoice->services as $index => $service)
                            {{@$service->sales_rate}}
                            @php($totalSalesPrice+=@$service->sales_rate)
                            <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                        @endforeach
                    </td>
                    <td>
                        {{ $invoice->total_amount }}
                        @php($grandTotalBalance+=@$invoice->total_amount)
                    </td>
                    <td>
                        {{ $invoice->received_amount }}
                        @php($totalAdvanced+=@$invoice->received_amount)
                    </td>
                    <td>
                        {{ $invoice->due_amount - $invoice->due_paid_amount}}
                        @php($totalFinalDueAmount+=$invoice->due_amount - $invoice->due_paid_amount)
                    </td>
                    <td>
                        @foreach($invoice->due_payments as $index => $due_payment)
                            {{@$due_payment->amount}}/= on {{format_date($due_payment->date, 'dMY')}}
                            @php($totalDuePaidAmount+=@$due_payment->amount)
                            <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>
                    <strong>{{$totalSalesPrice}}</strong>
                </td>
                <td><strong>{{$grandTotalBalance}}</strong></td>
                <td><strong>{{$totalAdvanced}}</strong></td>
                <td><strong>{{$totalDuePaidAmount}}</strong></td>
            </tr>
            </tfoot>
        </table>
        <div class="mt-2">
            {{ $invoices->links() }}
        </div>
    </div>

    <script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</div>
