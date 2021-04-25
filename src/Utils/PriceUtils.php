<?php

namespace App\Utils;

use Symfony\Component\Intl\Currencies;

class PriceUtils
{
    public static function formatPrice(float $price, string $currency): string
    {
        return sprintf('%s %s', number_format($price, 2), Currencies::getSymbol($currency));
    }
}