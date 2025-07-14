<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('kode_pelanggan', 255)->nullable();
            $table->string('nama_pelanggan', 255)->nullable();
            $table->string('domisili', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('jenis_kelamin', 255)->nullable();

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
        Schema::dropIfExists('pelanggan');
    }
}
