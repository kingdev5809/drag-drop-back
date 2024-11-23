<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'userId', 'backImg'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
