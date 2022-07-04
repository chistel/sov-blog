<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                 Expert Market
 * @file                           Core.php
 * @author                  Chistel Brown(chistelbrown@gmail.com, me@chistel.com)
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     27/04/2022, 5:54 PM
 */

namespace App\Services\Common;

use App\Contracts\Repositories\Common\CurrencyRepository;
use App\Contracts\Repositories\Common\ExchangeRateRepository;
use App\Models\Common\Currency;
use Illuminate\Support\Collection;
use NumberFormatter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Core
{
    private static $currency;

    public function __construct(
        private CurrencyRepository $currencyRepository,
        private ExchangeRateRepository $exchangeRateRepository
    ) {
    }

    /**
     * Set currency.
     *
     * @param string $currencyCode
     * @return void
     */
    public function setCurrency(string $currencyCode): void
    {
        $currency = $this->currencyRepository->getOneBy('code', $currencyCode);

        self::$currency = $currency ?: null;
    }

    /**
     * Get currency.
     *
     * Will return null if not set.
     *
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return self::$currency;
    }

    /**
     * Returns all currencies.
     *
     * @return Collection
     */
    public function getAllCurrencies(): Collection
    {
        static $currencies;

        if ($currencies) {
            return $currencies;
        }

        return $currencies = $this->currencyRepository->getAll();
    }

    /**
     * Returns base currency model.
     *
     * @return Currency
     */
    public function getBaseCurrency()
    {
        static $currency;

        if ($currency) {
            return $currency;
        }

        $baseCurrency = $this->currencyRepository->getOneBy('code', config('app.currency'));

        if (!$baseCurrency) {
            $baseCurrency = $this->currencyRepository->getAll()->first();
        }

        return $currency = $baseCurrency;
    }

    /**
     * Returns base channel's currency code.
     *
     * @return string
     */
    public function getBaseCurrencyCode(): string
    {
        static $currencyCode;

        if ($currencyCode) {
            return $currencyCode;
        }

        return ($currency = $this->getBaseCurrency()) ? $currencyCode = $currency->code : '';
    }

    /**
     * Returns current currency model.
     *
     * Will fallback to base currency if not set.
     *
     * @return CurrencyRepository|Currency|mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCurrentCurrency()
    {
        static $currency;

        if ($currency) {
            return $currency;
        }
        if ($currencyCode = session()->get('currency')) {
            if ($currency = $this->currencyRepository->getOneBy('code', $currencyCode)) {
                return $currency;
            }
        }

        return $currency = $this->getBaseCurrency();
        //return $currency = $this->getCurrency() ?: $this->getBaseCurrency();
    }

    /**
     * Returns current channel's currency code.
     *
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCurrentCurrencyCode(): string
    {
        static $currencyCode;

        if ($currencyCode) {
            return $currencyCode;
        }

        return ($currency = $this->getCurrentCurrency()) ? $currencyCode = $currency->code : '';
    }

    /**
     * Returns exchange rates.
     *
     * @param $targetCurrencyId
     * @return object|string
     */
    public function getExchangeRate($targetCurrencyId): object|string
    {
        static $exchangeRate;

        if ($exchangeRate || $exchangeRate === '') {
            return $exchangeRate;
        }

        $found = $this->exchangeRateRepository->getOneBy('currency_id', $targetCurrencyId);

        return $exchangeRate = ($found ?: '');
    }

    /**
     * Converts price.
     *
     * @param float $amount
     * @param string|null $targetCurrencyCode
     * @param string|null $orderCurrencyCode
     * @return float|int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function convertPrice(float $amount, string|null $targetCurrencyCode = null, string|null $orderCurrencyCode = null)
    {
        if (!isset($this->lastCurrencyCode)) {
            $this->lastCurrencyCode = $this->getBaseCurrency()->code;
        }

        if ($orderCurrencyCode) {
            if (!isset($this->lastOrderCode)) {
                $this->lastOrderCode = $orderCurrencyCode;
            }

            if (($targetCurrencyCode != $this->lastOrderCode)
                && ($targetCurrencyCode != $orderCurrencyCode)
                && ($orderCurrencyCode != $this->getBaseCurrencyCode())
                && ($orderCurrencyCode != $this->lastCurrencyCode)
            ) {
                $amount = $this->convertToBasePrice($amount, $orderCurrencyCode);
            }
        }

        $targetCurrency = !$targetCurrencyCode
            ? $this->getCurrentCurrency()
            : $this->currencyRepository->getOneBy('code', $targetCurrencyCode);

        if (!$targetCurrency) {
            return $amount;
        }

        $exchangeRate = $this->getExchangeRate($targetCurrency->id);

        if ('' === $exchangeRate || null === $exchangeRate || !$exchangeRate->rate) {
            return $amount;
        }

        $result = (float)$amount * (float)($this->lastCurrencyCode == $targetCurrency->code ? 1.0 : $exchangeRate->rate);

        if ($this->lastCurrencyCode != $targetCurrency->code) {
            $this->lastCurrencyCode = $targetCurrency->code;
        }

        return $result;
    }

    /**
     * Converts to base price.
     *
     * @param float $amount
     * @param string|null $targetCurrencyCode
     * @return float
     */
    public function convertToBasePrice(float $amount, string|null $targetCurrencyCode = null)
    {
        $targetCurrency = !$targetCurrencyCode
            ? $this->getCurrentCurrency()
            : $this->currencyRepository->getOneBy('code', $targetCurrencyCode);

        if (!$targetCurrency) {
            return $amount;
        }

        $exchangeRate = $this->exchangeRateRepository->getOneBy('target_currency', $targetCurrency->id);

        if (null === $exchangeRate || !$exchangeRate->rate) {
            return $amount;
        }

        return (float)($amount / $exchangeRate->rate);
    }

    /**
     * Format and convert price with currency symbol.
     *
     * @param float $amount
     * @return string
     */
    public function currency(float $amount = 0): string
    {
        if (is_null($amount)) {
            $amount = 0;
        }

        return $this->formatPrice($this->convertPrice($amount));
    }

    /**
     * Return currency symbol from currency code.
     *
     * @param $code
     * @return false|string
     */
    public function currencySymbol($code): bool|string
    {
        $formatter = new NumberFormatter(app()->getLocale() . '@currency=' . $code, NumberFormatter::CURRENCY);

        return $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }

    /**
     * Format and convert price with currency symbol.
     *
     * @param float $price
     * @param string (optional)  $currencyCode
     * @return string
     */
    public function formatPrice(float $price = 0, $currencyCode = null): string
    {
        $currency = $currencyCode
            ? $this->getAllCurrencies()->where('code', $currencyCode)->first()
            : $this->getCurrentCurrency();

        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        if ($symbol = $currency->symbol) {
            if ($this->currencySymbol($currency->code) == $symbol) {
                return $formatter->formatCurrency($price, $currency->code);
            }

            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, $symbol);

            return $formatter->format($this->convertPrice($price));
        }

        return $formatter->formatCurrency($price, $currency->code);
    }

    /**
     * Format price with base currency symbol. This method also give ability to encode
     * the base currency symbol and its optional.
     *
     * @param float $price
     * @param bool $isEncoded
     * @return string
     */
    public function formatBasePrice($price = 0, $isEncoded = false)
    {
        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        if ($symbol = $this->getBaseCurrency()->symbol) {
            if ($this->currencySymbol($this->getBaseCurrencyCode()) == $symbol) {
                $content = $formatter->formatCurrency($price, $this->getBaseCurrencyCode());
            } else {
                $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, $symbol);

                $content = $formatter->format($this->convertPrice($price));
            }
        } else {
            $content = $formatter->formatCurrency($price, $this->getBaseCurrencyCode());
        }

        return !$isEncoded ? $content : htmlentities($content);
    }
}
