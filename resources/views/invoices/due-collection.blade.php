@extends('layouts.app')
@section('title', "Due Collection")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Due Collection"}}</h3>
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
