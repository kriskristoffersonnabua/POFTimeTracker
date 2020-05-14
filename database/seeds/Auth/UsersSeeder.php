<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('users');

        $users = [
            [
                'id'                => 1,
                'first_name' => 'Admin',
                'last_name' => 'Account',
                'email' => 'admin.laravel@labs64.com',
                'password' => bcrypt('admin'),
                'active' => true,
                'employee_no' => 32,
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'                => 2,
                'first_name' => 'Employee 1',
                'last_name' => 'Account',
                'email' => 'demo.laravel@labs641.com',
                'password' => bcrypt('demo'),
                'active' => true,
                'employee_no' => 33,
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'                => 3,
                'first_name' => 'Employee 2',
                'last_name' => 'Account',
                'email' => 'demo.laravel@labs642.com',
                'password' => bcrypt('demo'),
                'active' => true,
                'employee_no' => 35,
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'                => 4,
                'first_name' => 'Employee 3',
                'last_name' => 'Account',
                'email' => 'demo.laravel@labs643.com',
                'password' => bcrypt('demo'),
                'active' => true,
                'employee_no' => 32,
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('users')->insert($users);

        $this->enableForeignKeys();
    }
}
