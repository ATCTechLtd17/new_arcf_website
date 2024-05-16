<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acc">
    <title>
        Customer Money Receipt
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
            {{authUser()->service_type->getAddress()['address']}}
            <br>
            {{authUser()->service_type->getAddress()['address2']}}
            <br>
            {{authUser()->service_type->getAddress()['address3']}}
            <br>
            <strong>PHONE : {{authUser()->service_type->getAddress()['phone']}}</strong>
            <br>
            <strong>MOBILE : {{authUser()->service_type->getAddress()['mobile']}}</strong>
        </div>
        <div class="col-6 float-right">
            <h4 class="text-right" style="font-size: 14px;margin-top: 12px!important;z-index: 9999">
                <span class="float-left" style="font-size: 26px;text-align: left;margin-left: 180px;color: #8e7920; font-weight: bold;">ARCF</span>
                <br><br>
               <div style="margin-right: 55px;!important;">{{authUser()->service_type->getShortLabel()}}</div>
            </h4>
            <h4 class="text-right" style="font-size: 14px;margin-top: 20px!important;font-weight: bold;margin-right: 80px;"> <span>Email: {{authUser()->service_type->getAddress()['email']}}</span></h4>
            <img src="{{authUser()->service_type->getLogoUrl()}}" alt="{{authUser()->service_type->getLabel()}}" class="float-right" style="width: 100px; margin-top: -130px;margin-right: 295px;z-index: 1">
        </div>

        <div class="col-12" style="border-top: 2px solid gray"></div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="col-6 float-left">
            <span>
                To: <strong>{{$advance->invoice->name}}</strong>
            </span>
            <br>
            <span>
                Passport/EID: <strong>{{@$advance->customer->passport}}</strong>
            </span>
            <br>
            <span>
                Mobile: {{$advance->invoice->phone}}
            </span>
            <br>
            <span>
                Address: {{$advance->invoice->address}}
            </span>
        </div>

        <div class="col-6 float-right text-right">
            <strong>
                Money Receipt No: {{$advance->id}}
            </strong>
            <br>
            <span>
                Date: {{date_format($advance->invoice->created_at, 'd M y')}}
            </span>
            <br>
            <span>
                Ref: {{$advance->invoice->ref_number}}
            </span>
        </div>

        <br><br><br><br><br><br><br><br><br>
        <div class="col-12 mt-4">
            <div class="col-12 mt-2">
                <h1 class="text-center text-decoration-underline" style="font-size: 38px;">Money Receipt</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="font-weight: bold;background-color: #8e7920!important;color: white;">Type</th>
                        <th style="font-weight: bold;background-color: #8e7920!important;color: white;text-align: center;">
                            <span>Customer</span>
                        </th>
                        <th style="font-weight: bold;background-color: #8e7920!important;color: white;width: 120px;">
                            <span style="float: right;text-align: right;">Description</span>
                        </th>
                        <th style="font-weight: bold;background-color: #8e7920!important;color: white;text-align: center;">
                            <span>Invoice</span>
                        </th>
                        <th style="font-weight: bold;background-color: #8e7920!important;color: white;text-align: center;">
                            <span>Deposited Amount</span>
                        </th>
                        @if($advance->refund_amount)
                            <th style="font-weight: bold;background-color: #8e7920!important;color: white;width: 120px;">
                                <span style="float: right;text-align: right;">Refund Amount</span>
                            </th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="dcInvoiceTableBody">
                    <tr>
                        <td>{{$advance->type->name}}</td>
                        <td>{{$advance->customer?->name}}</td>
                        <td style="text-align: center;">
                            {{$advance->remarks}}
                        </td>
                        <td>
                            Invoice No: {{ $advance->invoice?->invoice_no }}  |
                            {{ $advance->invoice?->name }}
                        </td>
                        <td style="text-align: center;">
                            <span class="font-weight-bold">{{number_format(@$advance->in_amount,2)}}</span>
                        </td>
                        @if($advance->refund_amount)
                            <td style="text-align: center;">
                                <span class="font-weight-bold">{{number_format(@$advance->refund_amount,2)}}</span>
                            </td>
                        @endif
                    </tr>
                    </tbody>
                    <thead>

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
    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>
