<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity\Activity;

class SubProjects extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subprojects';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'subproject_no',
        'subproject_name', 
        'description'
    ];

    public function activities() {

        return $this->hasMany(
            Activity::class,
            'subproject_id',
            'id'
        );
    }
}
