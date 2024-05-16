@extends('layouts.app')
@section('title', "Supplier Deposits")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Supplier Deposits"}}</h3>
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
        <div class="col-xl-12">
            <!-- Card -->
            <div class="dt-card dt-card__full-height">
                <!-- Card Body -->
                <div class="dt-card__body">
                    <div>
                        <form action="{{$depositEdit ? route('supplier-deposits.update', $depositEdit->id) : route('supplier-deposits.store')}}" method="post">
                            @csrf
                            @if($depositEdit)
                                @method('put')
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5>
                                            Deposit To:
                                            <select name="supplier_id" id="supplier_id" class="form-control">
                                                <option value="">--Select Supplier--</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" @if(@$depositEdit->supplier_id == $supplier->id) selected @endif >{{$supplier->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>
                                            Amount: <input type="number" class="form-control" name="amount" id="amount" value="{{@$depositEdit->amount}}" required placeholder="Amount">
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>
                                            Deposit For:
                                            <select name="service_id" id="service_id" class="form-control" required>
                                                <option value="">--Select Service--</option>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}" @if(@$depositEdit->service_id == $service->id) selected @endif >{{$service->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>
                                            Deposit Method:
                                            <select name="method_id" id="method_id" class="form-control" required>
                                                <option value="">--Select Deposit Method--</option>
                                                @foreach($depositMethods as $depositMethod)
                                                    <option value="{{$depositMethod->id}}" @if(@$depositEdit->method_id == $depositMethod->id) selected @endif >{{$depositMethod->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>
                                            Deposit Source:
                                            <select name="source_id" id="source_id" class="form-control" disabled>
                                                <option value="">--Select Deposit Method--</option>
                                                @foreach($depositSources as $source)
                                                    <option value="{{$source->id}}" @if(@$depositEdit->source_id ?? \App\Models\DepositSource::CASH_IN_HAND == $source->id) selected @endif >{{$source->name}}</option>
                                                @endforeach
                                            </select>
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>
                                            Deposited By: <input type="text" class="form-control" name="deposited_by" id="deposited_by" value="{{@$depositEdit->deposited_by}}" required placeholder="Deposited By">
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>
                                            Deposit Date: <input type="date" class="form-control" name="date" value="{{@$depositEdit->date ?? now()->toDateString()}}">
                                        </h5>
                                    </div>

                                    <div class="col-md-8">
                                        <h5>
                                            Remarks: <input type="text" class="form-control" name="remarks" id="remarks" value="{{@$depositEdit->remarks}}" placeholder="Remarks">
                                        </h5>
                                    </div>
                                </div>

                                @if(@$depositEdit)
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{route('supplier-deposits.create')}}" class="btn btn-secondary">Clear Update</a>
                                @else
                                    <button type="submit" class="btn btn-primary">Save</button>
                                @endif
                            </div>
                        </form>
                        <hr>
                        <h2>Supplier Deposits</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Deposit To</th>
                                    <th>Amount</th>
                                    <th>Deposit For</th>
                                    <th>Deposit Method</th>
                                    <th>Deposited by</th>
                                    <th>Deposit Date</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($supplierDeposits as $index => $deposit)
                                    <tr>
                                        <td>{{ $deposit->supplier->name }}</td>
                                        <td>{{ number_format($deposit->amount, 2) }}</td>
                                        <td>{{ @$deposit->service->name }}</td>
                                        <td>{{ @$deposit->method->name }}</td>
                                        <td>{{ $deposit->deposited_by }}</td>
                                        <td>{{ $deposit->date }}</td>
                                        <td>{{ $deposit->remarks }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/supplier-deposits/create?editId={{$deposit->id}}" class="btn btn-success btn-sm">
                                                    Edit
                                                </a>
                                                <a href="{{route('supplier-deposits.print', $deposit->id)}}" target="_blank" class="btn btn-secondary btn-sm">
                                                    Print
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $supplierDeposits->links() !!}
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
