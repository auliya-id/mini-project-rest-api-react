<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_item', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->unsignedBigInteger('id_penjualan')->nullable();
            $table->unsignedBigInteger('id_barang')->nullable();
            $table->integer('qty')->nullable();
            
            $table->foreign('id_penjualan')->references('id')->on('penjualan');
            $table->foreign('id_barang')->references('id')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_item');
    }
}
