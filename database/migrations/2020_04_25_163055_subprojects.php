<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subprojects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subprojects', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');

            $table->string('subproject_no')->nullable()->default(null);
            $table->string('subproject_name')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('project_id', 'foreign_project')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');

            $table->foreign('user_id', 'foreign_user')
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
        Schema::dropIfExists('tasks');
    }
}
