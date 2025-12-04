<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('recipients', function (Blueprint $table) {
        $table->text('notes')->nullable()->after('has_photo_booth');
    });
}

public function down()
{
    Schema::table('recipients', function (Blueprint $table) {
        $table->dropColumn('notes');
    });
}

};
