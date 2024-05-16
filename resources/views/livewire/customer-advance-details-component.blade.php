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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="customer_id" id="customer_id" class="form-control" wire:model="customer_id">
                            <option value="">--Select Customer--</option>
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}} </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
                        <th class="text-uppercase">In Amount</th>
                        <th class="text-uppercase">Refund Amount</th>
                        <th class="text-uppercase">Balance</th>
                        <th class="text-uppercase">Remarks</th>
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
                            <td>{{ number_format($advance->in_amount) }}</td>
                            <td>{{ number_format($advance->refund_amount) }}</td>
                            <td>{{ number_format($advance->in_amount-$advance->refund_amount) }}</td>
                            <td>{{ $advance->remarks }}</td>
                            <td>{{ format_datetime($advance->created_at) }}</td>
                            <td>
{{--                                <button type="button" wire:click="edit({{ $advance->id }})" class="btn btn-sm btn-warning">Edit</button>--}}
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
                        <td><strong>{{$totalInAmount}}</strong></td>
                        <td><strong>{{$totalRefundAmount}}</strong></td>
                        <td><strong>{{$totalInAmount-$totalRefundAmount}}</strong></td>
                        <td></td>
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
</div>
