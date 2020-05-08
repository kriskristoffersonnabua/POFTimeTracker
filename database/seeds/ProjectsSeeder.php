<?php

use Carbon\Carbon;
use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
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
        $this->truncate('projects');
        DB::table('projects')->insert([
            [
                'id'              => 11,
                'project_no'      => 11,
                'name'            => 'Test project',
                'description'     => 'Test project description',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now()
            ]
        ]);

        $this->enableForeignKeys();
    }
}
