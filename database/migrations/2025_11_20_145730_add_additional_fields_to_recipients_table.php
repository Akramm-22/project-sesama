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
        Schema::table('recipients', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('Ibu_name');
            $table->string('region')->nullable()->after('address');
            $table->string('reference_source')->nullable()->after('region');

            $table->boolean('has_circumcision')->default(false)->after('registrasi');
            $table->boolean('has_received_gift')->default(false)->after('has_circumcision');
            $table->boolean('has_photo_booth')->default(false)->after('has_received_gift');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipients', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_number',
                'region',
                'reference_source',

                'has_circumcision',
                'has_received_gift',
                'has_photo_booth',
            ]);
        });
    }
};
