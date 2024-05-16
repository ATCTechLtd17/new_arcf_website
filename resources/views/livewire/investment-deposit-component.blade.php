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
                <h3 class="card-title">Investments</h3>
{{--                <button class="btn btn-sm btn-primary text-white" wire:click.prevent="add">Add Investment</button>--}}
            </div>
        </div>
        <!-- /card header -->

        <!-- Card Body -->
        <div class="card-body pt-0">

            <!-- Tables -->
            <div class="table-responsive">

                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase">Total Investment</th>
                        <th class="text-uppercase">Deposited</th>
                        <th class="text-uppercase">Current Balance</th>
                        <th class="text-uppercase">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">{{ money_format($investments_amount) }}</th>
                        <th scope="row">{{ money_format($supplier_deposits_amount) }}</th>
                        <th scope="row">{{ money_format($supplier_deposits_amount_investment) }}</th>
                        <td>
                            <button type="button" wire:click.prevent="add" class="btn btn-sm btn-warning">Transfer to Supplier Deposit</button>
                        </td>
                    </tr>
                    </tbody>
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
                    <h3 class="modal-title" id="model-8">Investment to Supplier Deposit</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
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
</div>
