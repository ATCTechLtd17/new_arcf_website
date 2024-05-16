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
                <h3 class="card-title">Drawer Cash to Supplier Deposit</h3>
            </div>
        </div>
        <!-- /card header -->

        <div class="col-md-12 mb-3">
            <button class="btn btn-secondary btn-sm float-right" onclick="printDiv('printReport')">Print</button>
        </div>

        <!-- Card Body -->
        <div class="card-body pt-0" id="printReport">
            <div class="d-print-block d-none" style="top: 0; right: 0; left: 0">
                @component('print-page-header', ['title' => "Drawer Cash to Supplier Deposit"])@endcomponent
            </div>
            <!-- Tables -->
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase">Total Cash In Amount</th>
                        <th class="text-uppercase">Total Cash Out Amount</th>
                        <th class="text-uppercase">Current Balance</th>
                        <th class="text-uppercase d-print-none">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">{{ money_format($in_amount) }}</th>
                        <th scope="row">{{ money_format($out_amount) }}</th>
                        <th scope="row">{{ money_format($in_amount-$out_amount) }}</th>
                        <td class="d-print-none">
                            <a  href="{{route('supplier-deposits.create')}}" class="btn btn-sm btn-warning">Transfer to Supplier Deposit</a>
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
                    <h3 class="modal-title" id="model-8">Drawer Cash to Supplier Deposit</h3>
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
