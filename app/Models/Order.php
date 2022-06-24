<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'status','user_id','order_number','per_amount','order_date','quantity','order_status'
    ];
    public function orderdetail()
    {
        return $this->hasMany(Order::class);
    }
}
