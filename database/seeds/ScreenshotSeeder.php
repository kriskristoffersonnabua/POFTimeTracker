<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreenshotSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('screenshots');
        
        $data = [
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot1.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot2.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot4.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot4.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot5.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot6.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot7.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot8.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot9.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ],
            [
                'time_history_id'         =>  1,
                'screenshot_filename'     =>  'Screenshot3.jpg'
            ]
        ];

        DB::table('screenshots')->insert($data);
        $this->enableForeignKeys();
    }
}