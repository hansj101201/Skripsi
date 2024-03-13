<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->uuid('ID')->primary();
            $table->char('ID_BARANG',12);
            $table->string('NAMA',40);
            $table->string('SATUAN',45)->nullable;
            $table->integer('ACTIVE')->default(0);
            $table->dateTime('TGLENTRY')->nullable;
            $table->string('USERENTRY',10)->nullable;

            $table->foreign('USERENTRY')->references('id')->on('tbUser')->onDelete('');
            $table->dateTime('TGLEDIT')->nullable;
            $table->string('USEREDIT',10)->nullable;
            $table->foreign('USEREDIT')->references('id')->on('tbUser')->onDelete('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('barang');
    }
};
