<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\Models\Taisyo_soshiki;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taisyo_soshikis', function (Blueprint $table) {
            $table->id();
            $table->char('KAISYA_CODE', 6);
            $table->string('SOSHIKI_CODE', 69);
            $table->string('KAISYA_NAME_JPN', 128);
            $table->string('SOSHIKI_NAME_JPN', 100);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taisyo_soshikis');
    }
};
