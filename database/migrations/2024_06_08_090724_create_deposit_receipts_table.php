<?php

use App\Enum\StatusDeposit;
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
        Schema::create('deposit_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_wallet_id')->constrained()->onDelete('cascade');
            $table->boolean('investment')->default(false);
            $table->decimal('value');
            $table->string('image')->nullable();
            $table->enum('status', StatusDeposit::forSelectName())->default(StatusDeposit::Initial->value);
            // numero do identificado do pagamento
            $table->string('transaction_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_receipts');
    }
};
