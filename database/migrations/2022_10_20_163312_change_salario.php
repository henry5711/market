<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSalario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('register_user', function (Blueprint $table) {
            $table->dropColumn('salario');
        });

        Schema::table('register_user', function (Blueprint $table) {
            $table->enum('salario',['Menor a 100$',
            '100-299$',
            '300-499$',
            '500-1500$',
            'Mayor a 1500$'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_user', function (Blueprint $table) {
            //
        });
    }
}
