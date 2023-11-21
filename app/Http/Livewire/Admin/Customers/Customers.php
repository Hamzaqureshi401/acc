<?php

namespace App\Http\Livewire\Admin\Customers;

use App\Models\CustomerMedia;
use Image;
use Livewire\WithFileUploads;
use App\Models\Lead;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class Customers extends Component
{
    use WithFileUploads;
    public $customers, $name, $description, $customer, $is_active = true, $lang, $leads, $lead_id;
    public $phone, $email, $address, $postcode, $city, $situation_image, $customer_note,  $situation_images = [], $old_situation_images = [];
    protected $listeners = ['imageDeleted' => 'refreshOldImages'];

    
    /* render the page */
    public function render()
    {
        $this->customers = Customer::with('media')->latest()->get();

        // Fetch leads
        $this->leads = Lead::latest()->where(['appointment_status' => 1, 'status' => 0])->get();

        return view('livewire.admin.customers.customers');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if (!Auth::user()->can('customers_list')) {
            abort(404);
        }
    }
    /* store customer data */
    public function create()
    {
        $this->validate([
            'lead_id'  => 'required',
        ]);
        $lead = Lead::where('id', $this->lead_id)->first();
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
            'alert',
            ['type' => 'success',  'message' => 'Customer has been created!']
        );
    }
    public function deleteImage($index)
    {
        // Get the image path from the array
        $imagePath = $this->situation_images[$index];
    
        // Optionally, delete the image file from storage
        if (is_string($imagePath)) {
            // Delete the file from storage
            Storage::delete($imagePath);
    
            // Delete the image record from the database
            $customerMedia = CustomerMedia::where('situation_image', $imagePath)->first();
            if ($customerMedia) {
                $customerMedia->delete();
            }
        }
    
        unset($this->situation_images[$index]);
        $this->situation_images = array_values($this->situation_images);
    
        // Emit an event to trigger a refresh when an image is deleted
        $this->emit('imageDeleted');
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
        $customerMedia = $customer->media;

        // Map media to an array of URLs
        $this->situation_images = $customerMedia->map(function ($media) {
            return $media->situation_image;
        })->toArray();

        $this->old_situation_images = $customer->media->map(function ($media) {
            return $media->situation_image;
        })->toArray();
    
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
        $customerMedia = $customer->media;

        // Map media to an array of URLs
        $this->situation_images = $customerMedia->map(function ($media) {
            return $media->situation_image;
        })->toArray();
    }
    /* update customer data */
    public function update()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email|unique:customers,email,' . $this->customer->id,
            // 'situation_images.*' => 'image|max:1024', // Adjust the validation rules accordingly
        ]);

        $customer = $this->customer;
        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->email = ($this->email == "" ? null : $this->email);
        $customer->postcode = $this->postcode;
        $customer->address = $this->address;
        $customer->city = $this->city;
        $customer->customer_note = $this->customer_note;
        $customer->save();

        if ($this->situation_images) {
            foreach ($this->situation_images as $situation_image) {
                $customerMedia = new CustomerMedia(); // Move this line inside the loop

                $input['file'] = time() . '_' . $situation_image->getClientOriginalName();
                $destinationPath = public_path('/uploads/situation/');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $imgFile = Image::make($situation_image->getRealPath());
                $imgFile->resize(1000, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($destinationPath . '/' . $input['file']);

                $imageurl = '/uploads/situation/' . $input['file'];
                $customerMedia->situation_image = $imageurl;
                $customerMedia->customer_id = $this->customer->id;
                $customerMedia->save();
            }
        }

        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success', 'message' => 'Customer has been updated!']
        );
    }
    public function delete(Customer $customer)
    {
        $customer->delete();
        $this->customer = null;
        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success',  'message' => 'Customer has been deleted!']
        );
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
        $this->customer_note = '';
        $this->resetErrorBag();
    }
    public function refreshOldImages()
{
    // Fetch the updated data or perform any necessary operations
    $this->old_situation_images = $this->customer->media->map(function ($media) {
        return $media->situation_image;
    })->toArray();
}
}
