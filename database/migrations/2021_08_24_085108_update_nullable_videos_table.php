<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->text('ytb_thumbnails')->nullable()->change();
            $table->string('custom_thumbnails')->nullable()->change();
            $table->string('publish_at')->nullable()->change();
            $table->text('tags')->nullable()->change();
            $table->string('channel_id')->nullable()->change();
            $table->string('channel_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            //
        });
    }
}
