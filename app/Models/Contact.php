<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'contact_user_name',
        'contact_user_phone',
        'contact_subject',
        'contact_message',
    ];
}
