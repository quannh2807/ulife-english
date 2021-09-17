<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_training', function (Blueprint $table) {
            $table->id();
            $table->string('vi')->nullable();
            $table->string('en')->nullable();
            $table->string('file_vi')->nullable();
            $table->string('file_en')->nullable();
            $table->integer('type')->default(0); // config.common lesson_training_types: 1 - writing, 2 - speaking
            $table->integer('lesson_id')->default(0);
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
        Schema::dropIfExists('lesson_training');
    }
}
