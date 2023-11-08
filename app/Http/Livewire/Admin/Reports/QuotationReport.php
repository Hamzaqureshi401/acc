<?php

namespace App\Http\Livewire\Admin\Reports;

use Livewire\Component;
use App\Models\Quotation;


class QuotationReport extends Component
{
    public $quotationReport;

    public function render()
    {
        $this->quotationReport = Quotation::all();
        return view('livewire.admin.reports.quotation-report');
    }
}
