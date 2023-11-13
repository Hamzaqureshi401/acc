<?php

namespace App\Http\Livewire\Admin\Products;

use Image;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithFileUploads;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddProducts extends Component
{
    use WithFileUploads;
    public $code,$name,$category,$categories,$suppliers,$image,$price,$unit, $unit_type,$supplier,$cost,$quantity,$quantity_alert,$loyalty_points=0,$description,$is_veg=0,$is_active=1,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.products.add-products');
    }
    /* process before render */
    public function mount()
    {
        $this->categories = ProductCategory::where('is_active',1)->get();
        $this->suppliers = Supplier::where('is_active',1)->get();
        if(!Auth::user()->can('add_product'))
        {
            abort(404);
        }
    }
    /* store products*/
    public function create()
    {
        $this->validate([
            'name'  => 'required',
            'code'  => 'required|unique:products',
            'category'  => 'required',
            'price' => 'required',
            'unit' => 'required',
            'supplier' => 'required',
            // 'cost' => 'required',
            'unit_type' => 'required',
            'quantity' => 'required',
            'quantity_alert' => 'required',
                    ]);
        $product = new Product();
        $product->name = $this->name;
        $product->code = $this->code;
        $product->category_id = $this->category;
        $product->price = $this->price;
        $product->supplier_id = $this->supplier;
        $product->cost = $this->cost;
        $product->quantity = $this->quantity;
        $product->quantity_alert = $this->quantity_alert;
        $product->description = $this->description;
        $product->loyalty_points =$this->loyalty_points;
        $product->unit =$this->unit;
        $product->unit_type =$this->unit_type;
        $product->is_veg = $this->is_veg;
        $product->is_active = $this->is_active;
       
        if($this->image){
            
            $default_image = $this->image;
            $input['file'] = time().'.'.$default_image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/products/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $imgFile = Image::make($this->image->getRealPath());
            $imgFile->resize(1000,1000,function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationPath.'/'.$input['file']);
            $imageurl = '/uploads/products/'.$input['file'];
            $product->image = $imageurl;
        }
        $product->save();
        if($this->quantity){
            $stock = new Stock();
            $stock->product_id = $product->id;
            $stock->quantity = $this->quantity;
            $stock->save();
        }
        return redirect()->route('admin.view_products');
    }
}
