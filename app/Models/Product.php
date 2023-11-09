<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->created_by = Auth::user()->id;
        });
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class,'category_id','id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
    
    public function photo()
    {
        if($this->image && file_exists(public_path($this->image)))
        {
            return asset($this->image);
        }
        return asset('/assets/img/photos/no-item-image.png');
    }

    public function addons()
    {
        return $this->hasMany(Addon::class,'product_id','id');
    }
    public function stock()
    {
        return $this->hasMany(Stock::class,'product_id','id');
    }
}