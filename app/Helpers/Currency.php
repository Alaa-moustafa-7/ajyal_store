<?php

namespace App\Helpers;

use NumberFormatter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Currency
{
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }

    public static function format($amount, $currency = null)
    {
        $baseCurrency = config('app.currency', 'USD');
        $currency = $currency ?? Session::get('currency_code', $baseCurrency);

        if ($currency != $baseCurrency){
            $rate = Cache::get('currency_rate_' . $currency, null);

            if ($rate === null){
                $rate = 1;  // يجب أن يحدث هذا فقط إذا كان المعدل غير موجود
            }

            $amount = $amount * $rate;
        }

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}