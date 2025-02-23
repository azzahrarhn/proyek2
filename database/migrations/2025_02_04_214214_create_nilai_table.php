<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Kolom nama siswa
            // Kolom asesmen formatif
            $table->integer('formatif_tp1')->default(0);
            $table->integer('formatif_tp2')->default(0);
            $table->integer('formatif_tp3')->default(0);
            $table->integer('formatif_tp4')->default(0);
            $table->integer('formatif_tp5')->default(0);
            $table->integer('formatif_tp6')->default(0);
            $table->integer('formatif_tp7')->default(0);
            $table->integer('formatif_tp8')->default(0);
            $table->integer('formatif_tp9')->default(0);
            $table->integer('formatif_tp10')->default(0);
            // Kolom asesmen sumatif akhir lingkup materi
            $table->integer('sumatif_lingkup_tp1')->default(0);
            $table->integer('sumatif_lingkup_tp2')->default(0);
            $table->integer('sumatif_lingkup_tp3')->default(0);
            $table->integer('sumatif_lingkup_tp4')->default(0);
            $table->integer('sumatif_lingkup_tp5')->default(0);
            $table->integer('sumatif_lingkup_tp6')->default(0);
            $table->integer('sumatif_lingkup_tp7')->default(0);
            $table->integer('sumatif_lingkup_tp8')->default(0);
            $table->integer('sumatif_lingkup_tp9')->default(0);
            $table->integer('sumatif_lingkup_tp10')->default(0);
            // Kolom asesmen sumatif akhir semester
            $table->integer('sumatif_akhir_tp1')->default(0);
            $table->integer('sumatif_akhir_tp2')->default(0);
            $table->integer('sumatif_akhir_tp3')->default(0);
            $table->integer('sumatif_akhir_tp4')->default(0);
            $table->integer('sumatif_akhir_tp5')->default(0);
            $table->integer('sumatif_akhir_tp6')->default(0);
            $table->integer('sumatif_akhir_tp7')->default(0);
            $table->integer('sumatif_akhir_tp8')->default(0);
            $table->integer('sumatif_akhir_tp9')->default(0);
            $table->integer('sumatif_akhir_tp10')->default(0);
            // Kolom nilai rapor
            $table->integer('nilai_rapor')->default(0);

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
        Schema::dropIfExists('nilai');
    }
}
