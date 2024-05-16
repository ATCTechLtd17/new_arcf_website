<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceComponent extends Component
{
    use WithPagination;

    public $service_id, $name;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string',
    ];

    public function render()
    {
        $services = Service::query()
            ->where('type', authUserServiceType())
            ->paginate(20);

        return view('livewire.service-component', compact('services'));
    }

    public function addService(): void
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-service-modal']);
    }

    public function submit(): void
    {
        $this->validate();
        Service::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-service-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Service Added Successfully']);
    }

    public function editService($id): void
    {
        $service = Service::find($id);
        if (!blank($service)) {
            $this->service_id = $id;
            $this->name = $service->name;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-service-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Service::find($this->service_id)->update([
            'name' => $this->name,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-service-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Service Update Successfully']);
    }

    public function deleteService($id): void
    {
        $this->service_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-service-modal']);
    }

    public function deleteConfirm(): void
    {
        Service::find($this->service_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-service-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Service Deleted Successfully']);
    }
}
