@extends('layouts.app')
@section('title', "Supplier Deposits Details")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Supplier Deposits Details"}}</h3>
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
                .table th, .table td{
                    padding: 0.8rem!important;
                }
            </style>
        @endpush
        @php
            $totalAmount = 0;
        @endphp
        <div class="col-xl-12">
            <!-- Card -->
            <div class="dt-card dt-card__full-height">
                <!-- Card Body -->
                <div class="dt-card__body">
                    <div>
                        <div class="card-body">
                            <form action="{{route('supplier-deposits.index')}}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Supplier</h5>
                                        <select name="supplier_id" id="supplier_id" wire:model="supplier_id" class="form-control" style="width: 100%!important;">
                                            <option value="">--Select Supplier--</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{$supplier->id}}" @if($supplier_id == $supplier->id) selected @endif>{{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>From Date:
                                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{$fromDate}}">
                                        </h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>To Date:
                                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{$toDate}}">
                                        </h5>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="btn-group">
                                           <button type="submit" class="btn btn-secondary btn-sm float-right m-2">Search</button>
                                           <a href="{{route('supplier-deposits.index', ['is_print'  => true, 'supplier_id' => $supplier_id, 'from_date' => $fromDate, 'to_date' => $toDate])}}" target="_blank" class="btn btn-secondary btn-sm m-2 text-white">
                                               Print
                                           </a>
                                       </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <h2>Supplier Deposits Details</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Deposit To</th>
                                    <th>Amount</th>
                                    <th>Deposit For</th>
                                    <th>Remarks</th>
                                    <th>Deposit Method</th>
                                    <th>Deposited by</th>
                                    <th>Deposit Date</th>
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
                                        <td>{{ $deposit->remarks }}</td>
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
                        {{ $supplierDeposits->links() }}
                    </div>
                </div>
                <!-- /card body -->
            </div>
            <!-- /card -->
        </div>
    </div>
</div>
@push('js')
    <script>

    </script>
@endpush
@endsection
