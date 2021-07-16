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
            $table->foreignId('cate_id')->constrained('categories');
            $table->string('title');
            $table->string('description');
            $table->text('thumbnails');
            $table->string('custom_thumb')->nullable();
            $table->string('publish_at');
            $table->string('tags');
            $table->string('author');
            $table->string('channel_id');
            $table->string('channel_title');
            $table->integer('status')->default(1);
            $table->string('created_by');
            $table->string('updated_by');
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
