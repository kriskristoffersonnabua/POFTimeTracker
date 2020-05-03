<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class Screenshots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('screenshots', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('time_history_id');
                        
            $table->binary('screenshot')->nullable()->default(null);
            $table->timestamp('date_added')->nullable()->default(null);
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
        //
    }
}
