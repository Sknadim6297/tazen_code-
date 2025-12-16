<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Bronze',
                'price' => 4000,
                'lead_limit' => 50,
                'features' => json_encode([
                    'Onboarding and account setup',
                    'Personalised Dashboard',
                    'Operational handling – leads call and client meeting arrangement',
                    'Hold webinars'
                ]),
                'validity_days' => 30,
                'description' => 'Perfect for getting started with basic features',
                'status' => 'active',
                'order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Silver',
                'price' => 7000,
                'lead_limit' => 100,
                'features' => json_encode([
                    'Onboarding and account setup',
                    'Personalised Dashboard',
                    'Operational handling – leads call and client meeting arrangement',
                    'Hold webinars',
                    'Priority support'
                ]),
                'validity_days' => 30,
                'description' => 'Enhanced features for growing professionals',
                'status' => 'active',
                'order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gold',
                'price' => 12000,
                'lead_limit' => 200,
                'features' => json_encode([
                    'Onboarding and account setup',
                    'Personalised Dashboard',
                    'Operational handling – leads call and client meeting arrangement',
                    'Hold webinars',
                    'Get featured on our social media platform',
                    'One free webinar marketing',
                    'Be a part of our B2B workshops and earn more'
                ]),
                'validity_days' => 30,
                'description' => 'Most popular plan with promotional benefits',
                'status' => 'active',
                'order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Platinum',
                'price' => 15000,
                'lead_limit' => 500,
                'features' => json_encode([
                    'Onboarding and account setup',
                    'Personalised Dashboard',
                    'Operational handling – leads call and client meeting arrangement',
                    'Hold webinars',
                    'Get featured on our social media platform',
                    'One free webinar marketing',
                    'Promoted leads',
                    'Be a part of our B2B workshops and earn more',
                    'Complete package with all features'
                ]),
                'validity_days' => 30,
                'description' => 'Ultimate plan with complete access to all features',
                'status' => 'active',
                'order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Delete existing plans (use delete instead of truncate due to foreign key constraints)
        DB::table('plans')->delete();

        // Insert new plans
        DB::table('plans')->insert($plans);

        $this->command->info('Plans seeded successfully!');
    }
}
