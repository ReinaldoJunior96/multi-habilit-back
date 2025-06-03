<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContaAPagar;

class ContaAPagarSeeder extends Seeder
{
    public function run(): void
    {
        ContaAPagar::factory()->count(30)->create();
    }
}
