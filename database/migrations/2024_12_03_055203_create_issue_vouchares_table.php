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
        Schema::create('issue_vouchares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitchenID')->constrained('users', 'id');
            $table->foreignId('chefID')->constrained('users', 'id');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->bigInteger('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_vouchares');
    }
};
