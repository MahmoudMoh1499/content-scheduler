<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $platforms = [
            ['name' => 'Twitter', 'type' => 'twitter', 'character_limit' => 280],
            ['name' => 'Instagram', 'type' => 'instagram', 'allow_images' => true],
            ['name' => 'LinkedIn', 'type' => 'linkedin', 'character_limit' => 3000],
            ['name' => 'Facebook', 'type' => 'facebook', 'character_limit' => 63206],
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
}
