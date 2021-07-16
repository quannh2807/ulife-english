<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('acc_name');
            $table->string('full_name');
            $table->string('password');
            $table->string('email');
            $table->timestamp('email_verified_at');
            $table->string('birthday');
            $table->string('phone');
            $table->string('mobile');
            $table->string('avatar')->nullable();
            $table->string('address');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
