@extends('layouts.app')
@section('title', "Expense")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">Expense</h3>
        </div>
    </div>
    <div class="row">
        @push('css')
            <style>
                th {
                    font-size: 11px;
                }

                td {
                    font-size: 11px;
                }
            </style>
        @endpush
        <div class="col-xl-12">
            <!-- Card -->
            <div class="dt-card dt-card__full-height">
                <div>
                   @if(!$expenseView)
                      <form action="{{$expenseEdit ? route('expenses.update', $expenseEdit->id) : route('expenses.store')}}" method="post">
                            @csrf
                            @if($expenseEdit)
                                @method('put')
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5>
                                            Chart of Account:
                                            <select name="chart_of_account_id" id="chart_of_account_id" class="form-control">
                                                <option value="">--Select Chart of Account--</option>
                                                @foreach($chartOfAccounts as $chartOfAccount)
                                                    <option value="{{$chartOfAccount->id}}" @if(@$expenseEdit->chart_of_account_id == $chartOfAccount->id) selected @endif >{{$chartOfAccount->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>
                                            Agent:
                                            <select name="agent_id" id="agent_id" class="form-control">
                                                <option value="">--Select Agent--</option>
                                                @foreach($agents as $agent)
                                                    <option value="{{$agent->id}}" @if(@$expenseEdit->agent_id == $agent->id) selected @endif >{{$agent->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>
                                            Supplier:
                                            <select name="supplier_id" id="supplier_id" class="form-control">
                                                <option value="">--Select Supplier--</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" @if(@$expenseEdit->supplier_id == $supplier->id) selected @endif >{{$supplier->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>
                                            Trx Date:
                                            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{@$expenseEdit->transaction_date}}">
                                        </h5>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Rate</th>
                                            <th>Quantity</th>
                                            <th>Tax %</th>
                                            <th>Total Tax</th>
                                            <th>Total</th>
                                            <th>Remarks</th>
                                            <th>#</th>
                                        </tr>
                                        </thead>
                                        <tbody id="expenseTableBody">
                                        @if($expenseEdit)
                                            @foreach($expenseEdit->details as $detail)
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="descriptions[]" value="{{$detail->description}}">
                                                    </td>
                                                    <td width="120px;">
                                                        <input type="number" step="any" class="form-control rates" name="rates[]" id="rates" value="{{$detail->rate}}">
                                                    </td>
                                                    <td width="120px;">
                                                        <input type="number" step="any" class="form-control quantities" name="quantities[]" id="quantities" value="{{$detail->quantity}}">
                                                    </td>
                                                    <td style="width: 70px;">
                                                        <input type="number" step="any" class="form-control taxes" name="taxes[]" id="taxes" value="{{@$detail->tax_percentage}}">
                                                    </td>
                                                    <td width="100px;">
                                                        <input type="text" readonly class="form-control total_tax_amount" name="total_tax_amount[]" id="total_tax_amount" value="{{$detail->total_tax_amount}}">
                                                    </td>
                                                    <td width="120px;">
                                                        <input type="text" readonly class="form-control amount" name="total[]" id="total" value="{{$detail->total_amount}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="remarks[]" value="{{$detail->remarks}}">
                                                    </td>
                                                    <td width="40px;">
                                                        <a class="btn btn-sm btn-danger text-white remove-row">
                                                            <i class="icon icon-close font-weight-bold" style="font-size: 20px"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="descriptions[]">
                                                </td>
                                                <td width="120px;">
                                                    <input type="number" step="any" class="form-control rates" name="rates[]" id="rates">
                                                </td>
                                                <td width="120px;">
                                                    <input type="number" step="any" class="form-control quantities" name="quantities[]" id="quantities" >
                                                </td>
                                                <td style="width: 100px;">
                                                    <input type="number" step="any" class="form-control taxes" name="taxes[]" id="taxes">
                                                </td>
                                                <td width="100px;">
                                                    <input type="text" readonly class="form-control total_tax_amount" name="total_tax_amount[]" id="total_tax_amount">
                                                </td>
                                                <td width="120px;">
                                                    <input type="text" readonly class="form-control amount" name="total[]" id="total" >
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="remarks[]">
                                                </td>
                                                <td width="40px;">
                                                    <a class="btn btn-sm btn-danger text-white remove-row">
                                                        <i class="icon icon-close font-weight-bold" style="font-size: 20px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                        <thead>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td>
                                                <span id="totalQuantity" class="font-weight-bold">{{@$expenseEdit->total_quantity}}</span>
                                            </td>
                                            <td>
                                                <span id="totalTaxPercentage" class="font-weight-bold">{{@$expenseEdit->total_tax_percentage}}</span>
                                            </td>
                                            <td>
                                                <span id="totalTaxAmount" class="font-weight-bold">{{@$expenseEdit->total_tax_amount}}</span>
                                            </td>
                                            <td>
                                                <span id="totalAmount" class="font-weight-bold">{{@$expenseEdit->total_amount}}</span>
                                            </td>
                                            <td></td>
                                            <td>
                                                <a class="btn btn-sm btn-success text-white float-right add-row" style="font-size: 16px">
                                                    <i class="icon icon-add"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                @if(@$expenseEdit)
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{route('expenses.index')}}" class="btn btn-secondary">Clear Update</a>
                                @else
                                    <button type="submit" class="btn btn-primary">Save</button>
                                @endif
                            </div>
                        </form>
                   @endif
                   @if($expenseView)
                      <div class="card-body">
                           <div class="row">
                               <div class="col-md-4">
                                   <h5>
                                       Chart of Account: <strong>{{$expenseView->chart_of_account?->name}}</strong>
                                   </h5>
                               </div>
                               <div class="col-md-4">
                                   <h5>
                                       Agent: <strong>{{$expenseView->agent?->name}}</strong>
                                   </h5>
                               </div>
                               <div class="col-md-4">
                                   <h5>
                                       Supplier: <strong>{{$expenseView->supplier?->name}}</strong>
                                   </h5>
                               </div>
                           </div>
                           <div class="table-responsive">
                               <table class="table table-bordered">
                                   <thead>
                                   <tr>
                                       <th>Description</th>
                                       <th>Rate</th>
                                       <th>Quantity</th>
                                       <th>Tax %</th>
                                       <th>Total Tax</th>
                                       <th>Total</th>
                                       <th>Remarks</th>
                                   </tr>
                                   </thead>
                                   <tbody id="expenseTableBody">
                                   @foreach($expenseView->details as $detail)
                                       <tr>
                                           <td>{{$detail->description}}</td>
                                           <td width="120px;">{{$detail->rate}}</td>
                                           <td width="120px;">{{$detail->quantity}}</td>
                                           <td style="width: 70px;">{{@$detail->tax_percentage}}</td>
                                           <td width="100px;">{{$detail->total_tax_amount}}</td>
                                           <td width="120px;">{{$detail->total_amount}}</td>
                                           <td>{{$detail->remarks}}</td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                                   <thead>
                                   <tr>
                                       <td colspan="2"></td>
                                       <td>
                                           <span id="totalQuantity" class="font-weight-bold">{{@$expenseView->total_quantity}}</span>
                                       </td>
                                       <td>
                                           <span id="totalTaxPercentage" class="font-weight-bold">{{@$expenseView->total_tax_percentage}}</span>
                                       </td>
                                       <td>
                                           <span id="totalTaxAmount" class="font-weight-bold">{{@$expenseView->total_tax_amount}}</span>
                                       </td>
                                       <td>
                                           <span id="totalAmount" class="font-weight-bold">{{@$expenseView->total_amount}}</span>
                                       </td>
                                       <td></td>
                                   </tr>
                                   </thead>
                               </table>
                           </div>
                          <div class="col-md-4">
                              <div class="btn-group">
                                  <a href="/expenses?editId={{$expenseView->id}}" class="btn btn-success btn-sm">
                                      Edit
                                  </a>
                                  <a href="{{route('expenses.print', $expenseView->id)}}" target="_blank" class="btn btn-secondary btn-sm">
                                      Print
                                  </a>
                              </div>
                          </div>
                      </div>
                   @endif
                   @if(!$expenseView)
                       <br>
                       <h2 class="pl-4">Expenses</h2>
                       <div class="table-responsive p-4">
                           <table class="table table-bordered">
                               <thead>
                               <tr>
                                   <th>ID</th>
                                   <th>Chart of Account</th>
                                   <th>Agent</th>
                                   <th>Supplier</th>
                                   <th>Trx Date</th>
                                   <th>Total Rate</th>
                                   <th>Total Quantity</th>
                                   <th>Total Tax</th>
                                   <th>Total Amount</th>
                                   <th>Action</th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($expenses as $index => $expense)
                                   <tr>
                                       <td>{{ $expense->id }}</td>
                                       <td>{{ $expense->chart_of_account?->name }}</td>
                                       <td>{{ $expense->agent?->name }}</td>
                                       <td>{{ $expense->supplier?->name }}</td>
                                       <td>{{ $expense->transaction_date }}</td>
                                       <td>{{ $expense->total_rate }}</td>
                                       <td>{{ $expense->total_quantity }}</td>
                                       <td>{{ $expense->total_tax_amount }}</td>
                                       <td>{{ $expense->total_amount }}</td>
                                       <td>
                                           <div class="btn-group">
                                               <a href="/expenses?editId={{$expense->id}}" class="btn btn-success btn-sm">
                                                   Edit
                                               </a>
                                               <a href="/expenses?viewId={{$expense->id}}" class="btn btn-primary btn-sm">
                                                   View
                                               </a>
                                               <a href="{{route('expenses.print', $expense->id)}}" target="_blank" class="btn btn-secondary btn-sm">
                                                   Print
                                               </a>
                                           </div>
                                       </td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                           {{ $expenses->links() }}
                       </div>
                   @endif
                </div>
            </div>
            <!-- /card -->
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            // Add Row
            $(".add-row").click(function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="descriptions[]"></td>';
                cols += '<td><input type="number" step="any" class="form-control rates" name="rates[]"></td>';
                cols += '<td><input type="number" step="any" class="form-control quantities" name="quantities[]"></td>';
                cols += '<td><input type="number" step="any" class="form-control taxes" name="taxes[]"></td>';
                cols += '<td><input type="text" readonly class="form-control total_tax_amount" name="total_tax_amount[]"></td>';
                cols += '<td><input type="text" readonly class="form-control amount" name="total[]"></td>';
                cols += '<td><input type="text" class="form-control" name="remarks[]"></td>';
                cols += '<td><a class="btn btn-sm btn-danger text-white remove-row"><i class="icon icon-close font-weight-bold" style="font-size: 20px"></i></a></td>';

                newRow.append(cols);
                $("#expenseTableBody").append(newRow);
            });

            // Remove Row
            $("#expenseTableBody").on("click", ".remove-row", function () {
                if ($("#expenseTableBody tr").length > 1) {
                    $(this).closest("tr").remove();
                    updateTotalAmount();
                }
            });

            // Update Total Amount
            function updateTotalAmount() {
                var totalAmount = 0;
                $(".amount").each(function () {
                    var amount = parseFloat($(this).val()) || 0;
                    totalAmount += amount;
                });
                $("#totalAmount").text(totalAmount.toFixed(2));

                var totalQuantity = 0;
                var totalTaxPercentage = 0;
                var totalTaxAmount = 0;

                $(".quantities").each(function () {
                    const quantity = parseFloat($(this).val()) || 0;
                    totalQuantity += quantity;
                });
                $("#totalQuantity").text(totalQuantity);

                $(".taxes").each(function () {
                    const tax = parseFloat($(this).val()) || 0;
                    totalTaxPercentage += tax;
                });
                $("#totalTaxPercentage").text(totalTaxPercentage.toFixed(2));

                $(".total_tax_amount").each(function () {
                    const tax = parseFloat($(this).val()) || 0;
                    totalTaxAmount += tax;
                });
                $("#totalTaxAmount").text(totalTaxAmount.toFixed(2));
            }

            // Calculate Total on Rate or Quantity Change
            $("#expenseTableBody").on("input", ".rates, .quantities, .taxes", function () {
                var row = $(this).closest("tr");
                var rate = parseFloat(row.find(".rates").val()) || 0;
                var quantity = parseFloat(row.find(".quantities").val()) || 0;
                var tax = parseFloat(row.find(".taxes").val()) || 0;
                var total = rate * quantity;
                var totalTaxAmount = total/100*tax;
                const amountTotal = total+totalTaxAmount;
                row.find(".amount").val(amountTotal.toFixed(2));
                row.find(".total_tax_amount").val(totalTaxAmount.toFixed(2));

                updateTotalAmount();
            });
        });
    </script>
@endpush
@endsection
