<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ActivityTbas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_tbas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('activity_id');
            
            $table->string('tba')->default('');
            $table->timestamps();
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
