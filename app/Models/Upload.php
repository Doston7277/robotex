<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';
    protected $primaryKey = 'upload_id';
    protected $fillable = [
        'upload',
    ];
    protected $casts = [
        'upload'=>'array'
    ];
}
