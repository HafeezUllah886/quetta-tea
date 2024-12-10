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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waiterID')->constrained('users', 'id');
            $table->foreignId('customerID')->constrained('users', 'id');
            $table->foreignId('tableID')->constrained('tables', 'id');
            $table->date('date');
            $table->string('type');
            $table->string('status')->default('Active');
            $table->bigInteger('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
