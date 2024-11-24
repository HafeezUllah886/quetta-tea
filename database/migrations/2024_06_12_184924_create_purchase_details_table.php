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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchaseID')->constrained('purchases', 'id');
            $table->foreignId('rawID')->constrained('raw_materials', 'id');
            $table->float('price', 10);
            $table->float('qty');
            $table->float('amount');
            $table->date('date');
            $table->foreignId('unitID')->constrained('units', 'id');
            $table->float('unitValue');
            $table->bigInteger('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
