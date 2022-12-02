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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('another_name')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('category_id');
            $table->string('author_id');
            $table->string('comment_id')->nullable();
            $table->integer('rate')->default(0);
            $table->string('status')->nullable();
            $table->string('vew_follow')->default(0);
            $table->string('vew_story')->default(0);
            $table->string('vew_like')->default(0);
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
        Schema::dropIfExists('stories');
    }
};
