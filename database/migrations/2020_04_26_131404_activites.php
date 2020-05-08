<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class Activites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('subproject_id');
            $table->string('activity_no')->nullable()->default('');
            $table->unsignedBigInteger('employee_user_id');

            $table->string('title')->nullable()->default('');
            $table->string('description')->nullable()->default('');
            $table->string('acceptance_criteria')->nullable()->default('');
            $table->float('estimated_hours',8,2)->nullable()->default(0);
            $table->timestamps();

            $table->foreign('subproject_id', 'foreign_subproject')
                  ->references('id')
                  ->on('subprojects')
                  ->onDelete('cascade');

            $table->foreign('employee_user_id', 'foreign_user')
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
        Schema::dropIfExists('activites');
    }
}
