<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix any gallery entries that might be stored as the string "null" or invalid JSON
        DB::table('profiles')->whereNotNull('gallery')->orderBy('id')->chunk(100, function ($profiles) {
            foreach ($profiles as $profile) {
                $gallery = $profile->gallery;
                
                // If gallery is the string "null" or empty string, set it to actual null
                if ($gallery === 'null' || $gallery === '' || $gallery === '[]') {
                    DB::table('profiles')
                        ->where('id', $profile->id)
                        ->update(['gallery' => null]);
                    continue;
                }
                
                // Try to decode JSON and re-encode to ensure it's valid
                $decoded = json_decode($gallery, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If it's not valid JSON, treat as single image path if it looks like a path
                    if (is_string($gallery) && (str_contains($gallery, '/') || str_contains($gallery, '\\'))) {
                        $validJson = json_encode([$gallery]);
                        DB::table('profiles')
                            ->where('id', $profile->id)
                            ->update(['gallery' => $validJson]);
                    } else {
                        // If it's not a valid path either, set to null
                        DB::table('profiles')
                            ->where('id', $profile->id)
                            ->update(['gallery' => null]);
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse this migration as we're fixing data integrity
    }
};
