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
               @if($isCustomer)
                    <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Customer</h5>
                    <select name="customer_id" id="customer_id" id="customer_id" wire:model="customer_id" class="form-control " style="width: 100%!important;">
                        <option value="">--Select Customer--</option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                @elseif($isAgent)
                    <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Agent</h5>
                    <select name="agent_id" id="agent_id" id="agent_id" wire:model="agent_id" class="form-control " style="width: 100%!important;">
                        <option value="">--Select Agent--</option>
                        @foreach($agents as $agent)
                            <option value="{{$agent->id}}">{{$agent->name}}</option>
                        @endforeach
                    </select>
                @elseif($isSupplier)
                    <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Supplier</h5>
                    <select name="supplier_id" id="supplier_id" id="supplier_id" wire:model="supplier_id" class="form-control " style="width: 100%!important;">
                        <option value="">--Select Supplier--</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}">{{$supplier->name}} - {{number_format($supplier->balance, 2)}}</option>
                        @endforeach
                    </select>
                @else
                    <h5>
                        Search: <input type="text" class="form-control" id="q" wire:model="q" placeholder="Search by Invoice No, Customer Phone.">
                    </h5>
               @endif
            </div>
            <div class="col-md-12">
                <button class="btn btn-secondary btn-sm float-right"
                    @if($isCustomer)
                        onclick="printDiv('printCustomerReport')"
                    @elseif($isAgent)
                        onclick="printDiv('printAgentReport')"
                    @elseif($isSupplier)
                        onclick="printDiv('printSupplierReport')"
                    @else
                        onclick="printDiv('printableArea')"
                    @endif
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

    @php
        $customerTotalSalesPrice = 0;
        $customerTotalTaxAmount = 0;
        $customerGrandTotalBalance = 0;
        $customerTotalAdvanced = 0;
        $customerTotalDue = 0;
        $customerTotalDuePaidAmount = 0;
        $customerTotalFinalDueAmount = 0;

        $agentTotalSalesPrice = 0;
        $agentGrandTotalAgentCommission = 0;
        $agentTotalAgentCommission = 0;

        $supplierTotalSalesPrice = 0;
        $supplierTotalRate = 0;
        $supplierGrandTotalSupplierRate = 0;

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
        $grandTotalSupplierRate = 0;
        $grandTotalAgentCommission = 0;
    @endphp

    <div class="table-responsive"
         @if($isCustomer)
             id="printCustomerReport"
         @elseif($isAgent)
             id="printAgentReport"
         @elseif($isSupplier)
             id="printSupplierReport"
         @else
             id="printableArea"
         @endif
    >
        @if($isCustomer)
            <div class="d-print-block d-none" style="top: 0; right: 0; left: 0">
                @component('print-page-header', ['title' => $name])@endcomponent
            </div>
        @endif
        <div class="dt-entry__heading" id="printable">
{{--            <h3 class="dt-entry__title text-center mb-3" style="font-size: 24px">{{@$SType?->getLabel()}}</h3>--}}
{{--            <br>--}}
{{--            <h3 class="dt-entry__title text-center mb-3" style="font-size: 24px">{{@$name}}</h3>--}}
{{--            <br>--}}
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

        {{--Detail Sales Report--}}
        @if(!$isCustomer && !$isAgent && !$isSupplier)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer Name</th>
                    <th>Services</th>
                    <th>Sales Price</th>
                    <th>Supplier Rate</th>
                    <th>Agent Commission</th>
                    <th>Tax %</th>
                    <th>Tax Amount</th>
                    <th>Invoice Total</th>
                    <th>Advanced</th>
                    <th>Due</th>
                    <th>Profit</th>
                </tr>
                </thead>
                <tbody>
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
                            @foreach($invoice->services as $index => $service)
                                {{@$service->supplier_rate}}
                                @php($totalSupplierRate+=@$service->supplier_rate)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->agent_commission}}
                                @php($totalAgentCommission+=@$service->agent_commission)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->tax_percentage}}
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->tax_amount}}
                                @php($totalTaxAmount+=@$service->tax_amount)
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
                            @php($totalDue+=@$invoice->due_amount- $invoice->due_paid_amount)
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->balance}}
                                @php($totalBalance+=@$service->balance)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td><strong>{{$totalSupplierRate}}</strong></td>
                    <td><strong>{{$totalAgentCommission}}</strong></td>
                    <td></td>
                    <td><strong>{{$totalTaxAmount}}</strong></td>
                    <td><strong>{{$grandTotalBalance}}</strong></td>
                    <td><strong>{{$totalAdvanced}}</strong></td>
                    <td><strong>{{$totalDue}}</strong></td>
                    <td><strong>{{$totalBalance}}</strong></td>
                </tr>
                </tfoot>
            </table>
        @endif

        {{--Customer Sales Report--}}
        @if($isCustomer)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="d-print-none">#</th>
                    <th>Invoice</th>
                    <th>Customer Name</th>
                    <th>Services</th>
                    <th>Sales Price</th>
                    <th>Tax Amount</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Due Paid Amount</th>
                    <th>Final Due</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $index => $invoice)
                    <tr>
                        <td style="width: 60px!important;" class="d-print-none">
                            <a class="btn btn-sm btn-primary" href="{{route('invoices.show', $invoice->id)}}">Collect to Drawer Cash</a>
                            <br>
                            <a class="btn btn-sm btn-warning" href="{{route('invoices.collect-to-bank', $invoice->id)}}">Collect to Bank</a>
                        </td>
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
                                @php($customerTotalSalesPrice+=@$service->sales_rate)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->tax_amount}}
                                @php($customerTotalTaxAmount+=@$service->tax_amount)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        @php($customerGrandTotalBalance+=@$invoice->total_amount)
                        <td>
                            {{ $invoice->total_amount }}
                        </td>
                        <td>
                            {{ $invoice->received_amount }}
                            @php($customerTotalAdvanced+=@$invoice->received_amount)
                        </td>
                        <td>
                            {{ $invoice->due_amount }}
                            @php($customerTotalDue+=@$invoice->due_amount)
                        </td>
                        <td>
                            @foreach($invoice->due_payments as $index => $due_payment)
                                {{@$due_payment->amount}}/= on {{format_date($due_payment->date, 'dMY')}}
                                @php($customerTotalDuePaidAmount+=@$due_payment->amount)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            {{ $invoice->due_amount - $invoice->due_paid_amount}}
                            @php($customerTotalFinalDueAmount+=$invoice->due_amount - $invoice->due_paid_amount)
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td><strong>{{$customerTotalSalesPrice}}</strong></td>
                    <td><strong>{{$customerTotalTaxAmount}}</strong></td>
                    <td><strong>{{$customerGrandTotalBalance}}</strong></td>
                    <td><strong>{{$customerTotalAdvanced}}</strong></td>
                    <td><strong>{{$customerTotalDue}}</strong></td>
                    <td><strong>{{$customerTotalDuePaidAmount}}</strong></td>
                    <td><strong>{{$customerTotalFinalDueAmount}}</strong></td>
                </tr>
                </tfoot>
            </table>
        @endif

        {{--Agent Sales Report--}}
        @if($isAgent)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Agent Name </th>
                    <th>Services</th>
                    <th>Sales Price</th>
                    <th>Quantity</th>
                    <th>Agent Commission</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
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
                            {{ $invoice->agent?->name }}
                            <br>
                            {{ $invoice->agent?->phone }}
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
                                @php($agentTotalSalesPrice+=@$service->sales_rate)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->quantity}}
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->agent_commission}}
                                @php($agentTotalAgentCommission+=@$service->agent_commission)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->total_agent_commission}}
                                @php($agentGrandTotalAgentCommission+=@$service->total_agent_commission)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>{{$agentTotalSalesPrice}}</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{$agentGrandTotalAgentCommission}}</strong></td>
                </tr>
                </tfoot>
            </table>
        @endif

        {{--Supplier Sales Report--}}
        @if($isSupplier)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Supplier Name</th>
                    <th>Services</th>
                    <th>Sales Price</th>
                    <th>Quantity</th>
                    <th>Supplier Rate</th>
                    <th>Sub Total</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $index => $invoice)
                    @php($supplierGrandTotalSupplierRate+=$invoice->total_supplier_rate);
                    <tr>
                        <td>
                            NO: {{ $invoice->invoice_no }}
                            <br>
                            Issue Date: {{$invoice->issue_date ?? "N/A"}}
                            <br>
                            Ref Number: {{$invoice->ref_number ?? "N/A"}}
                        </td>
                        <td>
                            {{ $invoice->supplier?->name }}
                            <br>
                            {{ $invoice->supplier?->phone }}
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
                                @php($supplierTotalSalesPrice+=@$service->sales_rate)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->quantity}}
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->supplier_rate}}
                                @php($supplierTotalRate+=@$service->supplier_rate)
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            @foreach($invoice->services as $index => $service)
                                {{@$service->total_supplier_rate}}
                                <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                            @endforeach
                        </td>
                        <td>
                            {{$invoice->total_supplier_rate}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>{{$supplierTotalSalesPrice}}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> <strong>{{$supplierGrandTotalSupplierRate}}</strong></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right">Deposited Amount</td>
                    <td> <strong>{{@$supplierDeposit}}</strong></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right">Current Balance</td>
                    <td> <strong>{{@$supplierBalance}}</strong></td>
                </tr>
                </tfoot>
            </table>
        @endif

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
