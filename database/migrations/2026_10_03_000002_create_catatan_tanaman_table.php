<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_tanaman', function (Blueprint $table) {
            $table->id('id_catatan_tanaman');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_tanaman');
            $table->string('jenis_tanaman');
            $table->string('lokasi_tanaman');
            $table->text('cara_merawat');
            $table->string('foto_tanaman', 500)->nullable(); // URL Cloudinary
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnDelete();

            $table->index(['id_user', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_tanaman');
    }
};
