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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bidang_id')->constrained('bidangs');
            $table->string('nama');
            $table->string('nip')->unique();
            $table->timestamps();
        });

        DB::statement('CREATE INDEX pegawais_uuid_hash_index ON pegawais USING hash (uuid);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
