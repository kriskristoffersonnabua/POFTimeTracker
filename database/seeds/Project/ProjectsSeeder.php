<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            [
                'id'                => 3,
                'project_no'        => 3,
                'name'              => 'Subproject Name',
                'description'       => 'Sample Description',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ],
            [
                'id'                => 4,
                'project_no'        => 4,
                'name'              => 'Subproject Name 4',
                'description'       => 'Sample Description',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ],
            [
                'id'                => 5,
                'project_no'        => 5,
                'name'              => 'Subproject Name 5',
                'description'       => 'Sample Description',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]
        ]);
    }
}
