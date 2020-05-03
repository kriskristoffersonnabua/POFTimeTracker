<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubprojectEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subproject_employees', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('emp_user_id');
            $table->unsignedBigInteger('subproject_id');
            $table->timestamp('assigned_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_projects');
    }
}
