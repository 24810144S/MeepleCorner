<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if reservations table exists
        if (!Schema::hasTable('reservations')) {
            return;
        }

        // Add new columns if they don't exist
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'start_time')) {
                $table->time('start_time')->nullable()->after('reservation_date');
            }
            
            if (!Schema::hasColumn('reservations', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }
            
            if (!Schema::hasColumn('reservations', 'is_private_booking')) {
                $table->boolean('is_private_booking')->default(false)->after('status');
            }
        });

        // Convert existing time_slot data to start_time and end_time
        if (Schema::hasColumn('reservations', 'time_slot')) {
            $reservations = DB::table('reservations')->get();
            foreach ($reservations as $res) {
                if ($res->time_slot && !$res->start_time) {
                    $times = explode('-', $res->time_slot);
                    if (count($times) == 2) {
                        DB::table('reservations')
                            ->where('id', $res->id)
                            ->update([
                                'start_time' => trim($times[0]),
                                'end_time' => trim($times[1]),
                            ]);
                    }
                }
            }
        }

        // Make columns not nullable and drop old time_slot column
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'start_time')) {
                $table->time('start_time')->nullable(false)->change();
            }
            
            if (Schema::hasColumn('reservations', 'end_time')) {
                $table->time('end_time')->nullable(false)->change();
            }
            
            if (Schema::hasColumn('reservations', 'time_slot')) {
                $table->dropColumn('time_slot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Re-add time_slot column
            if (!Schema::hasColumn('reservations', 'time_slot')) {
                $table->string('time_slot')->nullable()->after('reservation_date');
            }
            
            // Drop new columns
            if (Schema::hasColumn('reservations', 'start_time')) {
                $table->dropColumn('start_time');
            }
            if (Schema::hasColumn('reservations', 'end_time')) {
                $table->dropColumn('end_time');
            }
            if (Schema::hasColumn('reservations', 'is_private_booking')) {
                $table->dropColumn('is_private_booking');
            }
        });
    }
};