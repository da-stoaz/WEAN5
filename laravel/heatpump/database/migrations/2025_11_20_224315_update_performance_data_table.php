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
        Schema::table('performance_data', function (Blueprint $table) {

            $table->timestamp('recorded_at')->nullable()->after('return_line_temp');

            $table->renameColumn("supply_line_temp", "supply_temp");
            $table->renameColumn("return_line_temp", "return_temp");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_data', function (Blueprint $table) {
            $table->renameColumn('supply_temp', 'supply_line_temp');
            $table->renameColumn('return_temp', 'return_line_temp');
            $table->dropColumn('recorded_at');
        });
    }
};
