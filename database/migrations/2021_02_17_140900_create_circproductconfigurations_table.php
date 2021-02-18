<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCircProductConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circ_product_configurations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->float('depth');
            $table->float('db_1');
            $table->float('db_2');
            $table->float('db_5');
            $table->float('db_10');
            $table->float('diameter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circ_product_condigurations');
    }
}
