<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class users extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "users";
    protected $fillable = ['username', 'password', 'role_id', 'login_attempt', 'is_locked', 'email', 'created_by', 'created_at'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(role::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
