<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','product_id','quantity','per_amount'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
