<?php

namespace App\Http\Livewire\Admin\Inventory;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\Product;
use Livewire\Component;
use App\Exports\StockReportExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DateWiseStockReportExport;

class StockReportDateWise extends Component
{
    public $data=[],
            $product,
            $product_id,
            $lang,
            $title="Date-Wise Stock Report",
            $categories,
            $brands,
            $clients,
            $supplier_brand_id,
            $category_id,
            $client_id,
            $date;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.inventory.stock-report-datewise');
    } 
    /* process before render */
    public function mount()
    {
        
        
        $this->lang = getTranslation();
        if(!Auth::user()->can('stock_report'))
        {
            abort(404);
        }
        $this->getData();
        
    }
    /* feach Item wise sales report*/
    public function getData()
    {
        $this->product=Product::latest()->get();
        $this->categories = ProductCategory::get();
        $this->brands = Supplier::get();
        $this->clients = Customer::get();
        
        $this->data = $this->filterData($this->supplier_brand_id , $this->category_id, $this->client_id , $this->product_id , $this->date);

        //dd($this->supplier_brand_id , $this->category_id, $this->client_id , $this->product_id);

    }   

    public function filterData($brand_id , $category_id , $client_id , $product_id , $date){

        // Assuming you have variables $brand_id, $category_id, $client_id, $product_id

// Check and set $brand_id
$brand_id = ($brand_id === 'All') ? null : $brand_id;

// Check and set $category_id
$category_id = ($category_id === 'All') ? null : $category_id;

// Check and set $client_id
$client_id = ($client_id === 'All') ? null : $client_id;

// Check and set $product_id
$product_id = ($product_id === 'All Products') ? null : $product_id;

//dd($brand_id , $category_id , $client_id , $product_id);

// Now $brand_id, $category_id, $client_id, and $product_id are set to empty if their value was "All"

      return Stock::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
    ->with('product', 'invoicedetails.invoice') 
    ->when(!empty($brand_id), function ($query) use ($brand_id) {
        $query->whereHas('product', function ($subquery) use ($brand_id) {
            $subquery->where('supplier_id', $brand_id);
        });
    })
    ->when(!empty($category_id), function ($query) use ($category_id) {
        $query->whereHas('product', function ($subquery) use ($category_id) {
            $subquery->where('category_id', $category_id);
        });
    })
    ->when(!empty($client_id), function ($query) use ($client_id) {
        $query->whereHas('invoicedetails.invoice', function ($subquery) use ($client_id) {
            $subquery->where('customer_id', $client_id);
        });
    })
    ->when(!empty($product_id), function ($query) use ($product_id) {
        $query->where('product_id', $product_id);
    })
    ->when(!empty($date), function ($query) use ($date) {
        $query->whereDate('created_at', $date);
    })
    ->groupBy('product_id')
    ->get();


    }

    public function exportToExcel(){
        return Excel::download(new DateWiseStockReportExport($this->data,$this->title), 'datewise-stock-report.xlsx');
    }

    public function exportToPDF(){
        return Excel::download(new DateWiseStockReportExport($this->data,$this->title), 'datewise-stock-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
