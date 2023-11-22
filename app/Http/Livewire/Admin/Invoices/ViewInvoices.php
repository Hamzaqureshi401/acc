<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\Addon;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewInvoices extends Component
{
    public $invoices,$lang,$available,$quantity,$product,$amount,$paid_amount,$pay,$no,$invoice_id, $p_date, $current_date;
    /* render the page */
    public function render()
    {
        $this->invoices = Invoice::latest()->get();
        return view('livewire.admin.invoices.view-invoices');
    }
    /* process before render */
    public function mount()
    {
        $this->p_date = date('Y-m-d');
        $this->lang = getTranslation();
        if(!Auth::user()->can('invoice_list'))
        {
            abort(404);
        }
        $this->pay = 'unpaid';
        $this->current_date = now()->format('Y-m-d');
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
        $this->pay = 'unpaid';
        $this->current_date = now()->format('Y-m-d');
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
        if ($this->pay == 'paid') {
        if($this->no==2){
            $invoice = Invoice::where('id',$this->invoice_id)->first();
            $rem=$invoice->second_invoice_amount-$invoice->second_invoice_paid;
            if($this->pay > $rem){
                $this->pay = $rem;
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'error',  'message' => 'Payment Amount can not be greater than remaining amount!']);
                return;
            }
            // $invoice->second_invoice_paid=$invoice->second_invoice_paid+$this->pay;
             $invoice->second_invoice_paid=$invoice->second_invoice_amount;
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
            $invoice->pay_date = $this->current_date;
            // $invoice->first_invoice_paid=$invoice->first_invoice_paid+$this->pay;
            $invoice->first_invoice_paid=$invoice->first_invoice_amount;
            $invoice->save();
        }
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Payment has been saved!']);
        }else{
            $this->emit('closemodal');
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Payment has not saved!']);
        }

    }
     public function approve($id){
        // dd($id);
        $invoice = Invoice::where('id' , $id)->first();
        $this->deductStock($invoice);
        $invoice->is_approved = 1;
        $invoice->approve_date = date('Y-m-d');
        $invoice->save();
    }

    public function deductStock($invoice){

        foreach($invoice->details as $pr){
            $product=Product::where('id', $pr->product_id)->first();
            $product->quantity= $product->quantity - $pr->quantity;
            $product->save();
        }
    }
}