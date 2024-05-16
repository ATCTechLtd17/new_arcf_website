<div>
    @include('components.loading-indecator')
    <!-- Card -->
    <div class="card overflow-hidden">

        <!-- Card Header -->
        <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Banks</h3>
                <button class="btn btn-sm btn-primary text-white" wire:click.prevent="add">Add Bank</button>
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
                        <th class="text-uppercase">Name</th>
                        <th class="text-uppercase">Account No</th>
                        <th class="text-uppercase">Address</th>
                        <th class="text-uppercase">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($banks as $bank)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $bank->name }}</td>
                            <td>{{ $bank->account_no }}</td>
                            <td>{{ $bank->address }}</td>
                            <td>
                                <button type="button" wire:click="edit({{ $bank->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
                                {{--                                <button type="button" wire:click="deleteAgent({{ $agent->id }})"--}}
                                {{--                                        class="btn btn-sm btn-danger">Delete--}}
                                {{--                                </button>--}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Bank Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $banks->links() }}
                </div>
            </div>
            <!-- /tables -->

        </div>
        <!-- /card body -->
    </div>
    <!-- /card -->

    {{-- Create Modal --}}
    <div wire:ignore.self class="modal fade" id="add-modal" role="dialog" aria-labelledby="model-8"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="model-8">Add Bank</h3>
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
                            <label for="account_no" class="col-form-label">Account No <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="account_no" wire:model.defer="account_no" type="text" placeholder="Enter Account NO Here">
                            @error('account_no')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <textarea wire:model.defer="address" id="address" cols="30" rows="3" class="form-control" placeholder="Enter Address Here"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Add Bank</button>
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
                    <h3 class="modal-title" id="model-8">Update Bank</h3>
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
                            <label for="account_no" class="col-form-label">Account No <sup class="text-danger">*</sup></label>
                            <input class="form-control" id="account_no" wire:model.defer="account_no" type="text" placeholder="Enter Account No Here">
                            @error('account_no')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <textarea wire:model.defer="address" id="address" cols="30" rows="3" class="form-control" placeholder="Enter Address Here"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Update Bank</button>
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
