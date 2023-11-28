<?php

namespace App\Http\Livewire\Admin\Leads;
use App\Models\Appointment;
use App\Models\Quotation;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductLeads extends Component
{
    public $leads,$name,$description,$lead,$is_active = true,$lang,$start_time,$end_time,$start_date,$end_date,$lead_id , $custom_note , $lead_name;

    public $phone,$email,$address,$search="";
    /* render the page */
    public function render()
    {
        $this->getData();
        return view('livewire.admin.productleads.productleads');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('productleads_list'))
        {
            abort(404);
        }
    }
    public function getData()
    {
        $query = Lead::latest()->where('source','Product page');
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
        /* reset lead data */
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->resetErrorBag();
    }

        public function appointment(Lead $lead){
        $this->resetappointmentFields();
        $this->lead_id=$lead->id;
        $this->lead_name=$lead->name;
        $this->start_date = date('Y-m-d');
        $quotations = Quotation::where('lead_id', $this->lead_id)->first();
        if (!$quotations) {
            // Quotation not found for the lead, show an error
            // $this->addError('lead_name', 'No quotation available for this lead. Please First create a Quotation');
            return;
        }
        $this->quotation_no =$quotations->quotation_number ;
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
        $appointment->quotation_no=$this->quotation_no ?: null;
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
}
