<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityTBAS extends Model
{
    protected $table = 'activity_tbas';

    protected $fillable = [
        'activity_id',
        'tba',
    ];
}
