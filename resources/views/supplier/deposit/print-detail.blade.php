<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acc">
    <title>
        Invoice of {{authUserServiceType()->getLabel()}}
    </title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/lite-style-1.min.css') }}">
    <style>
        .table th, .table td{
            padding: 0.8rem!important;
        }
        table th{
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
    </style>
    @php
        $totalAmount = 0;
    @endphp
</head>
<body>
<div class="dt-content">
    <div class="row">
        <div class="col-6" style="font-size: 14px">
            <strong>Office Address</strong>
            <br>
            {{authUserServiceType()->getAddress()['address']}}
            <br>
            {{authUserServiceType()->getAddress()['address2']}}
            <br>
            {{authUserServiceType()->getAddress()['address3']}}
            <br>
            <strong>PHONE : {{authUserServiceType()->getAddress()['phone']}}</strong>
            <br>
            <strong>MOBILE : {{authUserServiceType()->getAddress()['mobile']}}</strong>
        </div>
        <div class="col-6 float-right">
            <h4 class="text-right" style="font-size: 14px;margin-top: 12px!important;z-index: 9999">
                <span class="float-left" style="font-size: 26px;text-align: left;margin-left: 180px;color: #8e7920; font-weight: bold;">ARCF</span>
                <br><br>
                <div style="margin-right: 55px;!important;">{{authUserServiceType()->getShortLabel()}}</div>
            </h4>
            <h4 class="text-right" style="font-size: 14px;margin-top: 20px!important;font-weight: bold;margin-right: 80px;"> <span>Email: {{authUserServiceType()->getAddress()['email']}}</span></h4>
            <img src="{{authUserServiceType()->getLogoUrl()}}" alt="{{authUserServiceType()->getLabel()}}" class="float-right" style="width: 100px; margin-top: -130px;margin-right: 295px;z-index: 1">
        </div>

        <div class="col-12" style="border-top: 2px solid gray"></div>

        <div class="col-12 mt-4">
            <h1 class="text-center text-decoration-underline" style="font-size: 38px;">Supplier Deposits Details</h1>
        </div>

        <div class="col-12 mt-4">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><strong>Deposit To</strong></th>
                        <th><strong>Amount</strong></th>
                        <th><strong>Deposit For</strong></th>
                        <th><strong>Deposit Method</strong></th>
                        <th><strong>Deposited by</strong></th>
                        <th><strong>Deposit Date</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($supplierDeposits as $index => $deposit)
                        @php
                            $totalAmount += $deposit->amount;
                        @endphp
                        <tr>
                            <td>{{ $deposit->supplier->name }}</td>
                            <td>{{ number_format($deposit->amount, 2) }}</td>
                            <td>{{ @$deposit->service->name }}</td>
                            <td>{{ @$deposit->method->name }}</td>
                            <td>{{ $deposit->deposited_by }}</td>
                            <td>{{ $deposit->date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="6">
                            <strong>{{number_format($totalAmount, 2)}}</strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="dt-content" style="position: absolute;bottom: 0;width: 100%">
    <div class="row">
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
