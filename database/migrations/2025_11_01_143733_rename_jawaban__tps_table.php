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
        if (Schema::hasTable('jawaban__tps') && ! Schema::hasTable('jawaban_tps')) {
            Schema::rename('jawaban__tps', 'jawaban_tps');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('jawaban_tps') && ! Schema::hasTable('jawaban__tps')) {
            Schema::rename('jawaban_tps', 'jawaban__tps');
        }
    }
};
