<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'password_resets';

    // Disable timestamps (since this table doesn't use `updated_at`)
    public $timestamps = false;

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}

