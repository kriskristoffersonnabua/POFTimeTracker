<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeHistorySeeder extends Seeder
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
        $this->truncate('time_history');
        
        $data = [
            [
                'user_id'             =>  3,
                'activity_id'         =>  1,
                'date'                =>  'Sample title',
                'time_start'          =>  '2020-03-05 10:11:11',
                'time_end'            =>  '2020-03-05 11:11:11',
                'time_consumed'       =>  1,
                'date'                =>  Carbon::now()
            ],
            [
                'user_id'             =>  4,
                'activity_id'         =>  1,
                'date'                =>  'Sample title',
                'time_start'          =>  '2020-04-05 10:11:11',
                'time_end'            =>  '2020-04-05 11:11:11',
                'time_consumed'       =>  1,
                'date'                =>  Carbon::now()
            ],
        ];

        DB::table('time_history')->insert($data);
        $this->enableForeignKeys();
    }
}