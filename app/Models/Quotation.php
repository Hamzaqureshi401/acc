<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\QuotationDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->created_by = Auth::user()->id;
        });
    }

    public function details()
    {
        return $this->hasMany(QuotationDetail::class,'quotation_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'lead_id','lead_id');
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id','id');
    }
    public function creater()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
