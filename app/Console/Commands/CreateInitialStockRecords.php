<?php

namespace App\Console\Commands;

use App\Models\Medicine;
use Illuminate\Console\Command;

class CreateInitialStockRecords extends Command
{
    protected $signature = 'medicines:create-initial-stock';
    protected $description = 'Create initial stock records for medicines without stock history';

    public function handle()
    {
        $medicines = Medicine::whereDoesntHave('stockHistory')->get();
        
        $count = 0;
        foreach ($medicines as $medicine) {
            $medicine->stockHistory()->create([
                'quantity' => 0,
                'type' => 'in',
                'reference' => 'Initial Stock',
                'notes' => 'Initial stock record created via command',
                'status' => 'active'
            ]);
            $count++;
        }

        $this->info("Created initial stock records for {$count} medicines.");
    }
} 