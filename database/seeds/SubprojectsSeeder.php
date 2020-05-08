<?php

use Carbon\Carbon;
use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubprojectsSeeder extends Seeder
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
        $this->truncate('subprojects');

        DB::table('subprojects')->insert([ 
            [
                'project_id'      => 11,
                'user_id'         => 1,
                'subproject_no'   => 1,
                'subproject_name' => 'Sample subproject',
                'description'     => 'Seeded description',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now()
            ],
            [
                'project_id'      => 11,
                'user_id'         => 1,
                'subproject_no'   => 2,
                'subproject_name' => 'Sample subproject3',
                'description'     => 'Seeded description3',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now()
            ]
        ]);
        $this->enableForeignKeys();
    }
}