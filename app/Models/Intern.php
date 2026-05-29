<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    protected $fillable = [
        'name', 'dui', 'max_hours', 'supervisor_name',
        'university', 'request_number', 'email', 'phone',
        'birth_date', 'gender', 'assigned_unit', 'start_date',
        'end_date', 'schedule'
    ];

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
}
