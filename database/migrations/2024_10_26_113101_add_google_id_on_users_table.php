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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable(); // Add the new column
            $table->string('password')->nullable()->change(); 
            $table->string('address')->nullable()->change(); 
            $table->string('phone')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id'); // Drop the column if rolling back
            $table->string('password')->nullable(false)->change();
            $table->string('address')->nullable(false)->change(); 
            $table->string('phone')->nullable(false)->change(); 
        });
    }
};
