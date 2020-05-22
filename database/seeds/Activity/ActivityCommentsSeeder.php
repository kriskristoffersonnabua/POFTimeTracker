<?php

use Database\Traits\TruncateTable;
use Database\Traits\DisableForeignKeys;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityCommentsSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        $this->truncate('activity_comments');

        $activity_comments = [
            [
                'activity_id'   => 1,
                'user_id'       => 1,
                'comment'       => 'A new comment',
                'date_added'    => date("Y-m-d H:i:s")
            ],
            [
                'activity_id'   => 1,
                'user_id'       => 1,
                'comment'       => 'Another comment',
                'date_added'    => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('activity_comments')->insert($activity_comments);
    }
}