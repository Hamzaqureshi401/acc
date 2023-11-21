<?php

namespace App\Http\Livewire\Admin\Quotations;

use App\Models\Addon;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Lead;

class ViewQuotations extends Component
{
    public $quotations,$lang,$available,$quantity,$product;
    /* render the page */
    public function render()
    {
        $this->quotations = Quotation::latest()->get();
        return view('livewire.admin.quotations.view-quotations');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('quotation_list'))
        {
            abort(404);
        }
    }
    /* delete products with foreign key delete restriction */   
    public function delete(Quotation $qoutation)
    {
        $qoutation->delete();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Quotation has been deleted!']);
    }
     public function makeclient()
    {
        // $customer = new Customer();
        // $lead=Lead::where('id', $appointment->lead_id)->first();
        // $customer->lead_id = $appointment->lead_id;
        // $customer->name = $lead->name;
        // $customer->phone = $lead->phone;
        // $customer->email = $lead->email;
        // $customer->postcode = $lead->postcode;
        // $customer->address = $lead->address;
        // $customer->city = $lead->city;
        // $customer->save();
        // Appointment::where('id', $appointment->id)->update(['customer_status' => 1]);
        // $this->dispatchBrowserEvent(
        //     'alert', ['type' => 'success',  'message' => 'Customer has been Created!']);
    }
}
