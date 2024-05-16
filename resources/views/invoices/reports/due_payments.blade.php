@extends('layouts.app')
@section('title', "Invoice Due Payments Report")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Invoice Due Payments Report"}}</h3>
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
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Invoice No:
                                        <input type="text" class="form-control" id="q" name="q" value="{{request()->get('q')}}">
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>From Date:
                                        <input type="date" class="form-control" id="from_date" name="from_date" value="{{request()->get('from_date')}}">
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>To Date:
                                        <input type="date" class="form-control" id="to_date" name="to_date" value="{{request()->get('to_date')}}">
                                    </h5>
                                </div>

                                <div class="col-md-3">
                                    <button class="btn btn-secondary btn-sm float-right">Search</button>
                                </div>
                            </div>
                        </form>

                        <h2 class="text-center">{{authUser()->service_type->getLabel()}}</h2>
                        <h4 class="text-center">Due Payments Report</h4>
                        <button class="btn btn-secondary btn-sm float-right mb-3" onclick="printDiv('printReport')">Print</button>
                       <div id="printReport">
                           <div class="d-print-block d-none">
                               @component('print-page-header', ['title' => "Invoice Due Payments Report"])@endcomponent
                           </div>
                           <div class="table-responsive">
                               <table class="table table-bordered">
                                   <thead>
                                   <tr>
                                       <th>Invoice No</th>
                                       <th>Service Name</th>
                                       <th>Customer Name</th>
                                       <th>Payment Date</th>
                                       <th>Amount</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @php
                                       $totalAmount = 0;
                                       $totalInvoiceTotal = 0;
                                       $totalBalance = 0;
                                   @endphp
                                   @foreach($payments as $index => $payment)
                                       <tr>
                                           <td>{{ $payment->invoice->invoice_no }}</td>
                                           <td>
                                               @foreach($payment->invoice->services as $service)
                                                   {{@$service->service->name}},
                                               @endforeach
                                           </td>
                                           <td>{{ @$payment->invoice->name }}</td>
                                           <td>{{ @$payment->date }}</td>
                                           <td style="text-align: right">
                                               {{ money_format($payment->amount) }}
                                               @php $totalAmount+=$payment->amount @endphp
                                           </td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                                   <tfoot>
                                   <th colspan="4">
                                       <span class="text-right float-right">Total</span>
                                   </th>
                                   <td>
                                       <strong class="text-right float-right">{{money_format($totalAmount)}}</strong>
                                   </td>
                                   </tfoot>
                               </table>
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
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
@endsection
