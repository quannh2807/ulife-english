<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('answer_1');
            $table->string('answer_2');
            $table->string('answer_3');
            $table->string('answer_4');
            $table->string('answer_correct');
            $table->string('selected_answer');
            $table->integer('is_favorite')->default(0);
            $table->integer('status')->default(1);
            $table->integer('lang_id')->default(1);
            $table->integer('video_id');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->foreignId('level_id')->constrained('levels');;
            $table->integer('type'); // config common level 1, 2, 3, 4
            $table->foreignId('sub_id')->constrained('video_subtitles');
            $table->foreignId('cate_id')->constrained('categories');
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
        Schema::dropIfExists('questions');
    }
}
