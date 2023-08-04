<?php

namespace App\Console\Commands;

use App\Models\Quote;
use Http;
use Illuminate\Console\Command;

class FetchQuotesCommand extends Command
{
    protected $signature = 'fetch:quotes';

    protected $description = 'Fetch entire contents of Kanye quotes bank, save to DB';

    public function handle()
    {
        $response = Http::get('https://raw.githubusercontent.com/ajzbc/kanye.rest/master/quotes.json');

        collect(json_decode($response))->each(function ($quote) {
            Quote::updateOrCreate([
                'quote' => $quote
            ]);
        });

    }
}
