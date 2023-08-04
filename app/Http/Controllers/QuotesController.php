<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuotesController extends Controller
{

    public function showFiveUniqueQuotes(Request $request)
    {
        //fetch any seen quotes from the session
        $seen = session('seen', []);
        $quotesToExclude = collect($seen)->flatten();

        $quotesToDisplay = Quote::query()
            ->whereNotIn('id', $quotesToExclude)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        //add the quotes that are about to be displayed to 'seen'
        $seen = $quotesToExclude->push($quotesToDisplay->pluck('id'));
        session(['seen' => $seen]);

        return Inertia::render('Dashboard', [
            'quotes' => $quotesToDisplay
        ]);

    }

    public function restartSession(Request $request)
    {
        $request->session()->forget('seen');
        $this->showFiveUniqueQuotes($request);
    }

}
