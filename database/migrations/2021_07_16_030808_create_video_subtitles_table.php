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
            $table->string('time_start');
            $table->string('time_end');
            $table->text('vi')->nullable();
            $table->text('en')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
