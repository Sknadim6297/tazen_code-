<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class FixUserRegistrationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:fix-registration-status {--dry-run : Show what would be fixed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix users who have passwords but registration_completed is false';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for users with inconsistent registration status...');
        
        // Find users who have passwords but registration_completed is false
        $usersToFix = User::whereNotNull('password')
            ->where('registration_completed', false)
            ->get();
            
        if ($usersToFix->isEmpty()) {
            $this->info('✅ No users found with inconsistent registration status.');
            return 0;
        }
        
        $this->warn("Found {$usersToFix->count()} users with passwords but registration_completed = false:");
        
        $headers = ['ID', 'Email', 'Created At', 'Password Set'];
        $rows = [];
        
        foreach ($usersToFix as $user) {
            $rows[] = [
                $user->id,
                $user->email,
                $user->created_at->format('Y-m-d H:i:s'),
                $user->password ? 'Yes' : 'No'
            ];
        }
        
        $this->table($headers, $rows);
        
        if ($this->option('dry-run')) {
            $this->info('🔍 Dry run mode - no changes made.');
            $this->info('Run without --dry-run to fix these users.');
            return 0;
        }
        
        if (!$this->confirm('Fix these users by setting registration_completed = true?')) {
            $this->info('Operation cancelled.');
            return 0;
        }
        
        $fixed = 0;
        foreach ($usersToFix as $user) {
            $user->update([
                'registration_completed' => true,
                'password_set_at' => $user->password_set_at ?? now()
            ]);
            $fixed++;
        }
        
        $this->info("✅ Fixed {$fixed} users successfully!");
        
        return 0;
    }
}
