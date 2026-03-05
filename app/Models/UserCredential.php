<?php

namespace App\Models;

use App\Traits\HasDynamicPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCredential extends BaseModel
{
    use HasFactory, HasDynamicPrimaryKey;

    protected $fillable = [
        'user_id',
        'username',
        'provider',      
        'provider_id',   
        'password',      
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
