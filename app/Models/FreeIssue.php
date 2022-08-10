<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeIssue extends Model
{
    use HasFactory;

    protected $table = "free_issues";

    public $timestamps = false;

    protected $fillable = ["lable","purchase_product","freeproduct","purchesqty","freeqty","lowlim","upperlim"];
}
