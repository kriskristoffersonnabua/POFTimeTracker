<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('activities');

        $activities = [
            [
                'id'                        =>  1,
                'subproject_id'             =>  2,
                'activity_no'               =>  7,
                'title'                     =>  'Sample title',
                'description'               =>  'Sample description',
                'acceptance_criteria'       =>  'Sample acceptance criteria',
                'employee_user_id'          =>  1,
                'estimated_hours'           =>  8

            ],
            [
                'id'                        =>  2,
                'subproject_id'             =>  3,
                'activity_no'               =>  8,
                'title'                     =>  'Sample title',
                'description'               =>  'Sample description',
                'acceptance_criteria'       =>  'Sample acceptance criteria',
                'employee_user_id'          =>  2,
                'estimated_hours'           =>  6
            ]
        ];

        DB::table('activities')->insert($activities);
    }
}