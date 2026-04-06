<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        // Personal Info
        $table->string('first_name');
        $table->string('last_name');
        $table->string('address');
        $table->string('phone');
        $table->string('email')->unique();
        $table->string('password');
        
        // Security Questions (The Tricia additions)
        $table->string('security_q1_id')->nullable();
        $table->string('security_a1')->nullable();
        $table->string('security_a2')->nullable();
        $table->text('security_a3')->nullable(); // Store checkbox string
        
        $table->boolean('subscribe_events')->default(false);
        $table->rememberToken(); // Required for "Remember Me"
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
