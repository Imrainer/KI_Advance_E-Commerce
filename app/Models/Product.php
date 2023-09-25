<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";

    protected $fillable = [
        'id',  'name', 'product_description','categories_id','photo_thumbnail','price','stock'
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function categories() {
        return $this->belongsTo(Categories::class, 'categories_id');
    } 

    public function photoCarousel()
    {
        return $this->hasMany(Photo_Carousel::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function History()
    {
        return $this->hasMany(History::class);
    }

    public function Favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function Cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('YmdHis', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('YmdHis', strtotime($value));
    }
}
