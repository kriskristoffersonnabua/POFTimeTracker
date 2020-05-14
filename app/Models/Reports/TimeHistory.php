<?php

namespace App\Models\Reports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\Models\Auth\User\User;
use App\Models\Activity\Activity;

class TimeHistory extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_history';

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
    protected $fillable = ['user_id', 'activity_id', 'date', 'time_start', 'time_end', 'time_consumed'];

    protected $appends = ['employee', 'activity'];

    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $time_start
     * @return Carbon::Object
     */
    public function getTimeStartAttribute($time_start)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $time_start);

            // If time_start had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$time_start]; // time_start didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }

    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $time_end
     * @return Carbon::Object
     */
    public function getTimeEndAttribute($time_end)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $time_end);

            // If time_end had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$time_end]; // time_end didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }



    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $date
     * @return Carbon::Object
     */
    public function getDateAttribute($date)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $date);

            // If date had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$date]; // date didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }

    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $created_at
     * @return Carbon::Object
     */
    public function getCreatedAtAttribute($created_at)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $created_at);

            // If created_at had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$created_at]; // created_at didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }

    /**
     * Parse the created at field which can optionally have a millisecond data.
     *
     * @param  string  $created_at
     * @return Carbon::Object
     */
    public function getUpdatedAtAttribute($created_at)
    {
            // Try to remove substring after last dot(.), removes milliseconds
            $temp = explode('.', $created_at);

            // If created_at had milliseconds the array count would be 2
            if(count($temp) == 2) {
                unset($temp[count($temp) - 1]); // remove the millisecond part
            } else {
                $temp = [$created_at]; // created_at didnt have milliseconds set it back to original
            }

            return Carbon::parse(implode('.', $temp))->format('Y-m-d H:i:s');
    }

    public function employee() {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function activity() {
        return $this->belongsTo(
            Activity::class,
            'activity_id',
            'id'
        );
    }

    public function getEmployeeAttribute() {
        $employee = $this->employee()->first();
        unset($employee->created_at);
        unset($employee->updated_at);

        return $employee ? $employee->toArray() : null;
    }

    public function getActivityAttribute() {
        $activity = $this->activity()->first();
        unset($activity->created_at);
        unset($activity->updated_at);

        return $activity ? $activity->toArray() : null;
    }

    /**
     * Scope query to join project and subproject
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $wildcards
     * @param string $contact_name
     * @param string $contact_email
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJoinProjectAndSubproject($query)
    {
        $query->join('activities', 'activities.id', 'time_history.activity_id');
        $query->join('subprojects', 'subprojects.id', 'activities.subproject_id');
        $query->join('projects', 'projects.id', 'subprojects.project_id');

        return $query;
    }
}
