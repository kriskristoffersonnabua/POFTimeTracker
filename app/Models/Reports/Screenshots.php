<?php

namespace App\Models\Reports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

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
    protected $fillable = ['screenshot', 'screenshot_filename', 'date_added', 'time_history_id'];

    protected $appends = ['screenshot_url'];

    /**
     * Get the url of the screenshot_filename saved in the S3
     *
     * @param  string  $created_at
     * @return url
     */
    public function getScreenshotUrlAttribute()
    {
        return Storage::disk('s3')->url($this->screenshot_filename);
    }
}
