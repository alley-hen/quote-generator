<?php

namespace App\Http\Controllers;

use App\Http\Services\GetFiveUniqueQuotesFromRemoteApiService;
use App\Models\Quote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuotesController extends Controller
{
    public function index()
    {
        return Quote::all();
    }

    public function showFiveUniqueQuotesFromRemoteApi(Request $request)
    {
        //fetch any seen quotes from the session
        $seen = session('seen', []);
        $quotesToExclude = collect($seen)->flatten();

        $quotesToDisplay = (new GetFiveUniqueQuotesFromRemoteApiService())->handle($quotesToExclude);

        $seen = $quotesToExclude->push($quotesToDisplay);
        session(['seen' => $seen]);

        return Inertia::render('Dashboard', [
            'quotes' => $quotesToDisplay
        ]);

    }

}
