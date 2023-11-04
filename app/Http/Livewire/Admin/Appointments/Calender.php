<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Lead;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class Calender extends Component
{
    public $appointments,$leads,$description,$appointment,$is_active = true,$lang,$start_time,$end_time,$start_date,$end_date,$lead_id,$lead_name;
    public $phone,$email,$address;
    /* render the page */
    public function render()
    {
        $events = [];
 
        $this->appointments = Appointment::latest()->with('lead')->get();
 
        foreach ($this->appointments as $appointment) {
            $events[] = [
                'title' => $appointment->lead->name,
                'start' => $appointment->start_date.' '.$appointment->start_time,
                'end' => $appointment->end_date.' '.$appointment->end_time,
            ];
        }
        
        
        return view('livewire.admin.appointments.calender', compact('events'));
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
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
            'start_time'  => 'required',
            'end_time'  => 'required',
            'start_date'  => 'required',
            'end_date'  => 'required',
        ]);
        $appointment = new Appointment();
        $appointment->lead_id = $this->lead_id;
        $appointment->start_time = $this->start_time;
        $appointment->end_time = $this->end_time;
        $appointment->start_date = $this->start_date;
        $appointment->end_date = $this->end_date;
        $appointment->save();
        Lead::where('id', $appointment->lead_id)->update(['appointment_status' => 1]);
        $this->emit('closemodal');
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
        $this->start_date = $appointment->start_date;
        $this->end_date = $appointment->end_date;
    }
    /* update customer data */
    public function update()
    {
        $this->validate([
            'start_time'  => 'required',
            'end_time'  => 'required',
            'start_date'  => 'required',
            'end_date'  => 'required',
        ]);
        $appointment = $this->appointment;
        $appointment->start_time = $this->start_time;
        $appointment->end_time = $this->end_time;
        $appointment->start_date = $this->start_date;
        $appointment->end_date = $this->end_date;
        $appointment->save();
        $this->emit('closemodal');
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

    /* makeclient */
    public function makeclient(Appointment $appointment)
    {
        $customer = new Customer();
        $lead=Lead::where('id', $appointment->lead_id)->first();
        $customer->lead_id = $appointment->lead_id;
        $customer->name = $lead->name;
        $customer->phone = $lead->phone;
        $customer->email = $lead->email;
        $customer->address = $lead->address;
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
        $this->end_date = "";
        $this->resetErrorBag();
    }
}
