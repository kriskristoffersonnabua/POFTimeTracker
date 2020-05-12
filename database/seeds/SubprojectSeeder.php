<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubprojectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subprojects_employees')->insert([
            [
                'id'              => 1,
                'emp_user_id'     => 3,
                'subproject_id'   => 'Alabama',
                'assigned_date'   => 'alabama',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now()
            ]
        ]);
    }
}
