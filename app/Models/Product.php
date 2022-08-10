<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public $timestamps = false;

    protected $fillable = ["product_code","product_long_name","Product_short_name","expiry_date","price"];
}
