<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer("role")->nullable()->default(0);
            $table->boolean('is_admin')->default(false);
            $table->string("avatar")->nullable();
            $table->integer("story_id")->unsigned()->nullable();
            $table->string('register_ip',50)->nullable();
            $table->string('login_ip',50)->nullable();
            $table->integer('status')->default('0');
            $table->integer('level')->default('0');
            $table->string('code', 10)->nullable();
            $table->string('referent_code', 10)->nullable();
            $table->string('phone_number',20)->nullable();
            $table->integer('verify_otp')->default(0);
            $table->string('access_token',500)->nullable();
            $table->string('banned_reason')->nullable();
            $table->string('time_banned')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->softDeletes('deleted_at', 0)->nullable();
            $table->rememberToken();
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
};
