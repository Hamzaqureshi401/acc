<?php

namespace App\Http\Livewire\Admin\Invoices;

use Carbon\Carbon;
use App\Models\Addon;
use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Auth;

class AddInvoices extends Component
{
    public $customers,$products,$product_id,$product_name,$productPrice,$productQuantity,$total,$tax= 'yes',$sales_tax,$total_tax=0,$lang,$available,$quantity,$customer,$selected_products=[];
    public $subject,$date,$customer_id,$address,$stage,$discount,$description,$customer_note,$totalTax,$totalDiscount,$totalAmount,$subAmount;
    public $quotations,$quotation_id,$maintenance_date,$first_invoice,$first_invoice_amount,$first_due_date,$second_invoice,$second_invoice_amount,$second_due_date,$productdescription,$productUnit,$type;
    /* render the page */
    public function render()
    {
        $this->customers = Customer::latest()->get();
        $this->products = Product::latest()->get();
        $this->quotations = Quotation::latest()->where('invoice_status',0)->get();
        $this->date=Carbon::today()->toDateString();
        $this->first_due_date=date('y-m-d', strtotime('+5 days'));
        return view('livewire.admin.invoices.add-invoices');
    }
    /* process before render */
    public function mount()
    {

        $this->lang = getTranslation();
        if(!Auth::user()->can('invoice_list'))
        {
            abort(404);
        }
    }
    /* delete products with foreign key delete restriction */   

    public function selectQuotation(){
        $this->resetEverything();
        $quotation=Quotation::where('id',$this->quotation_id)->first();
        $this->subject=$quotation->subject;
        $this->created_date=$quotation->created_date;
        $this->expiry_date=$quotation->expiry_date;
        $this->sales_tax=$quotation->sales_tax;
        $this->discount=$quotation->discount;
        $this->subAmount=$quotation->sub_total;
        $this->totalDiscount=$quotation->discount_amount;
        $this->totalTax=$quotation->tax_amount;
        $this->totalAmount=$quotation->total_amount;
        $this->description=$quotation->description;
        $this->customer_note=$quotation->customer_note;
        $this->first_due_date = date('Y-m-d', strtotime('+5 days'));
        $selected=$quotation->details;
        $customer = Customer::where('lead_id', $quotation->lead_id)->first();
        if($customer!=null){
            $this->customer_id=$customer->id;
            $this->address=$customer->postcode.",".$customer->address.",".$customer->city;
        }
        foreach ($selected as $key => $product) {
            $this->selected_products[] = [
                'product_id' => $product->product_id,
                'name' => $product->product->name,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'total_tax' => $product->tax,
                'total' => $product->total,
                'description' => $product->description,
                'unit' => $product->unit,
            ];
        }
    }

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
        $this->tax="No";
    }

    public function create(){
        $this->validate([
            'type'  => 'required',
            'customer_id'  => 'required',
            'date'  => 'required',
            'address'  => 'required',
            'first_invoice'=>'required',
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

        $invoice = new Invoice();
        $invoice->invoice_number=date("His");
        $invoice->type=$this->type;
        $invoice->date=$this->date;
        $invoice->customer_id=$this->customer_id;
        $invoice->address=$this->address;
        $invoice->sales_tax=$this->sales_tax;
        $invoice->discount=$this->discount;
        $invoice->maintenance_date=$this->maintenance_date;
        $invoice->first_invoice=$this->first_invoice;
        $invoice->first_invoice_amount=($this->totalAmount/100)*$this->first_invoice;
        $invoice->first_due_date=$this->first_due_date;
        $invoice->second_invoice=$this->second_invoice;
        $invoice->second_invoice_amount=($this->totalAmount/100)*$this->second_invoice;
        $invoice->second_due_date=$this->second_due_date;
        $invoice->sub_total=$this->subAmount;
        $invoice->discount_amount=$this->totalDiscount;
        $invoice->tax_amount=$this->totalTax;
        $invoice->total_amount=$this->totalAmount;
        $invoice->description=$this->description;
        $invoice->customer_note=$this->customer_note;
        $invoice->save();

        foreach ($this->selected_products as $key => $item) 
        {
            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->product_id = $item['product_id'];
            $invoiceDetail->product_name = $item['name'];
            $invoiceDetail->price = $item['price'];
            $invoiceDetail->tax = $item['total_tax'];
            $invoiceDetail->total = $item['total'];
            $invoiceDetail->quantity = $item['quantity'];
            $invoiceDetail->unit = $item['unit'];
            $invoiceDetail->description = $item['description'];
            $invoiceDetail->save();

            // $product=Product::where('id', $item['product_id'])->first();
            // $product->quantity= $product->quantity - $item['quantity'];
            // $product->save();
        }
        Quotation::where('id', $this->quotation_id)->update(['invoice_status' => 1]);
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success','title' => 'invoice Saved!',  'message' => 'invoice #'.$invoice->invoice_number.' has been saved..']);
        $this->resetEverything();
        return;
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

    public function checkper(){
        if($this->first_invoice<0 || $this->first_invoice>100){
            $this->first_invoice=0;
            $this->second_invoice=0;
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error','title' => 'Invalid!',  'message' => 'Invoice Percentage can not be less than 0 or greater than 100!']);
            return;
        }else{
            $this->second_invoice=100-$this->first_invoice;
        }
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
        $this->date='';
        $this->customer_id='';
        $this->address='';
        $this->sales_tax='';
        $this->discount='';
        $this->sub_total='';
        $this->discount_amount='';
        $this->tax_amount='';
        $this->total_amount='';
        $this->description='';
        $this->customer_note='';
        $this->first_invoice='';
        $this->first_due_date='';
        $this->second_invoice='';
        $this->second_due_date='';
        $this->maintenance_date='';
        $this->type='';
    }
}
