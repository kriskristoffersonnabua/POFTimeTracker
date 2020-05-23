<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

use App\Models\Projects\SubProjects;
use App\Models\Activity\ActivityTBAS;
use App\Models\Activity\ActivityFile;

class Activity extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subproject_id',
        'activity_no',
        'employee_user_id',
        'title',
        'description',
        'acceptance_criteria',
        'estimated_hours',
        'status'
    ];
    protected $appends = ['files', 'tbas'];
    
    public function subprojects() {
        return $this->belongsTo(
            SubProjects::class,
            'subproject_id',
            'id'
        );
    }

    public function tbas() {
        return $this->hasMany(
            ActivityTBAS::class,
            'activity_id',
            'id'
        );
    }

    public function files() {
        return $this->hasMany(
            ActivityFile::class,
            'activity_id',
            'id'
        );
    }

    public function getTbasAttribute() {
        return $this->tbas()->get()->toArray();
    }

    public function getFilesAttribute() {
        return $this->files()->get()->toArray();
    }
}
