<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataPelajaranTable extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel mata_pelajaran.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key
            $table->string('name')->unique(); // Nama mata pelajaran yang unik
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Membalikkan migrasi untuk menghapus tabel mata_pelajaran.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mata_pelajaran'); // Menghapus tabel mata_pelajaran
    }
}
