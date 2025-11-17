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
        Schema::create("performance_data", function (Blueprint $table) {
            $table->id();
            $table->foreignId('heatpump_id')->constrained('heatpump')->onDelete('cascade');
            $table->double("outside_temp");
            $table->double("inside_temp");
            $table->double("supply_line_temp");
            $table->double("return_line_temp");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
