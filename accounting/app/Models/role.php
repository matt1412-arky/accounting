<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "roles";
    protected $fillable = ['name', 'desc', 'created_by', 'created_at'];
}
