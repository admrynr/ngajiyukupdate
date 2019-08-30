<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name', 'price', 'stock', 'image'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
