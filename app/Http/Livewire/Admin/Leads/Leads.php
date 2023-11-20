<?php

namespace App\Http\Livewire\Admin\Leads;

use App\Models\Lead;
use Livewire\Component;
use App\Models\Quotation;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;


class Leads extends Component
{
    public $leads,$name,$description,$lead,$is_active = true,$lang,$start_time,$end_time,$start_date,$end_date,$lead_id;
    public $phone,$email,$address,$search="",$postcode,$city, $custom_note;
    /* render the page */
    public function render()
    {
        $this->getData();
        return view('livewire.admin.leads.leads');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        $this->start_date = now()->format('Y-m-d');

        if(!Auth::user()->can('leads_list'))
        {
            abort(404);
        }
    }
    public function getData()
    {
        $query = Lead::latest()->where('source','System');
        if($this->search != '')
        {
            $query = $query->where('name','like','%'.$this->search.'%');
        }
        $this->leads = $query->get();
    }
    /* store lead data */
    public function create()
    {
        $this->validate([
            'name'  => 'required',
            'phone'  => 'required',
            'email' => 'email|unique:leads',
            'postcode' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);
        $lead = new Lead();
        $lead->name = $this->name;
        $lead->phone = $this->phone;
        $lead->email = ($this->email == "" ? null : $this->email);
        $lead->postcode = $this->postcode;
        $lead->address = $this->address;
        $lead->city = $this->city;
        $lead->source = "System";
        $lead->type = "System";
        $lead->save();
        $this->emit('closemodal');
        $this->resetFields();
        
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Lead has been created!']);
    }

    /* reset lead data */
    public function edit(Lead $lead)
    {
        $this->resetFields();
        $this->lead = $lead;
        $this->name = $lead->name;
        $this->phone = $lead->phone;
        $this->email = $lead->email;
        $this->postcode = $lead->postcode;
        $this->address = $lead->address;
        $this->city = $lead->city;
    }
    /* update lead data */
    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'phone'  => 'required',
            'email' => 'nullable|email|unique:leads,email,'.$this->lead->id,
            'postcode' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);
        $lead = $this->lead;
        $lead->name = $this->name;
        $lead->phone = $this->phone;
        $lead->email = ($this->email == "" ? null : $this->email);
        $lead->postcode = $this->postcode;
        $lead->address = $this->address;
        $lead->city = $this->city;
        $lead->save();
        $this->emit('closemodal');
        $this->resetFields();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'lead has been updated!']);
    }
    /* delete lead data */
    public function delete(Lead $lead)
    {
        $lead->delete();
        $this->lead = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'lead has been deleted!']);
    }
    /* make appointment */
    public function appointment(Lead $lead){
        $this->resetappointmentFields();
        $this->lead_id=$lead->id;
        $this->lead_name=$lead->name;
        $quotations = Quotation::where('lead_id', $this->lead_id)->first();
        if (!$quotations) {
            // Quotation not found for the lead, show an error
            // $this->addError('lead_name', 'No quotation available for this lead. Please First create a Quotation');
            return;
        }
        $this->quotation_no =$quotations->quotation_number ;
    }

    public function appointmentdata(Lead $lead){
        $this->resetappointmentdataFields();
        $this->data_lead_name=$lead->name;
        $appointment = Appointment::where('lead_id', $lead->id)->first();
        $this->data_start_time=$appointment->start_time;
        $this->data_end_time=$appointment->start_time;
        $this->data_start_date=$appointment->start_date;
        $this->data_quotation_no=$appointment->quotation_no;
        $this->data_type=$appointment->type;
    }
    public function makeappointment(){
        $this->validate([
            'start_time'  => 'required',
            'end_time'  => 'required',
            // 'start_date'  => 'required',
            // 'quotation_no'  => 'required',
            'type'  => 'required',
        ]);
        $appointment = new Appointment();
        $appointment->lead_id=$this->lead_id;
        $appointment->start_time=$this->start_time;
        $appointment->end_time=$this->end_time;
        $appointment->start_date= $this->start_date ? : now()->toDateString();
        $appointment->quotation_no=$this->quotation_no;
        $appointment->type=$this->type;
        $appointment->save();
        Lead::where('id', $appointment->lead_id)->update(['appointment_status' => 1]);
        $this->emit('closemodal');
        $lead = Lead::find($this->lead_id);
        if ($lead) {
            $lead->update(['appointment_status' => '1']);
        }
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Appointment has been scheduled!']);
    }
    /* reset lead data */
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->postcode = '';
        $this->address = '';
        $this->city = '';
        $this->resetErrorBag();
    }
       
    public function resetappointmentFields()
    {
        $this->lead_id = '';
        $this->start_time = '';
        $this->end_time = '';
        // $this->start_date= '';
        $this->end_date= '';
        $this->quotation_no= '';
        $this->type= '';
        $this->resetErrorBag();
    }

    public function resetappointmentdataFields()
    {
        $this->data_lead_name = '';
        $this->data_start_time = '';
        $this->data_end_time = '';
        $this->data_start_date= '';
        $this->data_end_date= '';
        $this->data_quotation_no= '';
        $this->data_type= '';
        $this->resetErrorBag();
    }
}
