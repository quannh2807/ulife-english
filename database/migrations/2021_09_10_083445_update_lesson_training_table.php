<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLessonTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson_training', function (Blueprint $table) {
            $table->string('file_vi')->nullable();
            $table->string('file_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_training', function (Blueprint $table) {
            $table->string('file_vi')->nullable();
            $table->string('file_en')->nullable();
        });
    }
}
