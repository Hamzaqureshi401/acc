<?php

namespace App\Http\Livewire\Admin\Quotations;

use Carbon\Carbon;
use App\Models\Addon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Support\Facades\Auth;

class AddQuotations extends Component
{
    public $leads,$products,$product_id,$product_name,$productPrice,$productQuantity,$total,$tax,$sales_tax = 21,$total_tax=0,$lang,$available,$quantity,$customer,$selected_products=[],$productdescription;
    public $subject,$created_date,$expiry_date, $phone,$email,$customer_id,$lead_id,$address,$stage,$discount,$description,$customer_note,$totalTax,$totalDiscount,$totalAmount,$subAmount;
    /* render the page */
    public function render()
    {
        $this->leads = Lead::latest()->get();
        $this->products = Product::latest()->get();
        return view('livewire.admin.quotations.add-quotations');
    }
    /* process before render */
    public function mount()
    {
        $this->created_date = date('Y-m-d');
        $this->expiry_date = date('Y-m-d', strtotime('+15 days'));
        $this->lang = getTranslation();
        if(!Auth::user()->can('quotation_list'))
        {
            abort(404);
        }
    }
    /* delete products with foreign key delete restriction */   

    public function selectProduct(){
        $product=Product::where('id',$this->product_id)->first();
        $this->productPrice=$product->price;
        $this->productUnit=$product->unit;
        if($this->productQuantity==null){
            $this->productQuantity=1;
        }
        if($this->tax=="Yes"){
            if($this->sales_tax!=null){
                $tax=$this->sales_tax*(($this->productPrice*$this->productQuantity)/100);
                $this->total_tax=$tax;
                $this->total=($this->productPrice*$this->productQuantity) + $tax;
            }else{
                $this->tax="No";
                $this->total_tax=0;
                $this->total=($this->productPrice*$this->productQuantity);
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'error',  'message' => 'Please Enter Sales Tax First!']);
                return;
            }
        }else{
            $this->total_tax=0;
            $this->total=($this->productPrice*$this->productQuantity);
        }
    }

    public function calculate(){
        if($this->productQuantity==0){
            $this->productQuantity=1;
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Quantity can not be 0!']);
        }
        if($this->tax=="Yes"){
            if($this->sales_tax!=null){
                $tax=$this->sales_tax*(($this->productPrice*$this->productQuantity)/100);
                $this->total_tax=$tax;
                $this->total=($this->productPrice*$this->productQuantity) + $tax;
            }else{
                $this->tax="No";
                $this->total_tax=0;
                $this->total=($this->productPrice*$this->productQuantity);
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'error',  'message' => 'Please Enter Sales Tax First!']);
                return;
            }
        }else{
            $this->total_tax=0;
            $this->total=($this->productPrice*$this->productQuantity);
        }
    }

    public function addProduct(){
        $productFound = false;
        foreach ($this->selected_products as $key => $product) {
            if ($product['product_id'] == $this->product_id) {
                $this->selected_products[$key]['quantity'] += $this->productQuantity;
                $this->selected_products[$key]['total'] += $this->total;
                $this->selected_products[$key]['total_tax'] += $this->total_tax;
                $productFound = true;
                break;
            }
        }
        if (!$productFound) {
            $product=Product::where('id',$this->product_id)->first();
            if($product){
                $this->selected_products[] = [
                    'product_id' => $this->product_id,
                    'name' => $product->name,
                    'price' => $this->productPrice,
                    'quantity' => $this->productQuantity,
                    'total_tax' => $this->total_tax,
                    'total' => $this->total,
                    'description' => $this->productdescription,
                    'unit' => $this->productUnit,
                ];
            }
        }
        $this->resetFields();
    }

    public function removeProduct($index)
    {
        unset($this->selected_products[$index]);
        $this->selected_products = array_values($this->selected_products);
    }

    public function resetFields()
    {
        $this->resetErrorBag();
        $this->product_id = '';
        $this->productPrice='';
        $this->productQuantity='';
        $this->productdescription='';
        $this->productUnit='';
        $this->total_tax='';
        $this->total='';
    }

    public function create(){
        $this->validate([
            'lead_id'  => 'required',
            // 'created_date'  => 'required',
            'expiry_date'  => 'required',
            'stage'  => 'required',
            'phone'  => 'numeric',
            'email'  => 'email'
        ]);
        if(count($this->selected_products) == 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error','title' => 'Order Failed!',  'message' => 'Select some products!']);
            return;
        }
        if(($this->totalAmount) <= 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error','title' => 'Order Failed!',  'message' => 'Total cannot be less than 0!']);
            return;
        }

        $quotation = new Quotation();
        $quotation->quotation_number=date("His");
        $quotation->created_date=$this->created_date ?: now()->toDateString();
        $quotation->expiry_date=$this->expiry_date;
        $quotation->lead_id=$this->lead_id;
        $quotation->address=$this->address;
        $quotation->stage=$this->stage;
        $quotation->sales_tax=$this->sales_tax;
        // $quotation->discount=$this->discount;
        $quotation->sub_total=$this->subAmount;
        $quotation->discount_amount=$this->totalDiscount;
        $quotation->tax_amount=$this->totalTax;
        $quotation->total_amount=$this->totalAmount;
        $quotation->description=$this->description;
        $quotation->customer_note=$this->customer_note;
        $quotation->save();

        foreach ($this->selected_products as $key => $item) 
        {
            $quotationDetail = new QuotationDetail();
            $quotationDetail->quotation_id = $quotation->id;
            $quotationDetail->product_id = $item['product_id'];
            $quotationDetail->product_name = $item['name'];
            $quotationDetail->price = $item['price'];
            $quotationDetail->tax = $item['total_tax'];
            $quotationDetail->total = $item['total'];
            $quotationDetail->quantity = $item['quantity'];
            $quotationDetail->unit = $item['unit'];
            $quotationDetail->description = $item['description'];
            $quotationDetail->save();
        }
        Lead::where('id', $quotation->lead_id)->update(['quotation_status' => 1]);
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success','title' => 'Quotation Saved!',  'message' => 'Quotation #'.$quotation->quotation_number.' has been saved..']);
        $this->resetEverything();
        return redirect()->route('admin.view_quotations');
    }

    public function calculateTotalTax()
    {
        $totalTax = 0;
        foreach ($this->selected_products as $product) {
            $totalTax += $product['total_tax'];
        }
        $this->totalTax=$totalTax;
        return $this->totalTax;
    }

    public function calculatesubAmount()
    {
        $subAmount = 0;
        foreach ($this->selected_products as $product) {
            $subAmount += $product['total'];
        }
        $this->subAmount=$subAmount;
        return $this->subAmount;
    }

    public function calculateTotalDiscount()
    {
        $totalDiscount = 0;
        if($this->discount){
            $totalAmount = 0;
            foreach ($this->selected_products as $product) {
                $totalAmount += $product['total'];
            }
            $totalDiscount= ($totalAmount/100)*$this->discount;
        }
        $this->totalDiscount=$totalDiscount;
        return $this->totalDiscount;
    }

    public function calculateTotalAmount()
    {
        $totalAmount = 0;
        foreach ($this->selected_products as $product) {
            $totalAmount += $product['total'];
        }
        $this->totalAmount=$totalAmount-$this->totalDiscount;
        return $this->totalAmount;
    }

    public function resetEverything()
    {
        $this->resetErrorBag();
        $this->product_id = '';
        $this->productPrice='';
        $this->productQuantity='';
        $this->total_tax='';
        $this->total='';
        $this->tax='No';
        $this->selected_products=[];
        $this->subject='';
        $this->created_date='';
        $this->expiry_date='';
        $this->customer_id='';
        $this->address='';
        $this->stage='';
        $this->sales_tax='';
        $this->discount='';
        $this->sub_total='';
        $this->discount_amount='';
        $this->tax_amount='';
        $this->total_amount='';
        $this->description='';
        $this->customer_note='';
        $this->lead_id='';
        $this->email='';
        $this->phone='';
    }
    public function leadData(){
         $lead = Lead::find($this->lead_id);
        if (!$lead) {
            // Lead not found for the lead, show an error
            $this->addError('lead_id', 'No Data available for this lead.');
            return;
        }

        $this->email = $lead->email;
        $this->phone = $lead->phone;
    }
    
}
