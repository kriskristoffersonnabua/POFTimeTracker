<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $table->string('project_no')->nullable()->default(null);
        $table->string('name')->nullable()->default(null);
        $table->string('description')->nullable()->default(null);
        DB::table('projects')->insert([
            [
                'id'              => 1,
                'project_no'      => 1,
                'name'            => 'Test project',
                'description'     => 'Test project description',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now()
            ]
        ]);
    }
}
