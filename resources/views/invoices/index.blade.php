@extends('layouts.app')
@section('title', "Income")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Income"}}</h3>
        </div>
    </div>
    <div class="row">
        @push('css')
            <style>
                th {
                    font-size: 11px;
                }

                td {
                    font-size: 11px;
                }
                .table th, .table td{
                    padding: 0.4rem!important;
                }
            </style>
        @endpush
        <div class="col-xl-12">
            <!-- Card -->
            <div class="dt-card dt-card__full-height">
                <!-- Card Body -->
                <div class="dt-card__body">
                    <div class="card-body pt-0">
                        <div x-data="{ activeTab: 'invoice' }">
                            <div class="tab-content mt-2">
                                <div class="tab-pane"
                                     :class="{active: activeTab === 'invoice' || activeTab === 'detail-invoice' || activeTab === 'customer-sales-report' || activeTab === 'agent-sales-report' || activeTab === 'supplier-sales-report' || activeTab === 'cash-balance' }"
                                     id="invoice">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item text-center">
                                            <a class="nav-link"
                                               :class="{active: activeTab === 'invoice'}"
                                               @click="activeTab = 'invoice'"
                                               href="#invoice">Invoice</a>
                                        </li>
                                        @if(authUser()->type == \App\Models\User::TYPE_ADMIN || authUser()->type == \App\Models\User::TYPE_ACCOUNTANT)
                                        <li class="nav-item text-center">
                                            <a class="nav-link" :class="{ active: activeTab === 'detail-invoice' }"
                                               @click="activeTab = 'detail-invoice'" href="#detail-invoice">Detail Sales Report</a>
                                        </li>
                                        <li class="nav-item text-center">
                                            <a class="nav-link" :class="{ active: activeTab === 'customer-sales-report' }"
                                               @click="activeTab = 'customer-sales-report'" href="#customer-sales-report">Customer Sales Report</a>
                                        </li>
                                        <li class="nav-item text-center">
                                            <a class="nav-link" :class="{ active: activeTab === 'agent-sales-report' }"
                                               @click="activeTab = 'agent-sales-report'" href="#agent-sales-report">Agent Sales Report</a>
                                        </li>
                                        <li class="nav-item text-center">
                                            <a class="nav-link" :class="{ active: activeTab === 'supplier-sales-report' }"
                                               @click="activeTab = 'supplier-sales-report'" href="#supplier-sales-report">Supplier Sales Report</a>
                                        </li>
                                        <li class="nav-item text-center">
                                            <a class="nav-link" :class="{ active: activeTab === 'cash-balance' }"
                                               @click="activeTab = 'cash-balance'" href="#cash-balance">Cash Balance</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="tab-pane"
                                     :class="{active: activeTab === 'invoice'}"
                                     id="invoice">
                                    <div>
                                        <form action="{{$invoiceEdit ? route('invoices.update', $invoiceEdit->id) : route('invoices.store')}}" method="post">
                                            @csrf
                                            @if($invoiceEdit)
                                                @method('put')
                                            @endif
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Customer</h5>
                                                        <select name="customer_id" id="customer_id" class="form-control select2" style="width: 100%!important;" onchange="setCustomer()">
                                                            <option value="">--Select Customer--</option>
                                                            @foreach($customers as $customer)
                                                                <option value="{{$customer->id}}" data-customer="{{ json_encode($customer) }}" @if(@$invoiceEdit->customer_id == $customer->id) selected @endif >
                                                                    {{$customer->name}} | {{ $customer->passport }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Customer Name: <input type="text" class="form-control" name="name" id="name" value="{{@$invoiceEdit->name}}" required placeholder="Name">
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Customer Passport/EID: <input type="text" class="form-control" name="passport" id="passport" value="{{@$invoiceEdit->customer->passport}}" placeholder="Passport/EID">
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Customer Phone: <input type="text" class="form-control" name="phone" id="phone" value="{{@$invoiceEdit->phone}}" required placeholder="Phone">
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Customer Address: <input type="text" class="form-control" name="address" id="address" value="{{@$invoiceEdit->address}}" placeholder="Address">
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Ref Number: <input type="text" class="form-control" name="ref_number" value="{{@$invoiceEdit->ref_number}}" placeholder="Ref Number">
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>Invoice NO: <input type="text" class="form-control" readonly value="{{@$invoiceEdit->invoice_no ?? @$invoiceId}}"></h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Issue Date: <input type="date" class="form-control" name="issue_date" value="{{@$invoiceEdit->issue_date ?? now()->toDateString()}}">
                                                        </h5>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <h5>
                                                            Agent:
                                                            <select name="agent_id" id="agent_id" class="form-control">
                                                                <option value="">--Select Agent--</option>
                                                                @foreach($agents as $agent)
                                                                    <option value="{{$agent->id}}" @if(@$invoiceEdit->agent_id == $agent->id) selected @endif >{{$agent->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>
                                                            Supplier:
                                                            <select name="supplier_id" id="supplier_id" class="form-control">
                                                                <option value="">--Select Supplier--</option>
                                                                @foreach($suppliers as $supplier)
                                                                    <option value="{{$supplier->id}}" @if(@$invoiceEdit->supplier_id == $supplier->id) selected @endif >{{$supplier->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </h5>
                                                    </div>

                                                    <input type="text" class="form-control d-none" name="type" value="{{$type}}">
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="font-weight-bold">Service</th>
                                                            <th class="font-weight-bold">Remarks</th>
                                                            <th class="font-weight-bold">Sales Rate</th>
                                                            <th class="font-weight-bold">Quantity</th>
                                                            <th class="font-weight-bold">Supplier Rate</th>
                                                            <th class="font-weight-bold">Total</th>
                                                            <th class="font-weight-bold">Agent Commission</th>
                                                            <th class="font-weight-bold">Total</th>
                                                            <th class="font-weight-bold">Tax %</th>
                                                            <th class="font-weight-bold">Tax Amount</th>
                                                            <th class="font-weight-bold">Total Amount</th>
                                                            <th class="font-weight-bold">Profit Balance</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="invoiceTableBody">
                                                        @foreach($documentClearingServices as $index => $service)
                                                            @php
                                                               $invoiceService = $invoiceEdit?->services()?->where('service_id', $service->id)?->first();
                                                            @endphp
                                                            <tr>
                                                                <td style="width: 140px;">
                                                                    {{$index+1}}. {{ $service->name }}
                                                                    <input type="text" name="service_ids[]" value="{{$service->id}}" class="d-none">
                                                                </td>
                                                                <td style="width: 180px;">
                                                                    <input type="text" class="form-control" name="remarks[]" value="{{@$invoiceService->remarks}}">
                                                                </td>
                                                                <td style="width: 90px;">
                                                                    <input type="number" step="any" class="form-control sales_rates" name="sales_rates[]" id="sales_rates-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->sales_rate}}">
                                                                </td>
                                                                <td style="width: 70px;">
                                                                    <input type="number" step="any" class="form-control quantities" name="quantities[]" id="quantities-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->quantity}}">
                                                                </td>
                                                                <td style="width: 80px;">
                                                                    <input type="number" step="any" class="form-control supplier_rates" name="supplier_rates[]" id="supplier_rates-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->supplier_rate}}">
                                                                </td>
                                                                <td style="width: 70px;">
                                                                    <input type="text" readonly class="form-control total_supplier_rates" name="total_supplier_rates[]" id="total_supplier_rates-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->total_supplier_rate}}">
                                                                </td>
                                                                <td style="width: 80px;">
                                                                    <input type="number" step="any" class="form-control agent_commissions" name="agent_commissions[]" id="agent_commissions-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->agent_commission}}">
                                                                </td>
                                                                <td style="width: 70px;">
                                                                    <input type="text" readonly class="form-control total_agent_commissions" name="total_agent_commissions[]" id="total_agent_commissions-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->total_agent_commission}}">
                                                                </td>
                                                                <td style="width: 70px;">
                                                                    <input type="number" step="any" class="form-control taxes" name="taxes[]" id="taxes-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->tax_percentage}}">
                                                                </td>
                                                                <td style="width: 70px;">
                                                                    <input type="text" readonly class="form-control tax_amounts" name="tax_amounts[]" id="tax_amounts-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->tax_amount}}">
                                                                </td>
                                                                <td style="width: 90px;">
                                                                    <input type="text" readonly class="form-control total_amounts" name="total_amounts[]" id="total_amounts-{{$service->id}}" onkeyup="calculate({{$service->id}})" value="{{@$invoiceService->total_amount}}">
                                                                </td>
                                                                <td style="width: 90px;">
                                                                    <input type="number" step="any" class="form-control balances" name="balances[]" id="balances-{{$service->id}}" readonly value="{{@$invoiceService->balance}}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <thead>
                                                        <tr>
                                                            <td colspan="8">
{{--                                                                <a href="/invoices?type={{$type}}&moreServices=1" class="btn btn-secondary">Add more services</a>--}}
                                                            </td>
                                                            <td></td>
                                                            <td class="font-weight-bold">
                                                                Total:
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                Paid:
                                                                <br>
                                                                <br>
                                                                <br>
                                                                <br>
                                                                Due:
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly class="form-control total_amount" name="total_amount" id="total_amount" placeholder="Total" value="{{@$invoiceEdit->total_amount}}">
                                                                <br>
                                                                <input type="number" step="any" class="form-control total_amount_received_amount" name="received_amount" id="total_amount_received_amount" placeholder="Amount" value="{{@$invoiceEdit->received_amount}}" onkeyup="calculateTotalAmountDueAmount()">
                                                                <br>
                                                                <input type="text" readonly class="form-control total_amount_due_amount" name="total_amount_due_amount" id="total_amount_due_amount" placeholder="Amount" value="{{@$invoiceEdit->due_amount}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly class="form-control total_balance" name="total_balance" id="total_balance" placeholder="Total Balance" value="{{@$invoiceEdit->total_balance}}">
                                                            </td>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                @if(@$invoiceEdit)
                                                 <button type="submit" class="btn btn-success float-right">Update</button>
                                                 <a href="/invoices?type={{$type}}" class="btn btn-secondary float-right">Clear Update</a>
                                                @else
                                                    <button type="submit" class="btn btn-primary float-right">Save</button>
                                                @endif
                                            </div>
                                        </form>
                                        <hr>
                                       <div class="row">
                                           <div class="col-6">
                                               <h2>Invoices</h2>
                                           </div>
                                           <div class="col-6">
                                               <a href="{{route('invoices.index', ['is_print'  => true])}}" target="_blank" class="btn btn-secondary btn-sm m-2 float-right text-white">
                                                   Print
                                               </a>
                                           </div>
                                       </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Invoice NO</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Phone</th>
                                                    <th>Customer Address</th>
                                                    <th>Ref Number</th>
                                                    <th>Issue Date</th>
                                                    <th>Total Balance</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($invoices as $index => $invoice)
                                                    <tr>
                                                        <td>{{ $invoice->invoice_no }}</td>
                                                        <td>{{ $invoice->name }}</td>
                                                        <td>{{ $invoice->phone }}</td>
                                                        <td>{{ $invoice->address }}</td>
                                                        <td>{{ $invoice->ref_number }}</td>
                                                        <td>{{ $invoice->issue_date }}</td>
                                                        <td>{{ $invoice->total_amount }}</td>
                                                        <td>
                                                           <div class="btn-group">
                                                               @if(@$moreServices)
                                                                   <a href="/invoices?type={{$type}}&invoiceEditId={{$invoice->id}}&moreServices=1" class="btn btn-success btn-sm">
                                                                       Edit
                                                                   </a>
                                                               @else
                                                                   <a href="/invoices?type={{$type}}&invoiceEditId={{$invoice->id}}" class="btn btn-success btn-sm">
                                                                       Edit
                                                                   </a>
                                                               @endif
                                                               <a href="{{route('invoices.print', $invoice->id)}}" target="_blank" class="btn btn-secondary btn-sm">
                                                                   Print
                                                               </a>
                                                               <a href="{{route('invoices.details', $invoice->id)}}" class="btn btn-primary btn-sm">
                                                                   View
                                                               </a>
                                                           </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                @if(authUser()->type == \App\Models\User::TYPE_ADMIN || authUser()->type == \App\Models\User::TYPE_ACCOUNTANT)
                                <div class="tab-pane" :class="{ active: activeTab === 'detail-invoice' }"
                                     id="detail-invoice">
                                    <div>
                                        @livewire('invoices-component', [
                                            'type' => $type,
                                            'name' => "Detail Sales Report",
                                            'isCustomer' => false,
                                            'isAgent' => false,
                                            'isSupplier' => false,
                                            'customers' => [],
                                            'agents' => [],
                                            'suppliers' => []
                                          ])
                                    </div>
                                </div>
                                <div class="tab-pane" :class="{ active: activeTab === 'customer-sales-report' }"
                                     id="customer-sales-report">
                                    <div>
                                        @livewire('invoices-component', [
                                             'type' => $type,
                                             'name' => "Customer Sales Report",
                                             'isCustomer' => true,
                                             'isAgent' => false,
                                             'isSupplier' => false,
                                             'customers' => $customers,
                                             'agents' => [],
                                             'suppliers' => []
                                           ])
                                    </div>
                                </div>
                                <div class="tab-pane" :class="{ active: activeTab === 'agent-sales-report' }"
                                     id="agent-sales-report">
                                    <div>
                                        @livewire('invoices-component', [
                                             'type' => $type,
                                             'name' => "Agent Sales Report",
                                             'isCustomer' => false,
                                             'isAgent' => true,
                                             'isSupplier' => false,
                                             'customers' => [],
                                             'agents' => $agents,
                                             'suppliers' => []
                                           ])
                                    </div>
                                </div>
                                <div class="tab-pane" :class="{ active: activeTab === 'supplier-sales-report' }"
                                     id="supplier-sales-report">
                                    <div>
                                        @livewire('invoices-component', [
                                             'type' => $type,
                                             'name' => "Supplier Sales Report",
                                             'isCustomer' => false,
                                             'isAgent' => false,
                                             'isSupplier' => true,
                                             'customers' => [],
                                             'agents' => [],
                                             'suppliers' => $suppliers
                                           ])
                                    </div>
                                </div>
                                <div class="tab-pane" :class="{ active: activeTab === 'cash-balance' }"
                                     id="cash-balance">
                                    <div>
                                        @livewire('invoice-cash-balance-component', [
                                             'type' => $type,
                                             'name' => "Cash Balance",
                                             'customers' => $customers,
                                             'agents' => [],
                                             'suppliers' => []
                                           ])
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /card body -->
            </div>
            <!-- /card -->
        </div>
    </div>
</div>
@push('js')
    <script>
        function setCustomer() {
            // Get the select element
            const select = document.getElementById('customer_id');

            // Get the selected index
            const selectedIndex = select.selectedIndex;

            // Access the selected option
            const selectedOption = select.options[selectedIndex];

            // Get the customer data attribute
            const customerData = selectedOption.getAttribute('data-customer');

            // Parse the JSON string to get the customer object
            const customer = JSON.parse(customerData);

            $("#name").val(customer?.name);
            $("#passport").val(customer?.passport);
            $("#phone").val(customer?.phone);
            $("#address").val(customer?.address);
        }

        function calculate(id){
           const salesRate = parseFloat($("#sales_rates-"+id).val() || 0);
           const quantity = parseFloat($("#quantities-"+id).val() || 0);

           const supplierRate = parseFloat($("#supplier_rates-"+id).val() || 0);
           const agentCommission = parseFloat($("#agent_commissions-"+id).val() || 0);
           const tax = parseFloat($("#taxes-"+id).val() || 0);

           const totalSalesRate = salesRate*quantity;
           const totalSupplierRate = supplierRate*quantity;
           const totalAgentCommission = agentCommission*quantity;

            $("#total_supplier_rates-"+id).val(totalSupplierRate);
            $("#total_agent_commissions-"+id).val(totalAgentCommission);

           const taxAmount = totalSalesRate/100*tax;
            $("#tax_amounts-"+id).val(taxAmount);

           const balance = totalSalesRate - totalSupplierRate - totalAgentCommission - taxAmount;
            $("#balances-"+id).val(balance);

            let totalBalance = 0;
            $(".balances").each(function (){
                let $el = $(this);
                totalBalance += parseFloat($el.val() || 0);
            })
            $("#total_balance").val(totalBalance);

            $("#total_amounts-"+id).val(totalSalesRate+taxAmount);

            let totalAmount = 0;
            $(".total_amounts").each(function (){
                let $el = $(this);
                totalAmount += parseFloat($el.val() || 0);
            })
            $("#total_amount").val(totalAmount);

            calculateTotalAmountDueAmount();
            calculateTotalBalanceDueAmount();
        }

        function calculateTotalAmountDueAmount(){
            const total = parseFloat($("#total_amount").val()) || 0;
            const receivedAmount = parseFloat($("#total_amount_received_amount").val()) || 0;
            $("#total_amount_due_amount").val(total - receivedAmount);

            $("#total_balance_received_amount").val(receivedAmount);
            calculateTotalBalanceDueAmount();
        }

        function calculateTotalBalanceDueAmount(){
            const totalBalance = parseFloat($("#total_balance").val()) || 0;
            const receivedAmount = parseFloat($("#total_balance_received_amount").val()) || 0;
            $("#total_balance_due_amount").val(totalBalance - receivedAmount);
        }
    </script>
@endpush
@endsection
