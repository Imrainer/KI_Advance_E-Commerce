<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = "history";

    protected $fillable = [
        'id', 'date', 'status','product_id', 'quantity', 'created_by'
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
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
