<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekskuls', function (Blueprint $table) {
            if (! Schema::hasColumn('ekskuls', 'pembina')) {
                $table->string('pembina')->nullable()->after('ketua');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ekskuls', function (Blueprint $table) {
            if (Schema::hasColumn('ekskuls', 'pembina')) {
                $table->dropColumn('pembina');
            }
        });
    }
};