<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acc">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/lite-style-1.min.css') }}">
</head>
<body>
 <div class="dt-content">
    <div class="row">
        <div class="col-12">
            <div class="card-body">
                <center>
                    @if($invoice->type == \App\Models\Invoice::TYPE_TRAVEL_TOURISM)
                        <img src="{{asset('images/ARCF Travel Logo JPG.jpg')}}" alt="" class="text-center" style="width: 140px">
                        <h1 class="text-center">ARCF for Travel and Tourism Co. L.L.C</h1>
                    @endif
                    @if($invoice->type == \App\Models\Invoice::TYPE_DOCUMENTS_CLEARING)
                        <img src="{{asset('images/ARCF Logo New-01.jpg')}}" alt="" class="text-center" style="width: 140px">
                        <h1 class="text-center">ARCF for Documents Clearing Co. L.L.C</h1>
                    @endif
                </center>
                <div class="row">
                    <div class="col-6">
                        <h5>
                            Customer Name: {{@$invoice->name}}
                        </h5>
                    </div>
                    <div class="col-6">
                        <h5>
                            Customer Phone: {{@$invoice->phone}}
                        </h5>
                    </div>
                    <div class="col-6">
                        <h5>
                            Customer Address: {{@$invoice->address}}
                        </h5>
                    </div>
                    <div class="col-6">
                        <h5>
                            Ref Number: {{@$invoice->ref_number}}
                        </h5>
                    </div>
                    <div class="col-6">
                        <h5>Invoice NO: {{@$invoice->invoice_no}}
                    </div>
                    <div class="col-6">
                        <h5>
                            Issue Date: {{@$invoice->issue_date}}
                        </h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Service</th>
                            <th>Sales Rate</th>
                            <th>Supplier Rate</th>
                            <th>Agent Commission</th>
                            <th>Balance</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                        <tbody id="dcInvoiceTableBody">
                        @foreach($invoice->services as $index => $service)
                            <tr>
                                <td>
                                    {{$index+1}}. {{ $service->service->name }}
                                </td>
                                <td>
                                    {{@$service->sales_rate}}
                                </td>
                                <td>
                                    {{@$service->supplier_rate}}
                                </td>
                                <td>
                                    {{@$service->agent_commission}}
                                </td>
                                <td>
                                    {{@$service->balance}}
                                </td>
                                <td>
                                    {{@$service->remarks}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <td colspan="3"></td>
                            <td></td>
                            <td>
                                <span id="totalDCInvoiceBalance" class="font-weight-bold">{{@$invoice->total_balance}}</span>
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
</body>
</html>
