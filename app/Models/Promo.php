<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = "promo";

    protected $fillable = [
        'id', 'photo',
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

}
