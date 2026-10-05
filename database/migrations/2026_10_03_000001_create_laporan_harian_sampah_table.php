<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_harian_sampah', function (Blueprint $table) {
            $table->id('id_laporan_harian_sampah');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal');
            $table->boolean('jenis_sampah'); // 0 = anorganik, 1 = organik
            $table->decimal('jumlah', 10, 2);
            $table->string('satuan');
            $table->string('tujuan_akhir');
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnDelete();

            $table->index(['tanggal', 'id_user']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian_sampah');
    }
};
