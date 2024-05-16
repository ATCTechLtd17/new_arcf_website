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
                <h3 class="card-title">Customer Advance</h3>
                <div>
                    <button class="btn btn-sm btn-primary text-white" wire:click.prevent="add">Add Advance (Invoice)</button>
                    <button class="btn btn-sm btn-primary text-white" wire:click.prevent="addCustomer">Add Advance (Customer)</button>
                </div>
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
                        <th class="text-uppercase">Advance Type</th>
                        <th class="text-uppercase">Customer</th>
                        <th class="text-uppercase">Invoice</th>
                        <th class="text-uppercase">Description</th>
                        <th class="text-uppercase">In Amount</th>
                        <th class="text-uppercase">Refund Amount</th>
                        <th class="text-uppercase">Balance</th>
                        <th class="text-uppercase">CreatedAt</th>
                        <th class="text-uppercase">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalInAmount = 0;
                        $totalRefundAmount = 0;
                    @endphp
                    @forelse($advances as $advance)
                        @php
                            $totalInAmount+= $advance->in_amount;
                            $totalRefundAmount+= $advance->refund_amount;
                        @endphp
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $advance->type?->name }}</td>
                            <td>{{ $advance->customer?->name }}</td>
                            <td>
                                Invoice No: {{ $advance->invoice?->invoice_no }}  |
                                {{ $advance->invoice?->name }}
                            </td>
                            <td>{{ $advance->remarks }}</td>
                            <td>{{ number_format($advance->in_amount) }}</td>
                            <td>{{ number_format($advance->refund_amount) }}</td>
                            <td>{{ number_format($advance->in_amount-$advance->refund_amount) }}</td>
                            <td>{{ format_datetime($advance->created_at) }}</td>
                            <td>
                                <button type="button" wire:click="edit({{ $advance->id }})" class="btn btn-sm btn-warning">Edit</button>
                                <a href="{{route('customer-advances.print', $advance->id)}}" target="_blank" class="btn btn-sm btn-success">Money Receipt</a>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>{{$totalInAmount}}</strong></td>
                        <td><strong>{{$totalRefundAmount}}</strong></td>
                        <td><strong>{{$totalInAmount-$totalRefundAmount}}</strong></td>
                        <td></td>
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

    {{-- Create Modal - Invoice--}}
    <div wire:ignore.self class="modal fade" id="add-modal" role="dialog" aria-labelledby="model-8" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Customer Advance</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="invoice_id" class="col-form-label">Invoice</label>
                            <select name="invoice_id" id="invoice_id" class="form-control" required wire:model.defer="invoice_id">
                                <option value="">--Select Invoice--</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{$invoice->id}}">{{$invoice->invoice_no}} | {{$invoice->name}} </option>
                                @endforeach
                            </select>
                            @error('invoice_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type_id" class="col-form-label">Advance Type</label>
                            <select name="type_id" id="type_id" class="form-control" required wire:model.defer="type_id">
                                <option value="">--Select Advance Type--</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Description</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" wire:model.defer="remarks" placeholder="Description">
                            @error('remarks')
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
                                    <label for="refund_amount" class="col-form-label">Refund Amount</label>
                                    <input class="form-control" id="refund_amount" wire:model.defer="refund_amount" type="number" placeholder="Enter Refund Amount Here">
                                    @error('refund_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
    {{-- Modal end Invoice--}}

    {{-- Edit Modal Invoice--}}
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
                            <label for="invoice_id" class="col-form-label">Invoice</label>
                            <select name="invoice_id" id="invoice_id" class="form-control" required wire:model.defer="invoice_id">
                                <option value="">--Select Invoice--</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{$invoice->id}}">{{$invoice->name}} | {{$invoice->invoice_no}}</option>
                                @endforeach
                            </select>
                            @error('invoice_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type_id" class="col-form-label">Advance Type</label>
                            <select name="type_id" id="type_id" class="form-control" required wire:model.defer="type_id">
                                <option value="">--Select Advance Type--</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Description</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" wire:model.defer="remarks" placeholder="Description">
                            @error('remarks')
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
                                    <label for="refund_amount" class="col-form-label">Refund Amount</label>
                                    <input class="form-control" id="refund_amount" wire:model.defer="refund_amount" type="number" placeholder="Enter Refund Amount Here">
                                    @error('refund_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
    {{-- Modal end Invoice --}}

    {{-- Create Modal Customer--}}
    <div wire:ignore.self class="modal fade" id="add-customer-modal" role="dialog" aria-labelledby="model-8" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Customer Advance</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submitCustomer">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer_id" class="col-form-label">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control" required wire:model.defer="customer_id">
                                <option value="">--Select Customer--</option>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}} | {{$customer->phone}}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_id" class="col-form-label">Advance Type</label>
                            <select name="type_id" id="type_id" class="form-control" required wire:model.defer="type_id">
                                <option value="">--Select Advance Type--</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Description</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" wire:model.defer="remarks" placeholder="Description">
                            @error('remarks')
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
                                    <label for="refund_amount" class="col-form-label">Refund Amount</label>
                                    <input class="form-control" id="refund_amount" wire:model.defer="refund_amount" type="number" placeholder="Enter Refund Amount Here">
                                    @error('refund_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
    {{-- Modal end Customer--}}

    {{-- Edit Modal Customer--}}
    <div wire:ignore.self class="modal fade" id="update-customer-modal" role="dialog" aria-labelledby="model-8"
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
                <form wire:submit.prevent="updateCustomer">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer_id" class="col-form-label">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control" required wire:model.defer="customer_id">
                                <option value="">--Select Customer--</option>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}} | {{$customer->phone}}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_id" class="col-form-label">Advance Type</label>
                            <select name="type_id" id="type_id" class="form-control" required wire:model.defer="type_id">
                                <option value="">--Select Advance Type--</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-form-label">Description</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" wire:model.defer="remarks" placeholder="Description">
                            @error('remarks')
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
                                    <label for="refund_amount" class="col-form-label">Refund Amount</label>
                                    <input class="form-control" id="refund_amount" wire:model.defer="refund_amount" type="number" placeholder="Enter Refund Amount Here">
                                    @error('refund_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
    {{-- Modal end Customer--}}
</div>
