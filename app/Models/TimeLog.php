<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = ['intern_id', 'date', 'activity_description', 'hours_logged'];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
