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
        
            // Get all unique table types and count rows per type
            $types = DB::table('tables')
                ->select('type', DB::raw('COUNT(*) as total_count'))
                ->groupBy('type')
                ->get();

            // Ensure count reflects the number of tables for each type
            foreach ($types as $type) {
                DB::table('tables')
                    ->whereRaw('LOWER(type) = ?', [strtolower($type->type)])
                    ->update(['count' => $type->total_count]);
            }

           
}

}

