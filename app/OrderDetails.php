<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model {
    
    use SoftDeletes;

    protected $table = 'order_details';

    protected $fillable = [
        'email', 'product_id', 'product_name', 'pay_time'
    ];
}
