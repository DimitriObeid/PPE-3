<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournitures', function (Blueprint $table) {
            $table->id();
            $table->string('nomFournitures', 255);
            $table->string('nomPhoto', 255);
            $table->string('descriptionFournitures', 255);
            $table->integer('quantiteDisponible');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fournitures');
    }
}
