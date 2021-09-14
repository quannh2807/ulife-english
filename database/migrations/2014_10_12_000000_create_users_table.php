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
            $table->string('acc_name')->unique();
            $table->string('full_name');
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at');
            $table->string('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
