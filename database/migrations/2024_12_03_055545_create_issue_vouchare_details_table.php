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
        Schema::create('issue_vouchare_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucharID')->constrained('issue_vouchares', 'id');
            $table->foreignId('rawID')->constrained('raw_materials', 'id');
            $table->foreignId('unitID')->constrained('units', 'id');
            $table->float('unit_value');
            $table->float('qty');
            $table->date('date');
            $table->bigInteger('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_vouchare_details');
    }
};
