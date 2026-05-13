<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Road Signs',
                'slug' => 'road-signs',
                'description' => 'Shapes, colours and meanings of all road signs used in Barbados.',
                'icon' => 'triangle-alert',
                'sort_order' => 1,
            ],
            [
                'name' => 'Traffic Lights & Signals',
                'slug' => 'traffic-lights-signals',
                'description' => 'Traffic light sequences, warden signals and hand signals.',
                'icon' => 'traffic-cone',
                'sort_order' => 2,
            ],
            [
                'name' => 'Speed Limits',
                'slug' => 'speed-limits',
                'description' => 'Speed limits for different road types and conditions in Barbados.',
                'icon' => 'gauge',
                'sort_order' => 3,
            ],
            [
                'name' => 'Roundabouts & Junctions',
                'slug' => 'roundabouts-junctions',
                'description' => 'Right of way, lane selection and correct procedure at roundabouts and junctions.',
                'icon' => 'circle-arrow-right',
                'sort_order' => 4,
            ],
            [
                'name' => 'Overtaking',
                'slug' => 'overtaking',
                'description' => 'When and how to overtake safely, including distances and prohibited zones.',
                'icon' => 'arrow-right-left',
                'sort_order' => 5,
            ],
            [
                'name' => 'Parking',
                'slug' => 'parking',
                'description' => 'Parking rules, restrictions and distances from junctions and crossings.',
                'icon' => 'square-parking',
                'sort_order' => 6,
            ],
            [
                'name' => 'Seatbelts & Child Restraints',
                'slug' => 'seatbelts-child-restraints',
                'description' => 'Laws on seatbelts, child seats and passenger safety.',
                'icon' => 'shield-check',
                'sort_order' => 7,
            ],
            [
                'name' => 'Pedestrians & Cyclists',
                'slug' => 'pedestrians-cyclists',
                'description' => 'Rules and considerations for pedestrians, cyclists and vulnerable road users.',
                'icon' => 'person-walking',
                'sort_order' => 8,
            ],
            [
                'name' => 'Learner Drivers',
                'slug' => 'learner-drivers',
                'description' => 'Rules specific to learner drivers, L-plates, supervisors and permit requirements.',
                'icon' => 'graduation-cap',
                'sort_order' => 9,
            ],
            [
                'name' => 'Vehicle Lighting',
                'slug' => 'vehicle-lighting',
                'description' => 'When and how to use headlights, fog lights, hazard lights and parking lights.',
                'icon' => 'lightbulb',
                'sort_order' => 10,
            ],
            [
                'name' => 'Safe Driving Practices',
                'slug' => 'safe-driving-practices',
                'description' => 'General defensive driving, mobile phones, alcohol, medication and hazard awareness.',
                'icon' => 'car',
                'sort_order' => 11,
            ],
            [
                'name' => 'Animals on the Road',
                'slug' => 'animals-on-the-road',
                'description' => 'Rules for dealing with animals and livestock on Barbados roads.',
                'icon' => 'paw-print',
                'sort_order' => 12,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
