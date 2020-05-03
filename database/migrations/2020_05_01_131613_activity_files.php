<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ActivityFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('activity_files', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('activity_id');
            
            $table->binary('file')->nullable()->default(null);
            $table->string('file_link')->default('');
            $table->timestamp('date_added');
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
        Schema::dropIfExists('activity_files');
    }
}
