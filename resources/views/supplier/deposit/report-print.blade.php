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
            <h1 class="text-center text-decoration-underline" style="font-size: 38px;">Supplier Deposits Report</h1>
        </div>

        <div class="col-12 mt-4">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><strong>Name</strong></th>
                        <th><strong>Phone</strong></th>
                        <th><strong>Services</strong></th>
                        <th><strong>Total Deposit</strong></th>
                        <th><strong>Invoice Total</strong></th>
                        <th><strong>Balance</strong></th>
                        <th><strong>Credit</strong></th>
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
                            <td style="width: 280px;">
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
