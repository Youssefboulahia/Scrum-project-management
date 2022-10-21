<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichier', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('message');
            $table->string('fichier');
            $table->string('format');
            $table->integer('sprint_id');
            $table->integer('importeur_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichier');
    }
}
