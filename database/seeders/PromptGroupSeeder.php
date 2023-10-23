<?php

namespace Database\Seeders;

use App\Models\Prompt;
use App\Models\PromptGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromptGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = file_get_contents(database_path('seeders/prompt/seed.json'));

        $groups = json_decode($content, true);

        foreach ($groups as $groupData) {
            $group = PromptGroup::create([
                'name' => $groupData['name']
            ]);
            foreach ($groupData['children'] as $promptData) {
                $prompt = new Prompt($promptData);
                $prompt->group()->associate($group);
                $prompt->save();
            }
        }
    }
}
