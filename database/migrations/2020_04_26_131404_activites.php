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
            $table->unsignedBigInteger('employee_user_id')->default(0);

            $table->string('title')->nullable()->default('');
            $table->string('description')->nullable()->default('');
            $table->string('acceptance_criteria')->nullable()->default('');
            $table->float('estimated_hours',8,2)->nullable()->default(0);
            $table->enum('status',['to_be_done','ongoing','done','ready_for_testing'])->default('to_be_done');
            $table->timestamps();

            $table->foreign('subproject_id', 'foreign_subproject')
                  ->references('id')
                  ->on('subprojects')
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
