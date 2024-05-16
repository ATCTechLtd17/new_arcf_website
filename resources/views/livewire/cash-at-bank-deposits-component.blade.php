<div>
    <style>
        .form-group {
            margin-bottom: .2rem;
        }
    </style>
    @include('components.loading-indecator')
    <!-- Card -->
    <div class="card overflow-hidden">

        <!-- Card Header -->
        <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Cash at Bank to Supplier</h3>
            </div>
        </div>
        <!-- /card header -->

        <div class="col-md-12 mb-3">
            <button class="btn btn-secondary btn-sm float-right" onclick="printDiv('printReport')">Print</button>
        </div>

        <!-- Card Body -->
        <div class="card-body pt-0" id="printReport">
            <div class="d-print-block d-none" style="top: 0; right: 0; left: 0">
                @component('print-page-header', ['title' => "Cash at Bank to Supplier"])@endcomponent
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
                        <th class="text-uppercase d-print-none">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                     $totalInAmount = 0;
                     $totalOutAmount = 0;
                     $totalBalance = 0;
                    @endphp
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
                            <td>{{ $bank->balance }}</td>
                            <td class="d-print-none">
                                <button type="button" wire:click="add({{ $bank->id }})" class="btn btn-sm btn-warning">Transfer to Supplier</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No Banks Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                     <tr>
                         <td></td>
                         <td><strong>Total</strong></td>
                         <td><strong>{{$totalInAmount}}</strong></td>
                         <td><strong>{{$totalOutAmount}}</strong></td>
                         <td><strong>{{$totalBalance}}</strong></td>
                         <td></td>
                     </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /tables -->
        </div>
        <!-- /card body -->
    </div>
    <!-- /card -->

    {{-- Create Modal --}}
    <div wire:ignore.self class="modal fade" id="add-modal" role="dialog" aria-labelledby="model-8" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Cash at Bank to Supplier Deposit</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_id" class="col-form-label">Source Bank <sup class="text-danger">*</sup></label>
                            <select name="bank_id" id="bank_id" class="form-control" wire:model.defer="bank_id" required>
                                <option value="">--Select Bank--</option>
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier_id" class="col-form-label">Deposit To <sup class="text-danger">*</sup></label>
                            <select name="supplier_id" id="supplier_id" class="form-control" wire:model.defer="supplier_id" required>
                                <option value="">--Select Supplier--</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount <sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control" name="amount" id="amount" wire:model.defer="amount" required placeholder="Amount">
                            @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_id" class="col-form-label">Deposit For <sup class="text-danger">*</sup></label>
                            <select name="service_id" id="service_id" class="form-control" wire:model.defer="service_id" required>
                                <option value="">--Select Service--</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="method_id" class="col-form-label">Deposit Method <sup class="text-danger">*</sup></label>
                            <select name="method_id" id="method_id" class="form-control" wire:model.defer="method_id" required>
                                <option value="">--Select Method--</option>
                                @foreach($depositMethods as $depositMethod)
                                    <option value="{{$depositMethod->id}}">{{$depositMethod->name}}</option>
                                @endforeach
                            </select>
                            @error('method_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deposited_by" class="col-form-label">Deposited By</label>
                            <input type="text" class="form-control" name="deposited_by" id="deposited_by" wire:model.defer="deposited_by" placeholder="Deposited By">
                            @error('deposited_by')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date" class="col-form-label">Deposit Date</label>
                            <input class="form-control" id="date" wire:model.defer="date" type="date" value="{{now()->toDateString()}}">
                            @error('date')
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
                    <h3 class="modal-title" id="model-8">Update Investment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="amount" wire:model.defer="amount" type="number" required placeholder="Enter Amount Here">
                            @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">DateTime <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="phone" wire:model.defer="datetime" type="datetime-local" required placeholder="Enter DateTime Here">
                            @error('datetime')
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
