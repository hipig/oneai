<?php

namespace Database\Seeders;

use App\Models\ChatModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gptModel = ['gpt-3.5-turbo', 'gpt-4', 'gpt-4-vision-preview', 'gpt-4-1106-preview'];

        foreach ($gptModel as $index => $value) {
            ChatModel::create([
                'group' => 'ChatGPT',
                'name' => $value,
                'rank' => $index
            ]);
        }
    }
}
