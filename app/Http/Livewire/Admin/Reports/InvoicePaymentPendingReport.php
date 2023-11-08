<?php

namespace App\Http\Livewire\Admin\Reports;

use Livewire\Component;

use App\Models\Invoice;


class InvoicePaymentPendingReport extends Component
{
    public $invoicePaymentPendingReport;

    public function render()
    {
        $this->invoicePaymentPendingReport = Invoice::all();
        return view('livewire.admin.reports.invoice-payment-pending-report');
    }
}
