<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityFilesSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->disableForeignKeys();
        $this->truncate('activity_files');

        $users = [
            [
                'activity_id'   =>  1,
                'file'          =>  'samplefile',
                'file_link'     =>  'samplelink',
                'date_added'    =>  date("Y-m-d H:i:s")
            ],
            [
                'activity_id'   =>  2,
                'file'          =>  'samplefile',
                'file_link'     =>  'samplelink',
                'date_added'    =>  date("Y-m-d H:i:s")
            ]
        ];

        DB::table('activity_files')->insert($users);

        //$this->enableForeignKeys();
    }
}
