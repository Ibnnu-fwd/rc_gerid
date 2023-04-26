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
        Schema::table('import_requests', function (Blueprint $table) {
            $table->longText('file_code')->nullable()->after('filename');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('import_requests', function (Blueprint $table) {
            $table->dropColumn('file_code');
        });
    }
};
