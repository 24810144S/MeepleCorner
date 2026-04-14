<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Add new columns
            $table->time('start_time')->nullable()->after('reservation_date');
            $table->time('end_time')->nullable()->after('start_time');
            $table->boolean('is_private_booking')->default(false)->after('status');
        });

        // Convert existing time_slot data to start_time and end_time
        $reservations = DB::table('reservations')->get();
        foreach ($reservations as $res) {
            if ($res->time_slot) {
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

        // Now make columns not nullable
        Schema::table('reservations', function (Blueprint $table) {
            $table->time('start_time')->nullable(false)->change();
            $table->time('end_time')->nullable(false)->change();
            $table->dropColumn('time_slot');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('time_slot')->nullable()->after('reservation_date');
            $table->dropColumn(['start_time', 'end_time', 'is_private_booking']);
        });
    }
};