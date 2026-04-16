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
        Schema::table('members', function (Blueprint $table) {
            // Add security question fields if they don't exist
            if (!Schema::hasColumn('members', 'security_q1_id')) {
                $table->string('security_q1_id')->nullable()->after('password');
            }
            if (!Schema::hasColumn('members', 'security_a1')) {
                $table->string('security_a1')->nullable()->after('security_q1_id');
            }
            if (!Schema::hasColumn('members', 'security_a2')) {
                $table->string('security_a2')->nullable()->after('security_a1');
            }
            if (!Schema::hasColumn('members', 'security_a3')) {
                $table->text('security_a3')->nullable()->after('security_a2');
            }
            if (!Schema::hasColumn('members', 'subscribe_events')) {
                $table->boolean('subscribe_events')->default(false)->after('security_a3');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'security_q1_id',
                'security_a1',
                'security_a2',
                'security_a3',
                'subscribe_events'
            ]);
        });
    }
};