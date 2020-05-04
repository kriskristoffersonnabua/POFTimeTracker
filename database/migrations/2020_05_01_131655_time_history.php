<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TimeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_history', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('activity_id');
            
            $table->date('date')->nullable()->default(null);
            $table->timestamp('time_start')->nullable()->default(null);
            $table->timestamp('time_end')->nullable()->default(null);
            $table->float('time_consumed')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('user_id', 'foreign_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('activity_id', 'foreign_activity')
                  ->references('id')
                  ->on('activities')
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
