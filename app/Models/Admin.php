<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'photo'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('YmdHis', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('YmdHis', strtotime($value));
    }
}
