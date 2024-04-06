<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'data'];

    public $incrementing = false;

    public function searches()
    {
        return $this->belongsToMany(Search::class, 'product_search');
    }

    /**
     * @return void
     */
    public static function removeAll() {
        DB::table('product_search')->delete();
        DB::table('products')->delete();
    }
}
