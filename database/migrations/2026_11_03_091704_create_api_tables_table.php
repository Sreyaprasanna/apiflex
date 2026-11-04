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
        Schema::create('api_tables', function (Blueprint $table) {
          $table->id();
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->string('name');         // e.g. "users", "products"
        $table->string('slug');         // url-safe version e.g. "users"
         $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_tables');
    }
};
