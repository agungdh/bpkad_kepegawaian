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
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('skpd_id')->constrained('skpds');
            $table->string('nama');
            $table->timestamps();
        });

        DB::statement('CREATE INDEX bidangs_uuid_hash_index ON bidangs USING hash (uuid);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};
