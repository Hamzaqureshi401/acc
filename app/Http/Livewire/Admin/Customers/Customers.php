<?php

namespace App\Http\Livewire\Admin\Customers;

use Image;
use Livewire\WithFileUploads;
use App\Models\Lead;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class Customers extends Component
{
    use WithFileUploads;
    public $customers,$name,$description,$customer,$is_active = true,$lang,$leads,$lead_id;
    public $phone,$email,$address,$postcode,$city,$situation_image,$customer_note;
    /* render the page */
    public function render()
    {
        $this->customers = Customer::latest()->get();
        $this->leads = Lead::latest()->where(['appointment_status'=>1,'status'=>0])->get();
        return view('livewire.admin.customers.customers');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('customers_list'))
        {
            abort(404);
        }
    }
    /* store customer data */
    public function create()
    {
        $this->validate([
            'lead_id'  => 'required',
        ]);
        $lead=Lead::where('id', $this->lead_id)->first();
        $customer = new Customer();
        $customer->lead_id = $this->lead_id;
        $customer->name = $lead->name;
        $customer->phone = $lead->phone;
        $customer->email = ($lead->email == "" ? null : $lead->email);
        $customer->address = $lead->address;
        $customer->save();
        Appointment::where('lead_id', $this->lead_id)->update(['customer_status' => 1]);
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Customer has been created!']);
    }

    /* reset customer data */
    public function edit(Customer $customer)
    {
        $this->resetFields();
        $this->customer = $customer;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->email = $customer->email;
        $this->postcode = $customer->postcode;
        $this->address = $customer->address;
        $this->city = $customer->city;
        $this->customer_note = $customer->customer_note;

        
    }
     public function view(Customer $customer)
    {
        //$this->resetFields();
        $this->customer = $customer;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->email = $customer->email;
        $this->postcode = $customer->postcode;
        $this->address = $customer->address;
        $this->city = $customer->city;
        $this->customer_note = $customer->customer_note;
                $this->situation_image = $customer->situation_image;

        
        
    }
    /* update customer data */
    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'phone'  => 'required',
            'email' => 'nullable|email|unique:customers,email,'.$this->customer->id,
        ]);
        //dd($this->customer_note);
        $customer = $this->customer;
        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->email = ($this->email == "" ? null : $this->email);
        $customer->postcode = $this->postcode;
        $customer->address = $this->address;
        $customer->city = $this->city;
        $customer->customer_note = $this->customer_note;
        if($this->situation_image){
            
            $default_image = $this->situation_image;
            $input['file'] = time().'.'.$default_image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/situation/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $imgFile = Image::make($this->situation_image->getRealPath());
            $imgFile->resize(1000,1000,function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationPath.'/'.$input['file']);
            $imageurl = '/uploads/situation/'.$input['file'];
            $customer->situation_image = $imageurl;
        }
        $customer->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Customer has been updated!']);
    }
    /* delete customer data */
    public function delete(Customer $customer)
    {
        $customer->delete();
        $this->customer = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Customer has been deleted!']);
    }
    /* reset customer data */
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->postcode = '';
        $this->address = '';
        $this->city = '';
        $this->lead_id = '';
        $this->custom_note = '';
        $this->resetErrorBag();
    }
}
