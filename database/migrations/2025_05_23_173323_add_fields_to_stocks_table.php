<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('type')->default('in')->after('quantity');
            $table->string('reference')->nullable()->after('type');
            $table->text('notes')->nullable()->after('reference');
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['type', 'reference', 'notes']);
        });
    }
}; 