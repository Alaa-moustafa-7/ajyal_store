<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Services\CurrencyConverter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

        $baseCurrencyCode = config('app.currency');
        $currencyCode = $request->input('currency_code');

        $cashKey = 'currency_rate_' . $currencyCode;

        $rate = Cache::get($cashKey, null);

        if (!$rate){
            $converter = app('currency.converter');
            $rate = $converter->convert($baseCurrencyCode, $currencyCode);
            Cache::put('currency_rate_' . $currencyCode, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currencyCode);

        return redirect()->back()->with('success', 'Currency updated successfully.');

    }
}
