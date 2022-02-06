<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->string("id_question");
            $table->string("categorie_1");
            $table->string("categorie_2");
            $table->string("categorie_3");
            $table->string("categorie_4");
            $table->string("reponse");
            $table->unsignedBigInteger('diagnostic_id');
            $table->string('slug');

            $table->foreign('diagnostic_id')->references('id')->on('diagnostics')->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('reponses');
    }
}
