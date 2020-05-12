<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersSeeder::class);
         $this->call(RolesSeeder::class);
         $this->call(UsersRolesSeeder::class);

         $this->call(ProjectsSeeder::class);
         $this->call(SubprojectsSeeder::class);
         
         $this->call(ActivitiesSeeder::class);
         $this->call(ActivityFilesSeeder::class);
        
         $this->call(TimeHistorySeeder::class);
    }
}
