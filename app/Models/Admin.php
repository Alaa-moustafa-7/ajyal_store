<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\HasRoles;


class Admin extends User
{
    use HasFactory,
    Notifiable,
    HasApiTokens,
    HasRoles;

    protected $fillable = [
        'name', 'email', 'username', 'password', 'phone_number', 'super_admin', 'status',
    ];
}
