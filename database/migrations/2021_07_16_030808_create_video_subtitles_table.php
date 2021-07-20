<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoSubtitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_subtitles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained('videos');
            $table->foreignId('lang_id')->constrained('languages');
            $table->string('name_release');
            $table->string('name_draft')->nullable();
            $table->integer('time_start');
            $table->integer('time_end');
            $table->integer('status')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('video_subtitles');
    }
}
