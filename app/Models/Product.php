<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "products";
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name',
        'price',
        'vat',
        'created_by',
        'quantity',
        'product_image'
    ];
    protected $softDelete = true;

    public function productAttributes(){
        return $this->belongsTomany(Attributes::class,'product_attribute','product_id','attribute_id');
    }
}
