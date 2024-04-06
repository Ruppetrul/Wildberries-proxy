<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public $timestamps = false;

    protected $fillable = ['id', 'text'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_search');
    }
}
