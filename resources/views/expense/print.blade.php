<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acc">
    <title>
        Expense of {{$expense->type->getLabel()}}
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
        <div class="col-12">
            <div class="card-body">
                <h1 class="float-right">Expense NO: {{$expense->id}}
                    <br>
                    <span class="float-right" style="font-size: 12px;">Date: {{date_format($expense->created_at, 'd M y')}}</span>
                </h1>
                <img src="{{$expense->type->getLogoUrl()}}" alt="" class="text-center" style="width: 140px; margin-top: -40px;">
                <h1 class="text-center" style="font-size: 32px">{{$expense->type->getLabel()}}</h1>
                <br>
                <h1 class="text-center" style="font-size: 24px;">Expense</h1>
                <br><br>
                <div class="row">
                    <div class="col-6">
                        <h5>
                            Chart of Account: {{@$expense->chart_of_account?->name}}
                        </h5>
                    </div>
                    <div class="col-6">
                        <h5>
                            Agent: {{@$expense->agent?->name}}
                        </h5>
                    </div>
                    <div class="col-6">
                        <h5>
                            Supplier: {{@$expense->supplier?->name}}
                        </h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="font-weight: bold;">Description</th>
                            <th style="font-weight: bold;">Rate</th>
                            <th style="font-weight: bold;">Quantity</th>
                            <th style="font-weight: bold;">Tax %</th>
                            <th style="font-weight: bold;">Total</th>
                            <th style="font-weight: bold;">Remarks</th>
                        </tr>
                        </thead>
                        <tbody id="dcInvoiceTableBody">
                        @foreach($expense->details as $index => $detail)
                            <tr>
                                <td>
                                    {{$index+1}}. {{ $detail->description }}
                                </td>
                                <td>
                                    {{$detail->rate}}
                                </td>
                                <td>
                                    {{$detail->quantity}}
                                </td>
                                <td>
                                    {{$detail->tax_percentage}}
                                </td>
                                <td>
                                    {{$detail->total_amount}}
                                </td>
                                <td>
                                    {{$detail->remarks}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span id="totalDCInvoiceBalance" class="font-weight-bold">{{@$expense->total_amount}}</span>
                            </td>
                            <td></td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dt-content" style="position: absolute;bottom: 0;width: 100%">
    <div class="row">
        <div class="col-12">
            <h1>Thanks our beloved costomer</h1>
            <br><br>
            <br><br>
        </div>
        <div class="col-12">
            <strong>Manager Signature</strong>
            <strong class="float-right">Agent Signature</strong>
            <hr>
        </div>
        <div class="col-6" style="font-size: 12px">
            <strong>Office Address</strong>
            <br>
            {{$expense->type->getLabel()}}
            <br>
            PLOT NO- 235. FLAT NO- 101.
            <br>
            AL NAIF BUILDING, NAIF, DEIRA DUBAI, UAE.
            <br>
            <span>PHONE : +971 44518790</span>
            <br>
            <span>MOBILE :+971 585 380 301.</span>
            <br>
            <span>Email: dubaiarcf@gmail.com</span>
        </div>
        <div class="col-6 float-right"  style="font-size: 12px">
            <strong class="float-right" style="margin-right: 10px;">Office Location</strong>
            <br>
            <img src="{{asset('images/qr_code.png')}}" alt="" class="text-center float-right" style="width: 100px">
        </div>
    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>
