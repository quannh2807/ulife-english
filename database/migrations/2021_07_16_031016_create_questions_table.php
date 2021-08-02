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
            $table->string('selected_answer')->default(0);
            $table->integer('is_favorite')->default(0);
            $table->integer('status')->default(1);
            $table->integer('lang_id')->default(1);
            $table->integer('video_id')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->integer('type')->nullable();
            $table->foreignId('topics_id')->default(0);
            $table->foreignId('cate_id')->default(0);
            $table->foreignId('level_id')->default(0);
            $table->integer('level_type')->default(0); // config common level 1, 2, 3, 4
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
