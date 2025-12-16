<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subServices = [
            ['id' => 7, 'service_id' => 11, 'name' => '3D-rendering', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:15:04', 'updated_at' => '2025-11-10 07:15:04'],
            ['id' => 8, 'service_id' => 11, 'name' => '2D-rendering', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:15:32', 'updated_at' => '2025-11-10 07:15:49'],
            ['id' => 9, 'service_id' => 11, 'name' => 'Design & Material Expertise', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:17:28', 'updated_at' => '2025-11-10 07:17:28'],
            ['id' => 10, 'service_id' => 11, 'name' => 'Exterior Elevation & Façade Design', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:17:41', 'updated_at' => '2025-11-10 07:17:41'],
            ['id' => 11, 'service_id' => 11, 'name' => 'Project Monitoring', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:18:18', 'updated_at' => '2025-11-10 07:18:18'],
            ['id' => 12, 'service_id' => 11, 'name' => 'Airbnb/Hotel interior', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:18:32', 'updated_at' => '2025-11-10 07:18:32'],
            ['id' => 13, 'service_id' => 11, 'name' => 'Spatial Design (Concept/Planning)', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:18:43', 'updated_at' => '2025-11-10 07:18:43'],
            ['id' => 14, 'service_id' => 11, 'name' => 'Residential interior', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:18:53', 'updated_at' => '2025-11-10 07:18:53'],
            ['id' => 15, 'service_id' => 11, 'name' => 'Architecture', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-10 07:19:02', 'updated_at' => '2025-11-10 07:19:02'],
            ['id' => 16, 'service_id' => 10, 'name' => 'Tarot Card Reading', 'description' => 'Lorem', 'image' => null, 'status' => 1, 'created_at' => '2025-11-11 12:54:42', 'updated_at' => '2025-11-11 12:54:42'],
            ['id' => 17, 'service_id' => 10, 'name' => 'Numerology', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-11 12:55:05', 'updated_at' => '2025-11-11 12:55:05'],
            ['id' => 18, 'service_id' => 10, 'name' => 'Vedic', 'description' => 'Lorem', 'image' => null, 'status' => 1, 'created_at' => '2025-11-11 12:55:24', 'updated_at' => '2025-11-11 12:55:24'],
            ['id' => 19, 'service_id' => 10, 'name' => 'Business & Career', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 08:36:09', 'updated_at' => '2025-11-17 08:36:09'],
            ['id' => 20, 'service_id' => 10, 'name' => 'Love', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 08:36:27', 'updated_at' => '2025-11-17 08:36:27'],
            ['id' => 21, 'service_id' => 10, 'name' => 'Health', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 08:36:41', 'updated_at' => '2025-11-17 08:36:41'],
            ['id' => 22, 'service_id' => 10, 'name' => 'General Horoscope', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 08:36:56', 'updated_at' => '2025-11-17 08:36:56'],
            ['id' => 23, 'service_id' => 10, 'name' => 'Natal Chart Analysis', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 08:39:10', 'updated_at' => '2025-11-17 08:39:10'],
            ['id' => 24, 'service_id' => 10, 'name' => 'Compatibility Chart Analysis', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 08:42:32', 'updated_at' => '2025-11-17 08:42:32'],
            ['id' => 25, 'service_id' => 6, 'name' => 'Trauma Healing', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:09:57', 'updated_at' => '2025-11-17 10:09:57'],
            ['id' => 26, 'service_id' => 6, 'name' => 'Stress, Anxiety and Depression', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:10:16', 'updated_at' => '2025-11-17 10:10:16'],
            ['id' => 27, 'service_id' => 6, 'name' => 'Personal Development', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:10:31', 'updated_at' => '2025-11-17 10:10:31'],
            ['id' => 28, 'service_id' => 6, 'name' => 'Relationship Management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:10:48', 'updated_at' => '2025-11-17 10:10:48'],
            ['id' => 29, 'service_id' => 6, 'name' => 'Parenting', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:11:02', 'updated_at' => '2025-11-17 10:11:02'],
            ['id' => 30, 'service_id' => 6, 'name' => 'Anger management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:11:15', 'updated_at' => '2025-11-17 10:11:15'],
            ['id' => 31, 'service_id' => 6, 'name' => 'EMDR therapy', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:11:46', 'updated_at' => '2025-11-17 10:11:46'],
            ['id' => 32, 'service_id' => 6, 'name' => 'High risk and sensitivity', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:11:58', 'updated_at' => '2025-11-17 10:11:58'],
            ['id' => 33, 'service_id' => 8, 'name' => 'Nutrition Assessment and plans', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:13:06', 'updated_at' => '2025-11-17 10:13:06'],
            ['id' => 34, 'service_id' => 8, 'name' => 'Weight Management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:13:22', 'updated_at' => '2025-11-17 10:13:22'],
            ['id' => 35, 'service_id' => 8, 'name' => 'Metabolic and hormonal management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:13:37', 'updated_at' => '2025-11-17 10:13:37'],
            ['id' => 36, 'service_id' => 8, 'name' => 'Meal plans - All types', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:13:53', 'updated_at' => '2025-11-17 10:13:53'],
            ['id' => 37, 'service_id' => 8, 'name' => 'Post partum/surgical care', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:14:08', 'updated_at' => '2025-11-17 10:14:08'],
            ['id' => 38, 'service_id' => 8, 'name' => 'Diabetes management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:14:24', 'updated_at' => '2025-11-17 10:14:24'],
            ['id' => 39, 'service_id' => 8, 'name' => 'Infant nutrition coaching', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:15:04', 'updated_at' => '2025-11-17 10:15:04'],
            ['id' => 40, 'service_id' => 3, 'name' => 'Extra skills guidance', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:16:13', 'updated_at' => '2025-11-17 10:16:13'],
            ['id' => 41, 'service_id' => 3, 'name' => 'Diploma courses', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:16:23', 'updated_at' => '2025-11-17 10:16:23'],
            ['id' => 42, 'service_id' => 3, 'name' => 'Job Guidance', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:16:35', 'updated_at' => '2025-11-17 10:16:35'],
            ['id' => 43, 'service_id' => 3, 'name' => 'Career shift coaching', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:16:50', 'updated_at' => '2025-11-17 10:16:50'],
            ['id' => 44, 'service_id' => 3, 'name' => 'Career Roadmapping and planning', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:17:06', 'updated_at' => '2025-11-17 10:17:06'],
            ['id' => 45, 'service_id' => 3, 'name' => 'Psychometric tests', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:17:18', 'updated_at' => '2025-11-17 10:17:18'],
            ['id' => 46, 'service_id' => 3, 'name' => 'Academic (college and career)', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:17:34', 'updated_at' => '2025-11-17 10:17:34'],
            ['id' => 47, 'service_id' => 3, 'name' => 'College Counseling - Study Abroad', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:17:49', 'updated_at' => '2025-11-17 10:17:49'],
            ['id' => 48, 'service_id' => 3, 'name' => 'Academic (High School)', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:18:03', 'updated_at' => '2025-11-17 10:18:03'],
            ['id' => 49, 'service_id' => 12, 'name' => 'Content Creation', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:18:59', 'updated_at' => '2025-11-17 10:18:59'],
            ['id' => 50, 'service_id' => 12, 'name' => 'Brand Collaboration', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:19:11', 'updated_at' => '2025-11-17 10:19:11'],
            ['id' => 51, 'service_id' => 12, 'name' => 'Voiceover', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:19:23', 'updated_at' => '2025-11-17 10:19:23'],
            ['id' => 52, 'service_id' => 12, 'name' => 'Reels', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:19:37', 'updated_at' => '2025-11-17 10:19:37'],
            ['id' => 53, 'service_id' => 22, 'name' => 'Others', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:20:18', 'updated_at' => '2025-11-17 10:20:18'],
            ['id' => 54, 'service_id' => 12, 'name' => 'Tax audit', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:20:29', 'updated_at' => '2025-11-17 10:20:41'],
            ['id' => 55, 'service_id' => 12, 'name' => 'Statutory Audit', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:20:41', 'updated_at' => '2025-11-17 10:20:41'],
            ['id' => 56, 'service_id' => 12, 'name' => 'GST Filing', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:20:53', 'updated_at' => '2025-11-17 10:20:53'],
            ['id' => 57, 'service_id' => 12, 'name' => 'Income Tax Return', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:21:09', 'updated_at' => '2025-11-17 10:21:09'],
            ['id' => 58, 'service_id' => 4, 'name' => 'Fractional CFO', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:22:29', 'updated_at' => '2025-11-17 10:22:29'],
            ['id' => 59, 'service_id' => 4, 'name' => 'Marketing Strategy', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:22:41', 'updated_at' => '2025-11-17 10:22:41'],
            ['id' => 60, 'service_id' => 4, 'name' => 'Business Coach', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:22:59', 'updated_at' => '2025-11-17 10:22:59'],
            ['id' => 61, 'service_id' => 4, 'name' => 'Business Research', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:23:13', 'updated_at' => '2025-11-17 10:23:13'],
            ['id' => 62, 'service_id' => 4, 'name' => 'Digital Marketing', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:23:26', 'updated_at' => '2025-11-17 10:23:26'],
            ['id' => 63, 'service_id' => 4, 'name' => 'Cost Analysis', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:23:39', 'updated_at' => '2025-11-17 10:23:39'],
            ['id' => 64, 'service_id' => 4, 'name' => 'Business Presentation', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:23:51', 'updated_at' => '2025-11-17 10:23:51'],
            ['id' => 65, 'service_id' => 4, 'name' => 'Business Growth Plan', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:24:12', 'updated_at' => '2025-11-17 10:24:12'],
            ['id' => 66, 'service_id' => 9, 'name' => 'Meditation Trainers', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:25:01', 'updated_at' => '2025-11-17 10:25:01'],
            ['id' => 67, 'service_id' => 9, 'name' => 'Weight trainers', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:25:12', 'updated_at' => '2025-11-17 10:25:12'],
            ['id' => 68, 'service_id' => 9, 'name' => 'Zumba Trainers', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:25:25', 'updated_at' => '2025-11-17 10:25:25'],
            ['id' => 69, 'service_id' => 9, 'name' => 'Yoga trainers', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:25:38', 'updated_at' => '2025-11-17 10:25:38'],
            ['id' => 70, 'service_id' => 5, 'name' => 'Others', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:26:32', 'updated_at' => '2025-11-17 10:26:32'],
            ['id' => 71, 'service_id' => 5, 'name' => 'estate planning tools - Will, trusts, insurance policies etc', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:26:44', 'updated_at' => '2025-11-17 10:26:44'],
            ['id' => 72, 'service_id' => 5, 'name' => 'Probate avoidance', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:26:55', 'updated_at' => '2025-11-17 10:26:55'],
            ['id' => 73, 'service_id' => 5, 'name' => 'Beneficiary management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:27:09', 'updated_at' => '2025-11-17 10:27:09'],
            ['id' => 74, 'service_id' => 5, 'name' => 'Tax optimization', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:27:31', 'updated_at' => '2025-11-17 10:27:31'],
            ['id' => 75, 'service_id' => 5, 'name' => 'Legal document creation', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:27:52', 'updated_at' => '2025-11-17 10:27:52'],
            ['id' => 76, 'service_id' => 5, 'name' => 'Asset distribution', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 10:28:05', 'updated_at' => '2025-11-17 10:28:05'],
            ['id' => 82, 'service_id' => 25, 'name' => 'Life Coach', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:05:33', 'updated_at' => '2025-11-17 11:05:33'],
            ['id' => 83, 'service_id' => 25, 'name' => 'Outfit Planning', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:05:45', 'updated_at' => '2025-11-17 11:05:45'],
            ['id' => 84, 'service_id' => 25, 'name' => 'Wardrobe Styling', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:05:59', 'updated_at' => '2025-11-17 11:05:59'],
            ['id' => 85, 'service_id' => 25, 'name' => 'Colour Analysis', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:06:11', 'updated_at' => '2025-11-17 11:06:11'],
            ['id' => 86, 'service_id' => 25, 'name' => 'Style Makeover', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:06:29', 'updated_at' => '2025-11-17 11:06:29'],
            ['id' => 87, 'service_id' => 25, 'name' => 'Etiquette Enhancement - social, personal, corporate', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:06:43', 'updated_at' => '2025-11-17 11:06:43'],
            ['id' => 88, 'service_id' => 25, 'name' => 'Personality Enhancement', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 11:06:55', 'updated_at' => '2025-11-17 11:06:55'],
            ['id' => 89, 'service_id' => 25, 'name' => 'Communication Training', 'description' => null, 'image' => 'uploads/sub-services/LETsJyfk3MnpC8zfjtXyDgsAbcTJPmXSgbmnTWvO.jpg', 'status' => 1, 'created_at' => '2025-11-17 11:07:07', 'updated_at' => '2025-11-30 06:10:47'],
            ['id' => 90, 'service_id' => 11, 'name' => 'Interior Designer', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-17 12:08:54', 'updated_at' => '2025-11-17 12:08:54'],
            ['id' => 91, 'service_id' => 11, 'name' => 'Brand Consultation', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 05:29:35', 'updated_at' => '2025-11-25 05:29:35'],
            ['id' => 92, 'service_id' => 11, 'name' => 'Home Decor', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 05:30:05', 'updated_at' => '2025-11-25 05:30:05'],
            ['id' => 93, 'service_id' => 11, 'name' => 'Vaastu', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 05:30:18', 'updated_at' => '2025-11-25 05:30:18'],
            ['id' => 94, 'service_id' => 5, 'name' => 'Accounting and tax experts', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 05:57:36', 'updated_at' => '2025-11-25 05:57:36'],
            ['id' => 95, 'service_id' => 5, 'name' => 'Finance Coach', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 05:58:06', 'updated_at' => '2025-11-25 05:58:06'],
            ['id' => 96, 'service_id' => 9, 'name' => 'Nutrition Assessment and plans', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 06:42:50', 'updated_at' => '2025-11-25 06:42:50'],
            ['id' => 97, 'service_id' => 9, 'name' => 'Metabolic and hormonal management', 'description' => null, 'image' => null, 'status' => 1, 'created_at' => '2025-11-25 06:43:02', 'updated_at' => '2025-11-25 06:43:02'],
        ];

        // Insert the sub-services
        foreach (array_chunk($subServices, 10) as $chunk) {
            DB::table('sub_services')->insertOrIgnore($chunk);
        }

        $this->command->info('Sub-services seeded successfully!');
    }
}
