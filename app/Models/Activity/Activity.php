<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

use App\Models\Projects\SubProjects;

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

    protected $appends = ['subprojects'];

    public function subprojects() {
        return $this->belongsTo(
            SubProjects::class,
            'project_id',
            'id'
        );
    }

    public function getSubprojectsAttribute() {
        $subprojects = $this->subprojects()->first();
        unset($subprojects->created_at);
        unset($subprojects->updated_at);
        return $subprojects ? $subprojects->toArray() : null;
    }
}
