<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('recipients', function (Blueprint $table) {
            if (!Schema::hasColumn('recipients', 'age')) {
                $table->unsignedTinyInteger('age')->nullable()->after('birth_date');
            }
        });

        DB::table('recipients')
            ->whereNotNull('birth_date')
            ->orderBy('id')
            ->chunkById(100, function ($recipients) {
                foreach ($recipients as $recipient) {
                    $age = null;

                    if ($recipient->birth_date) {
                        $age = Carbon::parse($recipient->birth_date)->age;
                    }

                    DB::table('recipients')
                        ->where('id', $recipient->id)
                        ->update(['age' => $age]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipients', function (Blueprint $table) {
            if (Schema::hasColumn('recipients', 'age')) {
                $table->dropColumn('age');
            }
        });
    }
};
