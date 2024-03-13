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
        Schema::create('tbUser', function (Blueprint $table) {
            $table->uuid('ID')->primary();
            $table->string('USERNAME',10);
            $table->string('NAMA',20);
            $table->string('PASSWORD');
            $table->char('ID_GUDANG',12);

            $table->dateTime('TGLENTRY');
            $table->string('USERENTRY',10);
            $table->foreign('USERENTRY')->references('id')->on('user')->onDelete('');
            $table->dateTime('TGLEDIT');
            $table->string('USEREDIT',10);
            $table->foreign('USEREDIT')->references('id')->on('user')->onDelete('');

            $table->string('EMAIL');
            $table->string('NOMOR_HP');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbUser');
    }
};
