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
            $table->string('ytb_id')->unique();
            $table->foreignId('cate_id')->constrained('categories');
            $table->string('title');
            $table->text('description');
            $table->text('ytb_thumbnails');
            $table->string('custom_thumbnails')->nullable();
            $table->string('publish_at');
            $table->text('tags');
            $table->string('channel_id');
            $table->string('channel_title');
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
