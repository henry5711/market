<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RegisterUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_user', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->nullable();
            $table->string('name');
            $table->string('email');
            $table->date('fec_nacimiento')->nullable();
            $table->enum('genero',['M','F','OTRO'])->nullable();
            $table->string('instagram')->nullable();
            $table->string('nacionality')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('play')->default(true);
            $table->integer('number')->nullable();
            $table->float('salario')->nullable();
            $table->string('pais')->nullable();
            $table->string('estado')->nullable();
            $table->string('city')->nullable();
            $table->boolean('victory')->default(false);
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
        Schema::dropIfExists('register_user');
    }
}
