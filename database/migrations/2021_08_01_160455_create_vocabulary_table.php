<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabularyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocabulary', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('spelling');
            $table->string('thumb')->nullable();
            $table->text('description')->nullable();
            $table->integer('is_favorite')->default(1);
            $table->integer('status')->default(1);
            $table->integer('cat_id')->default(0);
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
        Schema::dropIfExists('vocabulary');
    }
}
