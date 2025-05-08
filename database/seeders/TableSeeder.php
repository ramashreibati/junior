<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tables;
use App\Models\Reservation;

class TableSeeder extends Seeder
{
    public function run()
    {
        $types = DB::table('tables')
            ->select('type', DB::raw('COUNT(*) as total_tables'))
            ->groupBy('type')
            ->get();

        foreach ($types as $type) {
            DB::table('tables')
                ->whereRaw('LOWER(type) = ?', [strtolower($type->type)])
                ->whereNotIn('id', Reservation::where('reserve_until', '>', now())->pluck('table_id')) 
                ->update([
                    'count' => $type->total_tables,
                    'is_available' => DB::table('tables')->whereRaw('LOWER(type) = ?', [strtolower($type->type)])
                        ->whereNotIn('id', Reservation::where('reserve_until', '>', now())->pluck('table_id'))
                        ->where('count', '>', 0)
                        ->exists() ? 1 : 0 
                ]);
        }
    }
}


