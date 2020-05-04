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

            $table->foreign('subproject_id', 'foreign_subproject')
                  ->references('id')
                  ->on('subprojects')
                  ->onDelete('cascade');

            $table->foreign('emp_user_id', 'foreign_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
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
