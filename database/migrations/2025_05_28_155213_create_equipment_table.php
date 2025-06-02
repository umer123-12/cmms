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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('manufacturer')->nullable();
            $table->string('serial_number')->unique();
            $table->date('purchase_date')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Operational'); // or Broken, Retired, etc.
            $table->date('warranty_expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
