<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('act_out');
        Schema::create('act_out', function (Blueprint $table) {
            $table->id();
            $table->integer('lesson_id')->default(0);
            $table->integer('characterId')->default(0);
            $table->string('time_start');
            $table->string('time_end');
            $table->text('vi')->nullable();
            $table->text('en')->nullable();
            $table->text('ko')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('act_out');
    }
}
