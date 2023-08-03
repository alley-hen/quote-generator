<?php

namespace App\Http\Services;

use Http;
use Illuminate\Support\Collection;

class GetFiveUniqueQuotesFromRemoteApiService
{
    public function handle(Collection $quotesToExclude): Collection
    {
        //fetch quotes until the array has 5 unique unseen quotes
        $quotes = collect();
        for ($i = 0; $i < 5; $i++) {
            $response = Http::get('https://api.kanye.rest');
            $quote = $response->json(['quote']);

            $alreadyDisplayed = $quotesToExclude->contains($quote);
            $alreadyContainsQuote = $quotes->contains($quote);

            if($alreadyDisplayed === false && $alreadyContainsQuote === false){
                $quotes->push($quote);
            } else {
                $i--;
            }
        }
        return $quotes;
    }
}
