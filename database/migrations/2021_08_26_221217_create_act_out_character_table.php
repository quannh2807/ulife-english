<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActOutCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('act_out_character', function (Blueprint $table) {
            $table->id();
            $table->integer('characterId')->default(0);
            $table->string('characterName')->nullable();
            $table->string('image')->nullable();
            $table->integer('lesson_id')->default(0);
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
        Schema::dropIfExists('act_out_character');
    }
}
