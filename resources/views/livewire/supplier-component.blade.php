<div>
    @include('components.loading-indecator')
    <!-- Card -->
    <div class="card overflow-hidden">

        <!-- Card Header -->
        <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Suppliers</h3>
                <button class="btn btn-sm btn-primary text-white" wire:click.prevent="addSupplier">Add Supplier</button>
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
                        <th class="text-uppercase">Type</th>
                        <th class="text-uppercase">Name</th>
                        <th class="text-uppercase">Phone</th>
{{--                        <th class="text-uppercase">Company Name</th>--}}
                        <th class="text-uppercase">Address</th>
                        <th class="text-uppercase">Service</th>
                        <th class="text-uppercase">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $supplier->type->getLabel() }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->phone }}</td>
{{--                            <td>{{ $supplier->company_name }}</td>--}}
                            <td>{{ $supplier->address }}</td>
                            <td>{{ @$supplier->service->name }}</td>
                            <td>
                                <button type="button" wire:click="editSupplier({{ $supplier->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
{{--                                <button type="button" wire:click="deleteSupplier({{ $supplier->id }})"--}}
{{--                                        class="btn btn-sm btn-danger">Delete--}}
{{--                                </button>--}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Supplier Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $suppliers->links() }}
                </div>
            </div>
            <!-- /tables -->

        </div>
        <!-- /card body -->
    </div>
    <!-- /card -->

    {{-- Create Modal --}}
    <div wire:ignore.self class="modal fade" id="add-supplier-modal" role="dialog" aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Add Supplier</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="name" wire:model.defer="name" type="text" placeholder="Enter Name Here">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="phone" wire:model.defer="phone" type="text" placeholder="Enter Phone Here">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="company_name" class="col-form-label">Company Name</label>--}}
{{--                            <input class="form-control" id="company_name" wire:model.defer="company_name" type="text" placeholder="Enter Company Name Here">--}}
{{--                            @error('company_name')--}}
{{--                            <span class="text-danger">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <textarea wire:model.defer="address" id="address" cols="30" rows="3" class="form-control" placeholder="Enter Address Here"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="service_id" class="col-form-label">Service <sup class="text-danger">*</sup></label>
                            <select name="service_id" id="service_id" id="service_id" required wire:model="service_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Service--</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal end --}}

    {{-- Edit Modal --}}
    <div wire:ignore.self class="modal fade" id="update-supplier-modal" role="dialog" aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Update Supplier</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="name" wire:model.defer="name" type="text" placeholder="Enter Name Here">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="phone" wire:model.defer="phone" type="text" placeholder="Enter Phone Here">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="company_name" class="col-form-label">Company Name</label>--}}
{{--                            <input class="form-control" id="company_name" wire:model.defer="company_name" type="text" placeholder="Enter Company Name Here">--}}
{{--                            @error('company_name')--}}
{{--                            <span class="text-danger">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <textarea wire:model.defer="address" id="address" cols="30" rows="3" class="form-control" placeholder="Enter Address Here"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="service_id" class="col-form-label">Service <sup class="text-danger">*</sup></label>
                            <select name="service_id" id="service_id" id="service_id" required wire:model="service_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Service--</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}" @if(@$service_id === $service->id) selected @endif >{{$service->name}}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Update Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal end --}}

    {{-- Delete Modal --}}
    <div class="modal fade" id="delete-supplier-modal" tabindex="-1" role="dialog" aria-labelledby="model-3"
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
