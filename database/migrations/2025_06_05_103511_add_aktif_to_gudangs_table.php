<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAktifToGudangsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gudangs', function (Blueprint $table) {
            if (!Schema::hasColumn('gudangs', 'aktif')) {
                $table->boolean('aktif')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gudangs', function (Blueprint $table) {
            if (Schema::hasColumn('gudangs', 'aktif')) {
                $table->dropColumn('aktif');
            }
        });
    }
}
