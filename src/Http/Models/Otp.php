<?php


namespace KaqazStudio\LaravelMobileAuth\Http\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'code'];

    protected $casts = [
        'created_at' => 'timestamp'
    ];
}
