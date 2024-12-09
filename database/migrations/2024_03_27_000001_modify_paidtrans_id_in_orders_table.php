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
        Schema::table('orders', function (Blueprint $table) {
            // First drop the existing column
            $table->dropColumn('paidtrans_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            // Then recreate it as string
            $table->string('paidtrans_id', 50)->nullable()->after('suptrans_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // First drop the string column
            $table->dropColumn('paidtrans_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            // Then recreate it as unsignedBigInteger
            $table->unsignedBigInteger('paidtrans_id')->nullable()->after('suptrans_id');
        });
    }
};
