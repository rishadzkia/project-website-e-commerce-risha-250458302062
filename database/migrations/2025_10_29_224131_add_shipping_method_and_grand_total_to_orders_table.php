<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan hanya kolom yang belum ada
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->nullable()->after('currency');
            }

            if (!Schema::hasColumn('orders', 'grand_total')) {
                $table->decimal('grand_total', 15, 2)->default(0)->after('shipping_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cek dulu biar nggak error waktu rollback
            if (Schema::hasColumn('orders', 'shipping_method')) {
                $table->dropColumn('shipping_method');
            }

            if (Schema::hasColumn('orders', 'grand_total')) {
                $table->dropColumn('grand_total');
            }
        });
    }
};
