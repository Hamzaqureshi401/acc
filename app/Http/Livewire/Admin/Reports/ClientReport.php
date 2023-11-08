<?php

namespace App\Http\Livewire\Admin\Reports;

use Livewire\Component;
use App\Models\Customer;

class ClientReport extends Component
{
    public $clients;

    public function render()
    {
        $this->clients = Customer::all(); // Replace with your client query

        return view('livewire.admin.reports.client-report');
    }
}