<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRectProductConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rect_product_configurations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->float('depth');
            $table->float('db_1');
            $table->float('db_2');
            $table->float('db_5');
            $table->float('db_10');
            $table->float('width');
            $table->float('height');
            $table->float('thickness');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rectproductconfiguration');
    }
}
