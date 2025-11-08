<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckTableStructure extends Command
{
    protected $signature = 'check:table {table}';
    protected $description = 'Check table structure';

    public function handle()
    {
        $tableName = $this->argument('table');
        
        $this->info("Checking structure of table: {$tableName}");
        
        try {
            $columns = DB::select("DESCRIBE {$tableName}");
            
            $this->info("Columns in {$tableName} table:");
            foreach ($columns as $column) {
                $this->info("- {$column->Field} ({$column->Type}) - {$column->Null} - {$column->Key} - Default: {$column->Default}");
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
        
        return 0;
    }
}
