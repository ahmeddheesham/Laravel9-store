<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'address', 'phone', 'email', 'logo', 'favicon', 'facebook', 'twitter', 'instagram', 'youtube', 'tiktok'];
    protected $table = 'settings';
}
