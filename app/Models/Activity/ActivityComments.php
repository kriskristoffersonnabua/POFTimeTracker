<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityComments extends Model
{
    protected $table = 'activity_comments';

    protected $fillable = [
        'activity_id',
        'user_id',
        'comment',
        'date_added',
    ];
}
