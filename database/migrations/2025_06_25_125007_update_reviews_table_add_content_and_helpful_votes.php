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
        Schema::table('reviews', function (Blueprint $table) {
            // Rename text column to content
            $table->renameColumn('text', 'content');
            
            // Add helpful_votes column
            $table->integer('helpful_votes')->default(0)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Remove helpful_votes column
            $table->dropColumn('helpful_votes');
            
            // Rename content back to text
            $table->renameColumn('content', 'text');
        });
    }
};
