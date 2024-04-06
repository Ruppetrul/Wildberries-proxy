<?php

namespace Database\Seeders;

use App\Models\Search;
use Illuminate\Database\Seeder;

class SearchSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Search::create(['text' => 'футболка оверсайз']);
        Search::create(['text' => 'футболка мужская']);
        Search::create(['text' => 'футболка мужская оверсайз']);
    }
}
