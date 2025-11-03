<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename tables to remove double underscores
        Schema::rename('laporan__pjs', 'laporan_pjs');
        Schema::rename('jenis__pollings', 'jenis_pollings');
        Schema::rename('laporan__praktikans', 'laporan_praktikans');
        Schema::rename('history__jagas', 'history_jagas');
        Schema::rename('jadwal__jagas', 'jadwal_jagas');
        Schema::rename('jadwal__pikets', 'jadwal_pikets');
        Schema::rename('current__praktikums', 'current_praktikums');
        // Skip jawaban__tps as requested
        Schema::rename('jawaban__tas', 'jawaban_tas');
        Schema::rename('jawaban__tks', 'jawaban_tks');
        Schema::rename('jawaban__mandiris', 'jawaban_mandiris');
        Schema::rename('jawaban__fitbs', 'jawaban_fitbs');
        Schema::rename('jawaban__jurnals', 'jawaban_jurnals');
        Schema::rename('kode__pelanggarans', 'kode_pelanggarans');
        Schema::rename('kumpul__tps', 'kumpul_tps');
        Schema::rename('soal__tps', 'soal_tps');
        Schema::rename('soal__tas', 'soal_tas');
        Schema::rename('soal__tks', 'soal_tks');
        Schema::rename('soal__mandiris', 'soal_mandiris');
        Schema::rename('temp__soaljurnals', 'temp_soaljurnals');
        Schema::rename('temp__jawabantps', 'temp_jawabantps');
        Schema::rename('soal__jurnals', 'soal_jurnals');
        Schema::rename('soal__fitbs', 'soal_fitbs');
        Schema::rename('feedback__aslabs', 'feedback_aslabs');
        Schema::rename('foto__asistens', 'foto_asistens');
        Schema::rename('history__izins', 'history_izins');
        Schema::rename('history__pikets', 'history_pikets');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the renames
        Schema::rename('laporan_pjs', 'laporan__pjs');
        Schema::rename('jenis_pollings', 'jenis__pollings');
        Schema::rename('laporan_praktikans', 'laporan__praktikans');
        Schema::rename('history_jagas', 'history__jagas');
        Schema::rename('jadwal_jagas', 'jadwal__jagas');
        Schema::rename('jadwal_pikets', 'jadwal__pikets');
        Schema::rename('current_praktikums', 'current__praktikums');
        // Skip jawaban__tps as requested
        Schema::rename('jawaban_tas', 'jawaban__tas');
        Schema::rename('jawaban_tks', 'jawaban__tks');
        Schema::rename('jawaban_mandiris', 'jawaban__mandiris');
        Schema::rename('jawaban_fitbs', 'jawaban__fitbs');
        Schema::rename('jawaban_jurnals', 'jawaban__jurnals');
        Schema::rename('kode_pelanggarans', 'kode__pelanggarans');
        Schema::rename('kumpul_tps', 'kumpul__tps');
        Schema::rename('soal_tps', 'soal__tps');
        Schema::rename('soal_tas', 'soal__tas');
        Schema::rename('soal_tks', 'soal__tks');
        Schema::rename('soal_mandiris', 'soal__mandiris');
        Schema::rename('temp_soaljurnals', 'temp__soaljurnals');
        Schema::rename('temp_jawabantps', 'temp__jawabantps');
        Schema::rename('soal_jurnals', 'soal__jurnals');
        Schema::rename('soal_fitbs', 'soal__fitbs');
        Schema::rename('feedback_aslabs', 'feedback__aslabs');
        Schema::rename('foto_asistens', 'foto__asistens');
        Schema::rename('history_izins', 'history__izins');
        Schema::rename('history_pikets', 'history__pikets');
    }
};
