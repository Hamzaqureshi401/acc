<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Lead;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class Appointments extends Component
{
    public $appointments,$leads,$description,$appointment,$is_active = true,$lang,$start_time,$end_time,$start_date,$end_date,$lead_id,$lead_name , $custom_note;
    public $phone,$email,$address,$type;
    /* render the page */
    public function render()
    {
         
        $this->appointments = Appointment::latest()->get();
        $this->leads = Lead::latest()->where('appointment_status',0)->get();
        return view('livewire.admin.appointments.appointments');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        $this->start_time = date('Y-m-d');
        
        if(!Auth::user()->can('appointment_list'))
        {
            abort(404);
        }
    }
    /* store customer data */
    public function create()
    {
        $this->validate([
            'lead_id'  => 'required',
            // 'start_time'  => 'required',
            'end_time'  => 'required',
            // 'start_date'  => 'required',
            'quotation_no'  => 'required',
            'type'  => 'required',
        ]);
        $appointment = new Appointment();
        $appointment->lead_id = $this->lead_id;
        $appointment->start_time = $this->start_time;
        $appointment->end_time = $this->end_time;
        $appointment->start_date = $this->start_date ?: now()->toDateString();
        $appointment->quotation_no = $this->quotation_no;
        $appointment->type = $this->type;
        $appointment->custom_note = $this->custom_note;
        
        $appointment->save();
        Lead::where('id', $appointment->lead_id)->update(['appointment_status' => 1]);
        $this->emit('closemodal');
        $this->resetFields();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Appointment has been sechduled!']);
    }

    /* reset customer data */
    public function edit(Appointment $appointment)
    {
        $this->resetFields();
        $this->appointment = $appointment;
        $this->lead_name = $appointment->lead->name;
        $this->start_time = $appointment->start_time;
        $this->end_time = $appointment->end_time;
        $this->start_date = $appointment->start_date ?: now()->toDateString();

        $this->quotation_no = $appointment->quotation_no;
        $this->type = $appointment->type;
        $this->custom_note = $appointment->custom_note;
    }
    /* update customer data */
    public function update()
    {
        $this->validate([
            'start_time'  => 'required',
            'end_time'  => 'required',
            'start_date'  => 'required',
            'quotation_no'  => 'required',
            'type'  => 'required',
        ]);
        $appointment = $this->appointment;
        $appointment->start_time = $this->start_time;
        $appointment->end_time = $this->end_time;
        $appointment->start_date = $this->start_date ?: now()->toDateString();
        $appointment->quotation_no = $this->quotation_no;
        $appointment->type = $this->type;
        $appointment->custom_note = $this->custom_note;
        $appointment->save();
        $this->emit('closemodal');
        $this->resetFields();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Appointment has been updated!']);
    }
    /* delete customer data */
    public function delete(Appointment $appointment)
    {
        $appointment->delete();
        $this->appointment = null;
        Lead::where('id', $appointment->lead_id)->update(['appointment_status' => 0]);
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Appointment has been deleted!']);
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->status=1;
        $appointment->save();
        Lead::where('id', $appointment->lead_id)->update(['appointment_status' => 2]);
        $this->appointment = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Appointment has been canceled!']);
    }

    /* makeclient */
    public function makeclient(Appointment $appointment)
    {
        $customer = new Customer();
        $lead=Lead::where('id', $appointment->lead_id)->first();
        $customer->lead_id = $appointment->lead_id;
        $customer->name = $lead->name;
        $customer->phone = $lead->phone;
        $customer->email = $lead->email;
        $customer->postcode = $lead->postcode;
        $customer->address = $lead->address;
        $customer->city = $lead->city;
        $customer->save();
        Appointment::where('id', $appointment->id)->update(['customer_status' => 1]);
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Customer has been Created!']);
    }
    /* reset customer data */
    public function resetFields()
    {
        $this->lead_id = "";
        $this->start_time = "";
        $this->end_time = "";
        $this->start_date = "";
        $this->quotation_no = "";
        $this->type = "";
        $this->resetErrorBag();
    }
    public function quotationData(){

    $this->quotation_no="";
    
    $quotations = Quotation::where('lead_id', $this->lead_id)->first();
    if (!$quotations) {
        // Quotation not found for the lead, show an error
        $this->addError('lead_id', 'No quotation available for this lead.');
        return;
    }
    $this->quotation_no =$quotations->quotation_number ;
   
}

}
