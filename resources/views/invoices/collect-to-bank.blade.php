@extends('layouts.app')
@section('title', "Invoice - Collect to Bank")
@section('content')
<div class="dt-content">
    <div class="dt-entry__header">
        <div class="dt-entry__heading">
            <h3 class="dt-entry__title">{{"Invoice - Collect to Bank"}}</h3>
        </div>
    </div>
    <div class="row">
        @push('css')
            <style>

            </style>
        @endpush
        <div class="col-xl-12">
            <!-- Card -->
            <div class="dt-card dt-card__full-height">
                <!-- Card Body -->
                <div class="dt-card__body">
                    <div class="card-body pt-0">
                        <form action="{{route('invoices.collect-to-bank.store', $invoice->id)}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="bank_id" class="col-form-label">Bank <sup class="text-danger">*</sup></label>
                                    <select name="bank_id" id="bank_id" class="form-control">
                                        <option value="">---Select Bank---</option>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="amount" class="col-form-label">Amount <sup class="text-danger">*</sup></label>
                                    <input class="form-control" id="amount" name="amount" type="number" step="any" placeholder="Enter Amount Here" required>
                                    @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date" class="col-form-label">Date <sup class="text-danger">*</sup></label>
                                    <input class="form-control" id="date" name="date" type="date" required>
                                    @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="remarks" class="col-form-label">Remarks</label>
                                    <textarea id="remarks" name="remarks" cols="30" rows="3" class="form-control" placeholder="Enter Remarks Here"></textarea>
                                    @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Add</button>
                            </div>
                        </form>
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
