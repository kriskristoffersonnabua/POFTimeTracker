<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ActivityComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_comments', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            
            $table->string('comment')->default('');
            $table->timestamp('date_added');
            $table->timestamps();

            $table->foreign('activity_id', 'foreign_activity')
                  ->references('id')
                  ->on('activities')
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
        //
    }
}
