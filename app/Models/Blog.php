<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'blog_id';
    protected $fillable = [
        'blog_title',
        'blog_body',
        'blog_tags',
        'blog_author',
        'blog_image'
    ];
    protected $casts = [
        'blog_title'    =>'array',
        'blog_tags'     =>'array',
        'blog_body'     =>'array',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'user_id','blog_author');
    }
}
