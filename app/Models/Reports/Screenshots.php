<?php

namespace App\Models\Reports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Screenshots extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'screenshots';

    // protected $hidden = ['screenshot'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Fillable Fields
     *
     * @var string
     */
    protected $fillable = ['screenshot', 'date_added', 'time_history_id'];
}
