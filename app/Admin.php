<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin'; // Reference the correct table
    protected $fillable = ['name', 'email', 'password', 'cnic', 'address'];

    protected $hidden = ['password', 'remember_token'];
}
