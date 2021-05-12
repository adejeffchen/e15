<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependencies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('release_id')->unsigned();
            $table->bigInteger('dependent_release_id')->unsigned();

            # Make foreign keys
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');
            $table->foreign('dependent_release_id')->references('id')->on('releases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dependencies');
    }
}