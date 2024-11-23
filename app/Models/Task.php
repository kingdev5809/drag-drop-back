<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'columnId', 'order'];

    public function column()
    {
        return $this->belongsTo(Column::class, 'columnId');
    }
}
