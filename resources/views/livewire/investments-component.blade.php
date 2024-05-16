<div>
    @include('components.loading-indecator')
    <!-- Card -->
    <div class="card overflow-hidden">

        <!-- Card Header -->
        <div class="card-header bg-transparent">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Investments</h3>
                <button class="btn btn-sm btn-primary text-white" wire:click.prevent="add">Add Investment</button>
            </div>
        </div>
        <!-- /card header -->

        <div class="col-md-12 mb-3">
            <button class="btn btn-secondary btn-sm float-right" onclick="printDiv('printReport')">Print</button>
        </div>

        <!-- Card Body -->
        <div class="card-body pt-0" id="printReport">
            <div class="d-print-block d-none">
                @component('print-page-header', ['title' => "Investments"])@endcomponent
            </div>
            <!-- Tables -->
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-uppercase">Investor</th>
                        <th class="text-uppercase">Amount</th>
                        <th class="text-uppercase">DateTime</th>
                        <th class="text-uppercase">Remarks</th>
                        <th class="text-uppercase">Created-By</th>
                        <th class="text-uppercase">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($investments as $investment)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $investment->investor->name }}</td>
                            <td>{{ number_format($investment->amount) }}</td>
                            <td>{{ format_datetime($investment->datetime) }}</td>
                            <td>{{ $investment->remarks }}</td>
                            <td>{{ $investment->created_by_user->name }}</td>
                            <td>
                                <button type="button" wire:click="edit({{ $investment->id }})" class="btn btn-sm btn-warning">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Investments Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $investments->links() }}
                </div>
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
                    <h3 class="modal-title" id="model-8">Add Investment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="investor_id" class="col-form-label">Investor <sup class="text-danger">*</sup></label>
                            <select name="investor_id" id="investor_id" id="investor_id" required wire:model="investor_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Investor--</option>
                                @foreach($investors as $investor)
                                    <option value="{{$investor->id}}">{{$investor->name}}</option>
                                @endforeach
                            </select>
                            @error('investor_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
                            <label for="investor_id" class="col-form-label">Investor <sup class="text-danger">*</sup></label>
                            <select name="investor_id" id="investor_id" id="investor_id" required wire:model="investor_id" class="form-control " style="width: 100%!important;">
                                <option value="">--Select Investor--</option>
                                @foreach($investors as $investor)
                                    <option value="{{$investor->id}}">{{$investor->name}}</option>
                                @endforeach
                            </select>
                            @error('investor_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
