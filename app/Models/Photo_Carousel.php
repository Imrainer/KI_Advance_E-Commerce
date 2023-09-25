<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_Carousel extends Model
{
    use HasFactory;

    protected $table = "photo_carousel";

    protected $fillable = [
        'id', 'photo', 'product_id'
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

     public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
