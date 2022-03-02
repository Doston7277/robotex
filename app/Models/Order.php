<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'products',
        'order_status'
    ];

    protected $casts = [
        'products'=>'array',
    ];

    public function users()
    {
        return $this->hasOne(User::class,'user_id','user_id');
    }
}
