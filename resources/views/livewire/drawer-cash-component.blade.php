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
                <h3 class="card-title">Drawer Cash</h3>
                <button class="btn btn-sm btn-primary text-white" wire:click.prevent="add">Add Drawer Cash</button>
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
                        <th>#</th>
                        <th class="text-uppercase">In Amount</th>
                        <th class="text-uppercase">Out Amount</th>
                        <th class="text-uppercase">Balance</th>
                        <th class="text-uppercase">Deposit Source</th>
                        <th class="text-uppercase">Source Details</th>
                        <th class="text-uppercase">Remarks</th>
                        <th class="text-uppercase">CreatedAt</th>
                        <th class="text-uppercase">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalInAmount = 0;
                        $totalOutAmount = 0;
                        $totalBalance = 0;
                    @endphp
                    @forelse($drawer_cashes as $drawer_cash)
                        @php
                            $totalInAmount+= $drawer_cash->in_amount;
                            $totalOutAmount+= $drawer_cash->out_amount;
                            $totalBalance+= $drawer_cash->balance;
                        @endphp
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ number_format($drawer_cash->in_amount) }}</td>
                            <td>{{ number_format($drawer_cash->out_amount) }}</td>
                            <td>{{ number_format($drawer_cash->balance) }}</td>
                            <td>{{ $drawer_cash->deposit_source?->name }}</td>
                            <td>{{ $drawer_cash->source_details }}</td>
                            <td>{{ $drawer_cash->remarks }}</td>
                            <td>{{ format_datetime($drawer_cash->created_at) }}</td>
                            <td>
                                <button type="button" wire:click="edit({{ $drawer_cash->id }})" class="btn btn-sm btn-warning">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No Data Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{$totalInAmount}}</strong></td>
                        <td><strong>{{$totalOutAmount}}</strong></td>
                        <td><strong>{{$totalBalance}}</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <br>
            {{ $drawer_cashes->links() }}
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
                    <h3 class="modal-title" id="model-8">Drawer Cash</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
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
                            <label for="deposit_source_id" class="col-form-label">Deposit Source</label>
                            <select name="deposit_source_id" id="deposit_source_id" class="form-control" wire:model.defer="deposit_source_id">
                                <option value="">--Select Deposit Source--</option>
                                @foreach($deposit_sources as $deposit_source)
                                    <option value="{{$deposit_source->id}}">{{$deposit_source->name}}</option>
                                @endforeach
                            </select>
                            @error('deposit_source_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="source_details" class="col-form-label">Source Details</label>
                            <input type="text" class="form-control" name="source_details" id="source_details" wire:model.defer="source_details" placeholder="Source Details">
                            @error('source_details')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" wire:model.defer="remarks" placeholder="Remarks">
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
                    <h3 class="modal-title" id="model-8">Update Investment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="update">
                    <div class="modal-body">
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
                            <label for="deposit_source_id" class="col-form-label">Deposit Source</label>
                            <select name="deposit_source_id" id="deposit_source_id" class="form-control" wire:model.defer="deposit_source_id">
                                <option value="">--Select Deposit Source--</option>
                                @foreach($deposit_sources as $deposit_source)
                                    <option value="{{$deposit_source->id}}">{{$deposit_source->name}}</option>
                                @endforeach
                            </select>
                            @error('deposit_source_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="source_details" class="col-form-label">Source Details</label>
                            <input type="text" class="form-control" name="source_details" id="source_details" wire:model.defer="source_details" placeholder="Source Details">
                            @error('source_details')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="invoice_id" class="col-form-label">Invoice</label>
                            <select name="invoice_id" id="invoice_id" class="form-control" wire:model.defer="invoice_id">
                                <option value="">--Select Invoice--</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{$invoice->id}}">{{$invoice->invoice_no}} | {{$invoice->name}}</option>
                                @endforeach
                            </select>
                            @error('invoice_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" wire:model.defer="remarks" placeholder="Remarks">
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
</div>
