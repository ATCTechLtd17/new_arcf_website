<div>
   <div class="card">
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
               <div class="col-md-3">
                   <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Chart of Account</h5>
                   <select name="agent_id" id="agent_id" id="agent_id" wire:model="agent_id" class="form-control " style="width: 100%!important;">
                       <option value="">--Select Chart of Account--</option>
                       @foreach($chartOfAccounts as $account)
                           <option value="{{$account->id}}">{{$account->name}}</option>
                       @endforeach
                   </select>
               </div>
               <div class="col-md-12">
                   <button class="btn btn-secondary btn-sm float-right"
                           onclick="printDiv('printableArea')"
                   >Print
                   </button>
               </div>
           </div>
       </div>

       <style>
           #printable { display: none; }
           @media print
           {
               #non-printable { display: none; }
               #printable { display: block; }
           }
       </style>

       <div class="table-responsive p-4"
            id="printableArea"
       >
           <div class="d-print-block d-none" style="top: 0; right: 0; left: 0">
                @component('print-page-header', ['title' => 'Expense Details Report'])@endcomponent
           </div>
           <div class="dt-entry__heading" id="printable">
               <h3 class="dt-entry__title text-center mb-3" style="font-size: 24px">{{@$SType?->getLabel()}}</h3>
               <br>
               <h3 class="dt-entry__title text-center mb-3" style="font-size: 24px">{{@$name}}</h3>
               <br>
               @if($date)
                   <span class="dt-entry__title text-center mb-3" style="font-size: 16px">Date: {{@$date}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
               @endif
               @if($from_date)
                   <span class="dt-entry__title text-center mb-3" style="font-size: 16px">From Date: {{@$from_date}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               @endif
               @if($to_date)
                   <span class="dt-entry__title text-center mb-3" style="font-size: 16px">To Date: {{@$to_date}}</span>
               @endif
           </div>
           <br>
           <table class="table table-bordered">
               <thead>
               <tr>
                   <th>ID</th>
                   <th>Chart of Account</th>
                   <th>Agent</th>
                   <th>Supplier</th>
                   <th>Rate</th>
                   <th>Quantity</th>
                   <th>Amount</th>
                   <th>Remarks</th>
                   <th>Total Amount</th>
                   <th>CreatedAt</th>
               </tr>
               </thead>
               <tbody>
               @php
                   $grandTotalBalance = 0;
               @endphp
               @foreach($expenses as $index => $expense)
                   <tr>
                       <td>{{ $expense->id }}</td>
                       <td>{{ $expense->chart_of_account?->name }}</td>
                       <td>{{ $expense->agent?->name }}</td>
                       <td>{{ $expense->supplier?->name }}</td>
                       <td>
                           @foreach($expense->details as $index => $detail)
                               <span>{{@$detail->rate}}</span>
                               <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                           @endforeach
                       </td>
                       <td>
                           @foreach($expense->details as $index => $detail)
                               <span>{{@$detail->quantity}}</span>
                               <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                           @endforeach
                       </td>
                       <td>
                           @foreach($expense->details as $index => $detail)
                               <span>{{@$detail->amount}}</span>
                               <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                           @endforeach
                       </td>
                       <td>
                           @foreach($expense->details as $index => $detail)
                               <span>{{@$detail->remarks}}</span>
                               <hr style="margin-top: 0.6rem;margin-bottom: 0.6rem;">
                           @endforeach
                       </td>
                       <td>
                           {{ $expense->total_amount }}
                           @php($grandTotalBalance+=@$expense->total_amount)
                       </td>
                       <td>{{format_datetime($expense->created_at)}}</td>
                   </tr>
               @endforeach
               </tbody>
               <tfoot>
               <tr>
                    <td colspan="8"></td>
                   <td><strong>{{$grandTotalBalance}}</strong></td>
               </tr>
               </tfoot>
           </table>
           <div class="mt-2">
               {{ $expenses->links() }}
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
