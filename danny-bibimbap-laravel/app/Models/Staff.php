<?php
// app/Models/Staff.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // 使用 Laravel 內建的認證功能
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'member_ID';

    protected $fillable = [
        'name',
        'gender',
        'position',
        'phone',
        'email',
        'password', // 用於登入
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}