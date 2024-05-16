<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acc">
    <title>
        Invoice of {{$invoice->type->getLabel()}}
    </title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/lite-style-1.min.css') }}">
    <style>
        .table th, .table td{
            padding: 0.8rem!important;
        }
    </style>
</head>
<body>
<div class="dt-content">
    <div class="row">
        <div class="col-6" style="font-size: 14px">
            <strong>Office Address</strong>
            <br>
            {{$invoice->type->getAddress()['address']}}
            <br>
            {{$invoice->type->getAddress()['address2']}}
            <br>
            {{$invoice->type->getAddress()['address3']}}
            <br>
            <strong>PHONE : {{$invoice->type->getAddress()['phone']}}</strong>
            <br>
            <strong>MOBILE : {{$invoice->type->getAddress()['mobile']}}</strong>
        </div>
        <div class="col-6 float-right">
            <h4 class="text-right" style="font-size: 14px;margin-top: 12px!important;z-index: 9999">
               @if($invoice->type->value == 'TRAVEL_TOURISM')
                    <span class="float-left" style="font-size: 26px;text-align: left;margin-left: 180px;color: #8e7920; font-weight: bold;">ARCF</span>
                    <br><br>
                    <div style="margin-right: 55px;!important;">{{$invoice->type->getShortLabel()}}</div>
               @endif
               @if($invoice->type->value == "DOCUMENTS_CLEARING")
                   <span class="float-left" style="font-size: 26px;text-align: left;margin-left: 180px;color: #8e7920; font-weight: bold;">ARCF</span>
                   <br><br>
                   <div style="margin-right: 200px;!important;">DOCUMENTS</div>
                   <div style="margin-right: 94px;!important;">CLEARING SERVICES CO. L.L.C</div>
               @endif
            </h4>
            <h4 class="text-right" style="font-size: 14px;margin-top: 20px!important;font-weight: bold;margin-right: 80px;"> <span>Email: {{$invoice->type->getAddress()['email']}}</span></h4>
            <img src="{{$invoice->type->getLogoUrl()}}" alt="{{$invoice->type->getLabel()}}" class="float-right" style="width: 100px; margin-top: -130px;margin-right: 295px;z-index: 1">
        </div>

        <div class="col-12" style="border-top: 2px solid gray"></div>

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

<div class="dt-content" style="position: absolute;bottom: 0;width: 100%">
    <div class="row">
        <div class="col-12">
            <h4>
                <strong>Payment Status: </strong> {{$invoice->payment_status}}
                <br>
                <br>
                <strong class="text-danger">Important Notes:</strong>
                <br>
                1.	Air Line Refund will be processed, if received in writing within 15 days from the refund requested date.
                <br>
                2.	The Visa Fee Non-Refundable, in case the visa application is not approved by the immigration authority.
                <br>
                3.	This is computer generated, invoice no, signature and stamp are not required.
            </h4>
            <br>
            <h4>
                <strong>Prepared by:</strong> {{authUser()->name}}
            </h4>
        </div>
        <div class="col-12 m-auto">
            <center>
                <strong class="float-center text-center" style="margin-right: 10px;">Office Location</strong>
                <br>
                <img src="{{asset('images/qr_code.png')}}" alt="" class="text-center float-center" style="width: 100px">
            </center>
            <br>
        </div>
        <div class="col-12 text-center" style="border: 1px solid gold; height: 120px!important;padding: 10px!important;margin-bottom: 28px;border-radius: 10px;">
            <div class="row">
                <div class="col-4">
                    <h3 class="mt-8">{{authUser()->name}}</h3>
                </div>
                <div class="col-4">
                    <h1 class="text-danger text-center mt-8">Thank you for using our services</h1>
                </div>
                <div class="col-4">
                    <h3 class="mt-8">Customer Signature</h3>
                </div>
            </div>
        </div>
{{--        <div class="col-12">--}}
{{--            <strong>Manager Signature</strong>--}}
{{--            <strong class="float-right">Agent Signature</strong>--}}
{{--            <hr>--}}
{{--        </div>--}}
{{--        <div class="col-6 float-right"  style="font-size: 12px">--}}
{{--            <strong class="float-right" style="margin-right: 10px;">Office Location</strong>--}}
{{--            <br>--}}
{{--            <img src="{{asset('images/qr_code.png')}}" alt="" class="text-center float-right" style="width: 100px">--}}
{{--        </div>--}}
    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>
