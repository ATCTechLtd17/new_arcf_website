<div class="row">
   <div class="col-9 m-auto">
       <div class="card p-2">
           <div class="card-body">
               <div class="row">
                   <div class="col-md-3">
                       <h5>Date:
                           <input type="date" class="form-control" id="date" wire:model="date">
                       </h5>
                   </div>
                   <div class="col-md-3">
                       <h5>From Date:
                           <input type="date" class="form-control" id="from_date" wire:model="from_date">
                       </h5>
                   </div>
                   <div class="col-md-3">
                       <h5>To Date:
                           <input type="date" class="form-control" id="to_date" wire:model="to_date">
                       </h5>
                   </div>

                   <div class="col-md-12">
                       <a href="{{route('income-vs-expense-print', ['date' => @$date, 'from_date' => @$from_date, 'to_date' => @$to_date])}}" class="btn btn-secondary btn-sm float-right" target="_blank">Print</a>
                   </div>

               </div>
           </div>

           <div class="row">
               <div class="col-6">
                   <h2>Income from Invoice</h2>
                   <div class="table-responsive">
                       <table class="table table-bordered">
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
                               @php($totalIncomeAmount+=$invoice->total_balance)
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
                   </div>
               </div>
               {{--       <div class="col-4">--}}
               {{--           <h2>Income from Due Payments</h2>--}}
               {{--           <div class="table-responsive">--}}
               {{--               <table class="table table-bordered">--}}
               {{--                   <thead>--}}
               {{--                   <tr>--}}
               {{--                       <th>Date</th>--}}
               {{--                       <th>Invoice NO</th>--}}
               {{--                       <th>Service Name</th>--}}
               {{--                       <th>Customer Name</th>--}}
               {{--                       <th>Amount</th>--}}
               {{--                   </tr>--}}
               {{--                   </thead>--}}
               {{--                   <tbody>--}}
               {{--                   @foreach($payments as $index => $payment)--}}
               {{--                       <tr>--}}
               {{--                           <td>{{ format_date(@$payment->date) }}</td>--}}
               {{--                           <td>{{ $payment->invoice->invoice_no }}</td>--}}
               {{--                           <td>--}}
               {{--                               @foreach($payment->invoice->services as $service)--}}
               {{--                                   {{@$service->service->name}},--}}
               {{--                               @endforeach--}}
               {{--                           </td>--}}
               {{--                           <td>{{ @$payment->invoice->name }}</td>--}}
               {{--                           <td style="text-align: right">--}}
               {{--                               {{ money_format($payment->amount) }}--}}
               {{--                               @php($totalDuePaymentsAmount+=$payment->amount)--}}
               {{--                           </td>--}}
               {{--                       </tr>--}}
               {{--                   @endforeach--}}
               {{--                   </tbody>--}}
               {{--                   <tfoot>--}}
               {{--                   <tr>--}}
               {{--                       <td colspan="3" class="text-right font-weight-bold">Grand Total</td>--}}
               {{--                       <td>--}}
               {{--                           <strong class="text-right float-right">{{money_format($totalDuePaymentsAmount)}}</strong>--}}
               {{--                       </td>--}}
               {{--                   </tr>--}}
               {{--                   </tfoot>--}}
               {{--               </table>--}}
               {{--           </div>--}}
               {{--       </div>--}}
               <div class="col-6">
                   <h2>Expenses</h2>
                   <div class="table-responsive">
                       <table class="table table-bordered">
                           <thead>
                           <tr>
                               <th>Date</th>
                               <th>ID</th>
                               <th>Chart of Account</th>
                               {{--                           <th>Agent</th>--}}
                               {{--                           <th>Supplier</th>--}}
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
                                   {{--                               <td>{{ $expense->agent?->name }}</td>--}}
                                   {{--                               <td>{{ $expense->supplier?->name }}</td>--}}
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
                   </div>
               </div>
           </div>
       </div>
       <script>
           function printDiv(divId) {
               var printContents = document.getElementById(divId).innerHTML;
               var originalContents = document.body.innerHTML;

               document.body.innerHTML = printContents;

               window.print();

               document.body.innerHTML = originalContents;
           }
       </script>
   </div>
</div>
