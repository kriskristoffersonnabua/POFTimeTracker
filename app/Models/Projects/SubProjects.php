<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

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
}
