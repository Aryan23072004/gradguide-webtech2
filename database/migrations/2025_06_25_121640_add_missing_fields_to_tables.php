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
        // Add missing fields to courses table
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'department')) {
                $table->string('department')->nullable();
            }
            if (!Schema::hasColumn('courses', 'professor_id')) {
                $table->foreignId('professor_id')->nullable()->constrained()->onDelete('set null');
            }
        });

        // Add missing fields to professors table
        Schema::table('professors', function (Blueprint $table) {
            if (!Schema::hasColumn('professors', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('professors', 'department')) {
                $table->string('department');
            }
        });

        // Add missing fields to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        // Add missing fields to reports table
        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['professor_id']);
            $table->dropColumn(['department', 'professor_id']);
        });

        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn(['name', 'department']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
