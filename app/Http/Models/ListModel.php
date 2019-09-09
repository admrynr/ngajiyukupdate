<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name', 'base_price', 'stock', 'image', 'product_type_id', 'final_price'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
