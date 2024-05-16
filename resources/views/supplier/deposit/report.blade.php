@extends('layouts.app')
@section('title', "Supplier Deposits Report")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Supplier Deposits Report"}}</h3>
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
                    padding: 0.8rem!important;
                }
            </style>
        @endpush
        <div class="col-xl-12">
            <!-- Card -->
            <div class="dt-card dt-card__full-height">
                <!-- Card Body -->
                <div class="dt-card__body">
                    <div>
                        <h2 class="text-center">{{authUser()->service_type->getLabel()}}</h2>
                        <h4 class="text-center">Supplier Deposit Report</h4>
                        <a href="{{route('supplier-deposits-report', ['is_print'  => true])}}" target="_blank" class="btn btn-secondary btn-sm float-right mb-2 text-white">
                            Print
                        </a>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Services</th>
                                    <th class="text-right">Total Deposit</th>
                                    <th class="text-right">Invoice Total</th>
                                    <th class="text-right">Balance</th>
                                    <th class="text-right">Credit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                     $totalDeposit = 0;
                                     $totalInvoiceTotal = 0;
                                     $totalBalance = 0;
                                     $totalCredit = 0;
                                @endphp
                                @foreach($suppliers as $index => $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>
                                            @foreach($supplier->deposits as $deposit)
                                                {{@$deposit->service->name}} = {{@$deposit->amount}}
                                            @endforeach
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($supplier->total_deposit_amount, 2) }}
                                            @php $totalDeposit+=$supplier->total_deposit_amount @endphp
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($supplier->total_invoice_rate_amount, 2) }}
                                            @php $totalInvoiceTotal+=$supplier->total_invoice_rate_amount @endphp
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($supplier->balance, 2) }}
                                            @php $totalBalance+=$supplier->balance @endphp
                                        </td>
                                        <td class="text-right">
                                            @if($supplier->total_deposit_amount < $supplier->total_invoice_amount)
                                                {{ number_format($supplier->balance, 2) }}
                                                @php $totalCredit+=$supplier->balance @endphp
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th colspan="3">
                                    <span class="text-right float-right">Total</span>
                                </th>
                                <td>
                                    <strong class="text-right float-right">{{number_format($totalDeposit, 2)}}</strong>
                                </td>
                                <td>
                                    <strong class="text-right float-right">{{number_format($totalInvoiceTotal, 2)}}</strong>
                                </td>
                                <td>
                                    <strong class="text-right float-right">{{number_format($totalBalance, 2)}}</strong>
                                </td>
                                <td>
                                    <strong class="text-right float-right">{{number_format($totalCredit, 2)}}</strong>
                                </td>
                                </tfoot>
                            </table>
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

    </script>
@endpush
@endsection
