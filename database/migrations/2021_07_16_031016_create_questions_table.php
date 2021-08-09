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
            $table->string('answer_1')->nullable();
            $table->string('answer_2')->nullable();
            $table->string('answer_3')->nullable();
            $table->string('answer_4')->nullable();
            $table->string('answer_correct')->nullable();
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->string('selected_answer')->default(0);
            $table->integer('is_favorite')->default(0);
            $table->integer('lang_id')->default(1);
            $table->integer('video_id')->nullable();
            $table->foreignId('topics_id')->default(0);
            $table->foreignId('cate_id')->default(0);
            $table->foreignId('level_id')->default(0);
            $table->integer('level_type')->default(0); // config common level 1, 2, 3, 4
            $table->integer('type')->default(0); // config common question_type
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
        Schema::dropIfExists('questions');
    }
}
