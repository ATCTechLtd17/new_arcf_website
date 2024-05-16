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
<div class="position-absolute" style="top: 0; right: 0; left: 0">
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
                <span class="float-left" style="font-size: 26px;text-align: left;margin-left: 190px;color: #8e7920; font-weight: bold;">ARCF</span>
                <br><br>
                <div style="margin-right: 55px;!important;">{{authUserServiceType()->getShortLabel()}}</div>
            </h4>
            <h4 class="text-right" style="font-size: 14px;margin-top: 20px!important;font-weight: bold;margin-right: 80px;"> <span>Email: {{authUserServiceType()->getAddress()['email']}}</span></h4>
            <img src="{{authUserServiceType()->getLogoUrl()}}" alt="{{authUserServiceType()->getLabel()}}" class="float-right" style="width: 100px; margin-top: -130px;margin-right: 295px;z-index: 1">
        </div>

        <div class="col-12" style="border-top: 2px solid gray"></div>
    </div>

    <h1 class="text-center text-decoration-underline" style="font-size: 38px;">Income vs Expense</h1>
    <h5 style="text-align: center">
        @if($date)
            Date:  {{format_date($date)}}
        @endif
        <br>
        @if($fromDate)
            From Date:  {{format_date($fromDate)}}
        @endif
        @if($toDate)
            To Date:  {{format_date($toDate)}}
        @endif
    </h5>
</div>
<div style="padding-top: 220px;">
    <table class="table table-bordered">
        <tr>
            <th>
                <h2>Income from Invoice</h2>
                <table class="table table-bordered" style="margin-right: 28px!important;">
                    <thead>
                    <tr>
                        <th>Issue Date</th>
                        <th>Invoice NO</th>
                        <th>Customer Name</th>
                        <th>Profit Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalIncomeAmount = 0;
                        $totalExpenseAmount = 0;
                        $totalDuePaymentsAmount = 0;
                    @endphp
                    @foreach($invoices as $index => $invoice)
                        @php($totalIncomeAmount+=$invoice->total_amount)
                        <tr>
                            <td>{{ format_date($invoice->issue_date, 'd-m-y') }}</td>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->name }}</td>
                            <td>{{ $invoice->total_balance }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-weight-bold">Grand Total</td>
                        <td><strong>{{$totalIncomeAmount}}</strong></td>
                    </tr>
                    </tfoot>
                </table>
            </th>
            <th>
                <h2>Expenses</h2>
                <table style="margin-left: 28px!important;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Chart of Account</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $index => $expense)
                        @php($totalExpenseAmount+=$expense->total_amount)
                        <tr>
                            <td>{{ format_date($expense->created_at, 'd-m-y') }}</td>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->chart_of_account?->name }}</td>
                            <td>{{ $expense->total_amount }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-weight-bold">Grand Total</td>
                        <td><strong>{{$totalExpenseAmount}}</strong></td>
                    </tr>
                    </tfoot>
                </table>
            </th>
        </tr>
    </table>
</div>
<script>
    window.print();
</script>
</body>
</html>
