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
        Schema::table('deposit_receipts', function (Blueprint $table) {
            // Altera a coluna 'existing_column' para ser nullable
            $table->string('transaction_id')->nullable()->change();
            $table->string('transaction_code')->required();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposit_receipts', function (Blueprint $table) {
            $table->string('transaction_id')->required()->change();

            $table->dropColumn('transaction_code');
        });
    }
};
