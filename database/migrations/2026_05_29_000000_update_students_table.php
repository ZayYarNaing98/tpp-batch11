<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('batch_id')->references('id')->on('batches')->nullOnDelete();
            $table->date('enrolled_at')->nullable()->after('address');
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active')->after('enrolled_at');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn(['enrolled_at', 'status']);
        });
    }
};
