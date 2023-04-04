<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $table = "attributes";
    protected $hidden = ['pivot'];
    protected $fillable = [
        'attribute_name',
        'attribute_value',
    ];
    public $timestamps = false;
}
