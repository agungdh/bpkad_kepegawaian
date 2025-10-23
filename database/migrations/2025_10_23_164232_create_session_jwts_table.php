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
        Schema::create('session_jwts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('jti');
            $table->timestamps();
        });

        DB::statement('CREATE INDEX session_jwts_session_id_hash_index ON session_jwts USING hash (session_id);');
        DB::statement('CREATE INDEX session_jwts_jti_hash_index ON session_jwts USING hash (jti);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_jwts');
    }
};
