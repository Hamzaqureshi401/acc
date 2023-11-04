<?php

namespace App\Http\Livewire\Admin\Leads;
use App\Models\Appointment;
use App\Models\Lead;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuoteLeads extends Component
{
    public $leads,$name,$description, $type,$lead,$is_active = true,$lang,$start_time,$end_time,$start_date,$end_date,$lead_id;
    public $phone,$email,$address,$search="";
    /* render the page */
    public function render()
    {
        $this->getData();
        return view('livewire.admin.quoteleads.quoteleads');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('quoteleads_list'))
        {
            abort(404);
        }
    }
    public function getData()
    {
        $query = Lead::latest()->where('source','Quote page');
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
            'email' => 'email|unique:leads'
        ]);
        $lead = new Lead();
        $lead->name = $this->name;
        $lead->phone = $this->phone;
        $lead->email = ($this->email == "" ? null : $this->email);
        $lead->address = $this->address;
        $lead->type = "System";
        $lead->save();
        $this->emit('closemodal');
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
        $this->address = $lead->address;
    }
    /* update lead data */
    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'phone'  => 'required',
            'email' => 'nullable|email|unique:leads,email,'.$this->lead->id,
        ]);
        $lead = $this->lead;
        $lead->name = $this->name;
        $lead->phone = $this->phone;
        $lead->email = ($this->email == "" ? null : $this->email);
        $lead->address = $this->address;
        $lead->save();
        $this->emit('closemodal');
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
            $this->addError('lead_name', 'No quotation available for this lead. Please First create a Quotation');
            return;
        }
        $this->quotation_no =$quotations->quotation_number ;
        
    }
    public function makeappointment(){
        $this->validate([
            'lead_id'  => 'required',
            'start_time'  => 'required',
            'end_time'  => 'required',
            'start_date'  => 'required',
            'quotation_no'  => 'required',
            'type'  => 'required',
        ]);
        $appointment = new Appointment();
        $appointment->lead_id = $this->lead_id;
        $appointment->start_time = $this->start_time;
        $appointment->end_time = $this->end_time;
        $appointment->start_date = $this->start_date;
        $appointment->quotation_no = $this->quotation_no;
        $appointment->type = $this->type;
        $appointment->save();
        Lead::where('id', $appointment->lead_id)->update(['appointment_status' => 1]);
        $this->emit('closemodal');
        $this->resetFields();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Appointment has been sechduled!']);
    }

    /* reset lead data */
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->resetErrorBag();
    }

    public function resetappointmentFields()
    {
        $this->lead_id = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->start_date= '';
        $this->quotation_no= '';
        $this->resetErrorBag();
    }
}
