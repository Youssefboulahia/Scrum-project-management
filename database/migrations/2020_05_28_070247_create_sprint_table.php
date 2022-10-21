<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSprintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprint', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('time');
            $table->string('phase');
            $table->integer('project_id');
            $table->timestamp('startDate')->nullable();
            $table->timestamp('endDate')->nullable();
            $table->integer('dayDiff')->nullable();
            $table->integer('hourDiff')->nullable();
            $table->integer('minuteDiff')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sprint');
    }
}
