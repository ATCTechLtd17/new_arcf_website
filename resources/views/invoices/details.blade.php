@extends('layouts.app')
@section('title', "Income")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Invoice Details"}}</h3>
        </div>
    </div>
    <div class="row">
        @push('css')
            <style>

            </style>
        @endpush
        <div class="col-xl-12">
            <div class="dt-content card">
                <div class="row">
                    <div class="col-12 float-right">
                        <div class="btn-group float-right">
                            <a href="/invoices?type={{authUserServiceType()}}&invoiceEditId={{$invoice->id}}" class="btn btn-success btn-sm">
                                Edit
                            </a>
                            <a href="{{route('invoices.print', $invoice->id)}}" target="_blank" class="btn btn-secondary btn-sm">
                                Print
                            </a>
                            <a href="/invoices?type={{authUserServiceType()}}" class="btn btn-danger btn-sm">
                                Close
                            </a>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <h1 class="text-center text-decoration-underline" style="font-size: 38px;">Invoice/Bill</h1>
                    </div>
                    <div class="col-6 float-left">
            <span>
                To: <strong>{{$invoice->name}}</strong>
            </span>
                        <br>
                        <span>
                Passport/EID: <strong>{{@$invoice->customer->passport}}</strong>
            </span>
                        <br>
                        <span>
                Mobile: {{$invoice->phone}}
            </span>
                        <br>
                        <span>
                Address: {{$invoice->address}}
            </span>
                    </div>

                    <div class="col-6 float-right text-right">
                        <strong>
                            Invoice No: {{$invoice->invoice_no}}
                        </strong>
                        <br>
                        <span>
                Date: {{date_format($invoice->created_at, 'd M y')}}
            </span>
                        <br>
                        <span>
                Ref: {{$invoice->ref_number}}
            </span>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="font-weight: bold;background-color: #8e7920!important;color: white;">Service</th>
                                    <th style="font-weight: bold;background-color: #8e7920!important;color: white;">Remarks</th>
                                    <th style="font-weight: bold;background-color: #8e7920!important;color: white;text-align: center;">
                                        <span>Sales Price</span>
                                    </th>
                                    <th style="font-weight: bold;background-color: #8e7920!important;color: white;text-align: center;">
                                        <span>Quantity</span>
                                    </th>
                                    <th style="font-weight: bold;background-color: #8e7920!important;color: white;text-align: center;">
                                        <span>Tax Amount</span>
                                    </th>
                                    <th style="font-weight: bold;background-color: #8e7920!important;color: white;width: 120px;">
                                        <span style="float: right;text-align: right;">Total Amount</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="dcInvoiceTableBody">
                                @foreach($invoice->services as $index => $service)
                                    <tr>
                                        <td>
                                            {{$index+1}}. {{ $service->service->name }}
                                        </td>
                                        <td>
                                            {{@$service->remarks}}
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="font-weight-bold">{{number_format(@$service->sales_rate,2)}}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="font-weight-bold">{{@$service->quantity}}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="font-weight-bold">{{number_format(@$service->tax_amount,2)}}</span>
                                        </td>
                                        <td>
                                            <span class="float-right font-weight-bold">{{number_format(@$service->total_amount,2)}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <thead>
                                <tr>
                                    <td colspan="5">
                             <span class="text-left">
                                <strong>In Words: </strong> {{ (new \App\Helpers\NumberToWords())->convertToWords($invoice->total_amount) }} only
                           </span>
                                        <span class="float-right text-right font-weight-bold"> Grand Total</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold float-right">{{number_format(@$invoice->total_amount, 2)}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <span class="float-right text-right font-weight-bold">Paid Amount</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold float-right">{{number_format(@$invoice->total_paid_amount, 2)}}</span>
                                    </td>
                                </tr>
                                @if($invoice->due_paid_amount != 0)
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">
                                            Due Paid
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-right float-right">{{number_format($invoice->due_paid_amount, 2)}}</span>
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td colspan="5" class="text-right font-weight-bold">
                                        Due Amount
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-right float-right">{{number_format($invoice->due_amount - $invoice->due_paid_amount, 2)}}</span>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>

    </script>
@endpush
@endsection
