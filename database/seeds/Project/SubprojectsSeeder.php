<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubprojectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subprojects')->insert([
            [
                'id'                => 1,
                'project_id'        => 3,
                'subproject_no'     => '0000-0001',
                'subproject_name'   => 'Subproject Name',
                'description'       => 'Sample Description',
                'user_id'           => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ],
            [
                'id'                => 2,
                'project_id'        => 4,
                'subproject_no'     => '0000-0002',
                'subproject_name'   => 'Subproject Name',
                'description'       => 'Sample Description',
                'user_id'           => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ],
            [
                'id'                => 3,
                'project_id'        => 5,
                'subproject_no'     => '0000-0003',
                'subproject_name'   => 'Subproject Name',
                'description'       => 'Sample Description',
                'user_id'           => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]
        ]);
    }
}
