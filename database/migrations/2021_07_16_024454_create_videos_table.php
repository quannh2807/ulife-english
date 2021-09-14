<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('ytb_id');
            $table->integer('topic_id')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('ytb_thumbnails')->nullable();
            $table->string('custom_thumbnails')->nullable();
            $table->string('publish_at')->nullable();
            $table->text('tags')->nullable();
            $table->string('channel_id')->nullable();
            $table->string('channel_title')->nullable();
            $table->integer('type')->default(1);
            $table->integer('position')->nullable()->default(0);
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
        Schema::dropIfExists('videos');
    }
}
