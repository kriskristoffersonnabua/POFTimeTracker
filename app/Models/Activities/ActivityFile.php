<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;

class ActivityFile extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_files';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}