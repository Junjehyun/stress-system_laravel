<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\Models\Haisya_mst;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('haisya_msts', function (Blueprint $table) {
            $table->id();
            $table->char('KAISYA_CODE', 6)->nullable();
            $table->string('KAISYA_NAME_JPN', 128)->nullable();
            $table->string('KAISYA_NAME_ENG', 128)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haisya_msts');
    }
};
