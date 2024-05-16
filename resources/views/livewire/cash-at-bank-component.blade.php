<div>
    @include('components.loading-indecator')
    <!-- Card -->
    <div class="card overflow-hidden">

        @php
            $totalInAmount = 0;
            $totalOutAmount = 0;
        @endphp

        <!-- Card Header -->
        <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Cash at Bank</h3>
                <div>
                    <button class="btn btn-sm btn-success text-white" wire:click.prevent="add">Cash In</button>
                    <button class="btn btn-sm btn-warning text-white" wire:click.prevent="addCashOut">Cash Out</button>
                    <button class="btn btn-secondary btn-sm float-right" onclick="printDiv('printReport')">Print</button>
                </div>
            </div>
            <div class="row">
{{--                <div class="col-md-3">--}}
{{--                    <h5>Date:--}}
{{--                        <input type="date" class="form-control" id="date" wire:model="date">--}}
{{--                    </h5>--}}
{{--                </div>--}}
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
                    <h5 style="padding: 0!important;margin-bottom: 0!important;">Select Withdraw Purpose</h5>
                    <select name="withdraw_purpose_id_query" id="withdraw_purpose_id_query" id="withdraw_purpose_id_query" wire:model="withdraw_purpose_id_query" class="form-control " style="width: 100%!important;">
                        <option value="">--Select Withdraw Purpose--</option>
                        @foreach($withdraw_purposes as $withdraw_purpose)
                            <option value="{{$withdraw_purpose->id}}">{{$withdraw_purpose->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- /card header -->

        <!-- Card Body -->
        <div class="card-body pt-0" id="printReport">
            <div class="d-print-block d-none" style="top: 0; right: 0; left: 0">
                @component('print-page-header', ['title' => "Cash at Bank"])@endcomponent
            </div>
            <!-- Tables -->
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-uppercase">Bank</th>
                        <th class="text-uppercase">In Amount</th>
                        <th class="text-uppercase">Out Amount</th>
                        <th class="text-uppercase">Balance</th>
                        <th class="text-uppercase">Deposit Method</th>
                        <th class="text-uppercase">Trx Date</th>
                        <th class="text-uppercase">Voucher No</th>
                        <th class="text-uppercase">Done-By</th>
                        <th class="text-uppercase">DateTime</th>
                        <th class="text-uppercase">Created-By</th>
                        <th class="text-uppercase d-print-none">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cash_at_banks as $cash_at_bank)
                        @php $totalInAmount+=$cash_at_bank->in_amount @endphp
                        @php $totalOutAmount+=$cash_at_bank->out_amount @endphp
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $cash_at_bank->bank->name }}</td>
                            <td>{{ number_format($cash_at_bank->in_amount) }}</td>
                            <td>{{ number_format($cash_at_bank->out_amount) }}</td>
                            <td>{{ $cash_at_bank->in_amount-$cash_at_bank->out_amount }}</td>
                            <td>{{ $cash_at_bank->deposit_method?->name }}</td>
                            <td>{{ $cash_at_bank->date }}</td>
                            <td>{{ $cash_at_bank->voucher_no }}</td>
                            <td>{{ $cash_at_bank->transaction_done_by }}</td>
                            <td>{{ format_datetime($cash_at_bank->created_at) }}</td>
                            <td>{{ $cash_at_bank->created_by_user->name }}</td>
                            <td class="d-print-none">
                                <button type="button" wire:click="edit({{ $cash_at_bank->id }})" class="btn btn-sm btn-warning">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No Cash at Banks Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{number_format($totalInAmount)}}</td>
                        <td>{{number_format($totalOutAmount)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $cash_at_banks->links() }}
                </div>
            </div>
            <!-- /tables -->

        </div>
        <!-- /card body -->
    </div>
    <!-- /card -->

    <style>
        .modal .form-group{
            margin-bottom: 0.2rem!important;
        }
    </style>
    {{-- Create Modal --}}
    <div wire:ignore.self class="modal fade" id="add-modal" role="dialog" aria-labelledby="model-8" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Add Cash at Bank</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_id" class="col-form-label">Bank <sup class="text-danger">*</sup></label>
                            <select name="bank_id" id="bank_id" id="bank_id" required wire:model="bank_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Bank--</option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="in_amount" class="col-form-label">Cash In Amount</label>
                                    <input class="form-control" id="in_amount" wire:model.defer="in_amount" type="number" placeholder="Enter Cash in Amount Here">
                                    @error('in_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deposit_method_id" class="col-form-label">Deposit Method <sup class="text-danger">*</sup></label>
                            <select name="deposit_method_id" id="deposit_method_id" id="deposit_method_id" required wire:model="deposit_method_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Deposit Method--</option>
                                @foreach($deposit_methods as $method)
                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                @endforeach
                            </select>
                            @error('deposit_method_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-form-label">Transaction Date <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="date" wire:model.defer="date" type="date" required placeholder="Enter Date Here">
                            @error('date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="voucher_no" class="col-form-label">Voucher No</label>
                            <input class="form-control" id="voucher_no" wire:model.defer="voucher_no" type="text" placeholder="Enter Voucher No Here">
                            @error('voucher_no')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="transaction_done_by" class="col-form-label">Transaction Done-By</label>
                            <input class="form-control" id="transaction_done_by" wire:model.defer="transaction_done_by" type="text" placeholder="Enter Transaction Done-By Here">
                            @error('transaction_done_by')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <textarea wire:model.defer="remarks" id="remarks" cols="30" rows="2" class="form-control" placeholder="Enter Remarks Here"></textarea>
                            @error('remarks')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="add-cash-out-modal" role="dialog" aria-labelledby="model-8" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Cash Out</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_id" class="col-form-label">Bank <sup class="text-danger">*</sup></label>
                            <select name="bank_id" id="bank_id" id="bank_id" required wire:model="bank_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Bank--</option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}  - Balance: {{number_format($bank->balance, 2)}}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="withdraw_purpose_id" class="col-form-label">Withdraw Purpose <sup class="text-danger">*</sup></label>
                            <select name="withdraw_purpose_id" id="withdraw_purpose_id" id="withdraw_purpose_id" required wire:model="withdraw_purpose_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Withdraw Purpose--</option>
                                @foreach($withdraw_purposes as $withdraw_purpose)
                                    <option value="{{$withdraw_purpose->id}}">{{$withdraw_purpose->name}}</option>
                                @endforeach
                            </select>
                            @error('withdraw_purpose_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="out_amount" class="col-form-label">Cash Out Amount</label>
                            <input class="form-control" id="out_amount" wire:model.defer="out_amount" type="number" placeholder="Enter Cash Out Amount Here">
                            @error('out_amount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-form-label">Transaction Date <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="date" wire:model.defer="date" type="date" required placeholder="Enter Date Here">
                            @error('date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="voucher_no" class="col-form-label">Voucher No</label>
                            <input class="form-control" id="voucher_no" wire:model.defer="voucher_no" type="text" placeholder="Enter Voucher No Here">
                            @error('voucher_no')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="transaction_done_by" class="col-form-label">Transaction Done-By</label>
                            <input class="form-control" id="transaction_done_by" wire:model.defer="transaction_done_by" type="text" placeholder="Enter Transaction Done-By Here">
                            @error('transaction_done_by')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <textarea wire:model.defer="remarks" id="remarks" cols="30" rows="2" class="form-control" placeholder="Enter Remarks Here"></textarea>
                            @error('remarks')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal end --}}

    {{-- Edit Modal --}}
    <div wire:ignore.self class="modal fade" id="update-modal" role="dialog" aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Update</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_id" class="col-form-label">Bank <sup class="text-danger">*</sup></label>
                            <select name="bank_id" id="bank_id" id="bank_id" required wire:model="bank_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Bank--</option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="in_amount" class="col-form-label">Cash In Amount</label>
                                    <input class="form-control" id="in_amount" wire:model.defer="in_amount" type="number" placeholder="Enter Cash in Amount Here">
                                    @error('in_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="out_amount" class="col-form-label">Cash Out Amount</label>
                                    <input class="form-control" id="out_amount" wire:model.defer="out_amount" type="number" placeholder="Enter Cash Out Amount Here">
                                    @error('out_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deposit_method_id" class="col-form-label">Deposit Method <sup class="text-danger">*</sup></label>
                            <select name="deposit_method_id" id="deposit_method_id" id="deposit_method_id" required wire:model="deposit_method_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Deposit Method--</option>
                                @foreach($deposit_methods as $method)
                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                @endforeach
                            </select>
                            @error('deposit_method_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-form-label">Transaction Date <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="date" wire:model.defer="date" type="date" required placeholder="Enter Date Here">
                            @error('date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="voucher_no" class="col-form-label">Voucher No</label>
                            <input class="form-control" id="voucher_no" wire:model.defer="voucher_no" type="text" placeholder="Enter Voucher No Here">
                            @error('voucher_no')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="transaction_done_by" class="col-form-label">Transaction Done-By</label>
                            <input class="form-control" id="transaction_done_by" wire:model.defer="transaction_done_by" type="text" placeholder="Enter Transaction Done-By Here">
                            @error('transaction_done_by')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <textarea wire:model.defer="remarks" id="remarks" cols="30" rows="2" class="form-control" placeholder="Enter Remarks Here"></textarea>
                            @error('remarks')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal end --}}

    {{-- Delete Modal --}}
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="model-3"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <!-- Modal Content -->
            <div class="modal-content">

                <!-- Modal Body -->
                <div class="modal-body p-0">
                    <div class="swal2-popup swal2-modal swal2-show" style="display: flex;">
                        <div class="swal2-header">
                            <div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;">
                                <span class="swal2-icon-text">!</span>
                            </div>

                            <h2 class="swal2-title" id="swal2-title" style="display: flex;">Are you sure?</h2><button
                                type="button" class="swal2-close" style="display: none;">×</button>
                        </div>
                        {{-- <div class="swal2-content">
                            <div id="swal2-content" style="display: block;">You won't be able to revert this!</div>
                        </div> --}}
                        <div class="swal2-actions" style="display: flex;"><button data-dismiss="modal"
                                                                                  aria-label="Close" type="button" class="swal2-cancel btn btn-danger mr-2 mb-2"
                                                                                  aria-label="" style="display: inline-block;">No, cancel!</button><button
                                type="button" wire:click="deleteConfirm" data-dismiss="modal" aria-label="Close"
                                class="swal2-confirm btn btn-success mb-2" aria-label="">Yes, delete
                                it!</button>
                        </div>
                    </div>
                </div>
                <!-- /modal body -->

            </div>
            <!-- /modal content -->

        </div>
    </div>
    {{-- Delete Modal --}}

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
