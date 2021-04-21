<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Currencies;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $currency;
    private $router;

    public function __construct($currency, UrlGeneratorInterface $router)
    {
        $this->currency = $currency;
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getPagingRoute', [$this, 'getPagingRoute'])
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('priceFormat', [$this, 'priceFormat']),
        ];
    }

    public function priceFormat($price): string
    {
        return sprintf('%s %s', number_format($price, 2), Currencies::getSymbol($this->currency));
    }

    public function getPagingRoute(int $page, Request $request): string
    {
        $params = array_merge($request->attributes->get('_route_params'), $request->query->all());
        $params['page'] = $page;
        return $this->router->generate($request->get('_route'), $params);
    }
}