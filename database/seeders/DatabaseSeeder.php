<?php

namespace Database\Seeders;

use App\Console\Commands\FetchQuotesCommand;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new FetchQuotesCommand())->handle();
    }
}
