<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->timestamps();
            $table->id();
            $table->softDeletes();

            //Target
            $table->string('type');

            //LinkTarget & LinklistItem
            $table->text('url')->nullable();

            //LinklistTarget
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();

            //LinklistItem
            $table->string('name')->nullable();
            $table->string('color')->default('#0000ff')->nullable();
            $table->foreignId('linklist_id')->nullable();

            //CodeTarget
            $table->longText('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('targets');
    }
}