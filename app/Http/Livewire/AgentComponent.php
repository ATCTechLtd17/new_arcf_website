<?php

namespace App\Http\Livewire;

use App\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;

class AgentComponent extends Component
{
    use WithPagination;

    public $agent_id, $name, $phone, $company_name, $address;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'company_name' => 'nullable|string',
        'address' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.agent-component', [
            'agents' => Agent::where('type', authUserServiceType())->paginate(20),
        ]);
    }

    public function addAgent(): void
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-agent-modal']);
    }

    public function submit(): void
    {
        $this->validate();
        Agent::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-agent-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Agent Added Successfully']);
    }

    public function editAgent($id): void
    {
        $agent = Agent::find($id);
        if (!blank($agent)) {
            $this->agent_id = $id;
            $this->name = $agent->name;
            $this->phone = $agent->phone;
            $this->company_name = $agent->company_name;
            $this->address = $agent->address;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-agent-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Agent::find($this->agent_id)->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-agent-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Agent Update Successfully']);
    }

    public function deleteAgent($id): void
    {
        $this->agent_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-agent-modal']);
    }

    public function deleteConfirm(): void
    {
        Agent::find($this->agent_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-agent-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Agent Deleted Successfully']);
    }
}
