<div>
    <div class="row">
        <div class="col-md-3">
            <label for="from_date">From Date</label>
            <input type="date" class="form-control" id="from_date" wire:model="from_date">
        </div>
        <div class="col-md-3">
            <label for="to_date">To Date</label>
            <input type="date" class="form-control" id="to_date" wire:model="to_date">
        </div>

        <div class="col-md-12">
            <a class="btn btn-secondary btn-sm float-right" href="/dashboard?is_print=1&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">Print</a>
        </div>
    </div>
    <br><br>
    <div class="row">
        @php
            $expensesTotal = $totalExpenseAmount+$totalSupplierExpenseAmount+$totalAgentExpenseAmount;
            $totalInAmount = 0;
            $totalOutAmount = 0;
            $totalBalance = 0;
        @endphp
        <div class="col-10 m-auto">
            <table style="width: 100%">
                <tr>
                    <td style="float: left;margin-left: 50px;">
                        <div>
                            <h1 class="text-right">Sales Detail</h1>
                            <h4 class="text-right">
                                Invoice Total: <strong>{{$salesDetails['invoice_total']}}</strong>
                                <br><br>
                                Paid: <strong>{{$salesDetails['paid']}}</strong>
                                <br><br>
                                Customer Due: <strong>{{$salesDetails['customer_due']}}</strong>
                                <br><br>
                                Credit: <strong>{{$salesDetails['credit']}}</strong>
                                <br><br>
                                Top-up Amount: <strong>{{$salesDetails['topUpAmount']}}</strong>
                                <br><br>
                                Supplier Deposit Balance: <strong>{{$salesDetails['supplier_deposit_balance']}}</strong>
                            </h4>
                        </div>
                    </td>
                    <td style="float: right">
                        <h1 class="text-right">Supplier Payment Details</h1>
                        <h4 class="text-right">
                            Supplier Total Deposit: <strong>{{$supplierPaymentDetails['total_deposit']}}</strong>
                            <br><br>
                            Supplier Invoice Total: <strong>{{$supplierPaymentDetails['invoice_total']}}</strong>
                            <br><br>
                            Supplier Total Balance: <strong>{{$supplierPaymentDetails['total_balance']}}</strong>
                            <br><br>
                            Supplier Total Credit: <strong>{{$supplierPaymentDetails['total_credit']}}</strong>
                        </h4>
                    </td>
                </tr>

                <tr>
                    <td style="float: left;margin-top: 25px;">
                        <h1 class="text-right">Income vs Expense</h1>
                        <h4 class="text-right">
                            Invoice Profit: <strong>{{$incomeVsExpense['invoice_profit']}}</strong>
                            <br><br>
                            Total Expenses: <strong>{{$incomeVsExpense['total_expense']}}</strong>
                            <br><br>
                            =======================================
                            <br>
                            <h4 class="text-right">
                                Total Profit: <strong>{{$incomeVsExpense['total_profit']}}</strong>
                                <br>
                                ===============================
                            </h4>
                        </h4>
                    </td>
                    <td style="float: right">
                        <h1 class="text-right">Cash Balance</h1>
                        <h4 class="text-right">
                            Cash at Bank: <strong>{{$cashBalance['cash_at_bank']}}</strong>
                            <br><br>
                            Drawer Cash Balance: <strong>{{$cashBalance['draw_cash']}}</strong>
                            <br><br>
                            Supplier Total Balance: <strong>{{$cashBalance['supplier_total']}}</strong>
                            <br><br>
                            Customer Due: <strong>{{$cashBalance['customer_due']}}</strong>
                            <br><br>
                            =================
                            <br><br>
                            Total:
                            <strong>{{$cashBalance['total']}}</strong>
                        </h4>
                    </td>
                </tr>

                <tr>
                    <td style="float: left">
                        <h1>Cash at bank</h1>
                        <style>
                            table td {
                                font-size: 14px;
                            }
                        </style>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-uppercase">Bank</th>
                                    <th class="text-uppercase">In</th>
                                    <th class="text-uppercase">Out</th>
                                    <th class="text-uppercase text-right">Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($banks as $bank)
                                    @php
                                        $totalInAmount+= $bank->in_amount;
                                        $totalOutAmount+= $bank->out_amount;
                                        $totalBalance+= $bank->balance;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $bank->name }}</td>
                                        <td>{{ number_format($bank->in_amount) }}</td>
                                        <td>{{ number_format($bank->out_amount) }}</td>
                                        <td class="text-right">{{ $bank->balance }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Banks Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$totalInAmount}}</strong></td>
                                    <td><strong>{{$totalOutAmount}}</strong></td>
                                    <td class="text-right"><strong>{{$totalBalance}}</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </td>
                    <td style="float: right">
                        <h1>Customer Advance Details</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-uppercase">Name</th>
                                    <th class="text-uppercase">In</th>
                                    <th class="text-uppercase">Refund</th>
                                    <th class="text-uppercase text-right">Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $customerAdvanceTotalInAmount = 0;
                                    $customerAdvanceTotalOutAmount = 0;
                                    $customerAdvanceTotalBalance = 0;
                                @endphp
                                @forelse($customerAdvanceTypes as $customerAdvanceType)
                                    @php
                                        $customerAdvanceTotalInAmount+= $customerAdvanceType->in_amount;
                                        $customerAdvanceTotalOutAmount+= $customerAdvanceType->refund_amount;
                                        $customerAdvanceTotalBalance+= $customerAdvanceType->balance;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $customerAdvanceType->name }}</td>
                                        <td>{{ number_format($customerAdvanceType->in_amount) }}</td>
                                        <td>{{ number_format($customerAdvanceType->refund_amount) }}</td>
                                        <td class="text-right">{{ $customerAdvanceType->balance }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Data Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$customerAdvanceTotalInAmount}}</strong></td>
                                    <td><strong>{{$customerAdvanceTotalOutAmount}}</strong></td>
                                    <td class="text-right"><strong>{{$customerAdvanceTotalBalance}}</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="float: left;margin-top: 12px;">
                        <h1>Drawer Cash</h1>
                        <h4 class="text-right">
                            Cash in Total: <strong>{{$drawerCash['in_amount']}}</strong>
                            <br>
                            Cash out Total: <strong>{{$drawerCash['out_amount']}}</strong>
                            <br>
                            Balance: <strong>{{$drawerCash['balance']}}</strong>
                        </h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
