<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\CustomerAdvance;
use App\Models\CustomerAdvanceType;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAdvanceDetailsComponent extends Component
{
    use WithPagination;

    public $advance_id, $type_id, $customer_id, $in_amount, $refund_amount, $remarks;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $types = CustomerAdvanceType::all();
        $customers = Customer::where('type', authUser()->service_type)->get();

        $advances = CustomerAdvance::query()
            ->where('service_type', authUserServiceType());

        $customerId = $this->customer_id;

        if ($customerId) {
            $advances->where('customer_id', $customerId);
        }

        return view('livewire.customer-advance-details-component', [
            'types' => $types,
            'customers' => $customers,
            'advances' => $advances
                ->latest()
                ->get(),
        ]);
    }

}
