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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kondisi');
            $table->string('keterangan')->nullable();
            $table->bigInteger('jumlah');
            $table->foreignId('jenis_id')->constrained('jenis')->onDelete('cascade');
            $table->date('tanggal_register');
            $table->foreignId('ruang_id')->constrained('ruangs')->onDelete('cascade');
            $table->string('kode_inventaris');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
