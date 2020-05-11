<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class SubprojectEmployees extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subproject_employees';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
