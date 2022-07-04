<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PwdReset extends Model
{
    use HasFactory;
    protected $updated_at = false;
    protected $created_at = false;
    protected $table = 'Pwd_resets';
    protected $fillable =[
        'pwdResetEmail',
        'pwdResetValidator',
        'pwdResetToken',
        'pwdExpires'
    ];

}
