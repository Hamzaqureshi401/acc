<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->created_by = Auth::user()->id;
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function invoicedetails()
    {
        return $this->hasMany(InvoiceDetail::class,'product_id','product_id');
    }
}
