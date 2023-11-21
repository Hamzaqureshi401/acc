<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Addon;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewInvoices extends Component
{
    public $invoices,$lang,$available,$quantity,$product,$amount,$paid_amount,$pay,$no,$invoice_id;
    /* render the page */
    public function render()
    {
        $this->invoices = Invoice::latest()->get();
        return view('livewire.admin.invoices.view-invoices');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('invoice_list'))
        {
            abort(404);
        }
    }
    /* delete products with foreign key delete restriction */   
    public function delete(Invoice $invoices)
    {
        $invoices->delete();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Invoice has been deleted!']);
    }

    public function payment(Invoice $invoices,$no){
        $this->resetpayment();
        $this->no=$no;
        $this->invoice_id=$invoices->id;
        if($no==2){
            $this->amount=$invoices->second_invoice_amount;
            $this->paid_amount=$invoices->second_invoice_paid;
        }else{
            $this->amount=$invoices->first_invoice_amount;
            $this->paid_amount=$invoices->first_invoice_paid;
        }
    }

    public function resetpayment(){
        $this->amount='';
        $this->paid_amount='';
        $this->pay='';
        $this->no='';
    }

    public function savepayment(){
        if($this->no==2){
            $invoice = Invoice::where('id',$this->invoice_id)->first();
            $rem=$invoice->second_invoice_amount-$invoice->second_invoice_paid;
            if($this->pay > $rem){
                $this->pay = $rem;
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'error',  'message' => 'Payment Amount can not be greater than remaining amount!']);
                return;
            }
            $invoice->second_invoice_paid=$invoice->second_invoice_paid+$this->pay;
            $invoice->save();
        }else{
            $invoice = Invoice::where('id',$this->invoice_id)->first();
            $rem=$invoice->first_invoice_amount-$invoice->first_invoice_paid;
            if($this->pay > $rem){
                $this->pay = $rem;
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'error',  'message' => 'Payment Amount can not be greater than remaining amount!']);
                return;
            }
            $invoice->first_invoice_paid=$invoice->first_invoice_paid+$this->pay;
            $invoice->save();
        }
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Payment has been saved!']);
    }
}
