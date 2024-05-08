<?php

use App\Enum\NotificationEnum;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('person');
            $table->string('telephone')->nullable();
            $table->string('phone')->nullable();
            $table->char('genre', 1)->nullable()->default('O');
            $table->string('birthday');
            $table->string('avatar')->nullable()->default('default-avatar.png');
            $table->enum('notifications',NotificationEnum::forSelectName())->default(NotificationEnum::ACCEPTED);
            $table->string('type_of_investor')->nullable();

            // $table->foreignId('apartment_id')->nullable()->constrained();
            $table->string('address_street')->nullable();
            $table->integer('address_number')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_district')->nullable();
            $table->string('address_zip_code')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_country')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
