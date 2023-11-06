<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\MasterSetting;
use App\Models\Invoice;
use Livewire\Component;

class PrintInvoices extends Component
{
    public $printer,$invoice,$store_name,$store_email,$store_phone,$address,$lang,$percentage,$no;
    /* render the page */
    public function render()
    {
        $printer =$this->printer;
        return view('livewire.admin.invoices.print-invoices')->layout('layouts.print_layout',['printer' => $printer]);
    }
    /* process before render */
    public function mount($invoice,$printer,$per,$no)
    {
        $this->printer = $printer;
        $this->percentage = $per;
        $this->no = $no;
        $this->invoice =Invoice::find($invoice);
        //dd($this->invoice);
        if(!$this->invoice)
        {
            abort(404);
        }

        $settings = new MasterSetting();
        $site = $settings->siteData();
        $this->store_name = $site['store_name'] ?? 'B2B';
        $this->store_email = $site['store_email'] ?? 'b2b@store.com';
        $this->store_phone = $site['store_phone'] ?? '123456';
        $this->address = $site['address'] ?? '-';
        $this->lang = getTranslation();
    } 
}
