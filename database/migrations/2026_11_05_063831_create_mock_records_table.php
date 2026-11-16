<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mock_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_table_id')
                ->constrained('api_tables')
                ->onDelete('cascade');
            $table->json('data');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_records');
    }
};
