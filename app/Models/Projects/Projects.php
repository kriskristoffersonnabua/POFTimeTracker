<?php

namespace App\Models\Projects;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

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
    protected $fillable = ['project_no', 'name', 'description'];

    public function subprojects() {

        return $this->hasMany(
            SubProjects::class,
            'project_id',
            'id'
        );
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
}
