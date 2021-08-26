<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('deviceFamily')->nullable();
            $table->string('deviceModel')->nullable();
            $table->boolean('bot')->default(false);

            $table->foreignId('shortlink_id')->references('id')->on('shortlinks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
