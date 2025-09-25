<?php

namespace App\Console\Commands;

use App\Models\AdminMenu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SyncAdminMenus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:sync-menus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync admin menus from sidebar to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Syncing admin menus...');

        // Path to sidebar.blade.php
        $sidebarPath = resource_path('views/admin/sections/sidebar.blade.php');

        if (!File::exists($sidebarPath)) {
            $this->error("Sidebar file not found at: {$sidebarPath}");
            return 1;
        }

        $content = File::get($sidebarPath);

        // Extract menu sections
        // This is a very simplified approach - in a real implementation,
        // you would need a more sophisticated parser
        preg_match_all('/@if\(\$isMenuAccessible\([\'"](.+)[\'"]\)\)/m', $content, $matches);
        
        if (empty($matches[1])) {
            $this->warn('No menu sections found in the sidebar.');
            return 0;
        }
        
        $menuNames = $matches[1];
        $this->info('Found ' . count($menuNames) . ' menu sections.');
        
        // Extract menu items with route names
        preg_match_all('/href="\{\{ route\([\'"](.+)[\'"].*\) \}\}"/m', $content, $routeMatches);
        
        $routeNames = $routeMatches[1] ?? [];
        $this->info('Found ' . count($routeNames) . ' route names.');
        
        // Create or update menus
        foreach ($menuNames as $index => $name) {
            $menuExists = AdminMenu::where('name', $name)->exists();
            $action = $menuExists ? 'Updated' : 'Created';
            
            AdminMenu::updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => Str::title(str_replace('_', ' ', $name)),
                    'order' => $index + 1,
                ]
            );
            
            $this->info("{$action} menu: {$name}");
        }
        
        $this->info('Sync completed successfully.');
        return 0;
    }
}
