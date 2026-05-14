<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    protected $fillable = ['name', 'dui', 'max_hours', 'supervisor_name'];

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
}
