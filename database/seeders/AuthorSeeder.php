<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::updateOrCreate(
        [
            'email' => 'zadie@test.com',
        ],
        [
            'name' => 'Zadie Smith',
        ]);

        Author::updateOrCreate([
        'email' => 'arthur@test.com',
        ],
        [
            'name' => 'Arthur Conan Doyle',
        ]
        );
    }
}
