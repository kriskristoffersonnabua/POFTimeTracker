<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $fillable = [
        'subproject_id',
        'activity_no',
        'employee_user_id',
        'title',
        'description',
        'acceptance_criteria',
        'estimated_hours'
    ];
}
