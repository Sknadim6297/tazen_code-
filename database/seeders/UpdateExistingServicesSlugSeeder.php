<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class UpdateExistingServicesSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::whereNull('slug')->get();
        
        foreach ($services as $service) {
            $slug = Str::slug($service->name);
            
            // Make sure slug is unique
            $originalSlug = $slug;
            $counter = 1;
            
            while (Service::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $service->update([
                'slug' => $slug,
                'meta_title' => $service->name . ' - Professional Services | Tazen.in',
                'meta_description' => 'Find professional ' . strtolower($service->name) . ' services. Connect with verified experts and book appointments easily with Tazen.in.'
            ]);
        }
        
        $this->command->info('Updated ' . $services->count() . ' services with slugs and meta data.');
    }
}
