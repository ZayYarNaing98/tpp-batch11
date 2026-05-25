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
        Schema::table('batches', function (Blueprint $table) {
            $table->date('start_date')->after('description')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'complete'])->after('end_date')->default('upcoming');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['status', 'end_date','start_date']);
        });
    }
};
