<?php
namespace App\Services;

use App\Exceptions\AllCurrencyApilayerException;

interface CurrencyLayerInterface
{
    /**
     * API base URL.
     */
    const ENDPOINT = 'http://apilayer.net/api';

    /**
     * @param string $endpoint
     * @param array $params
     * @return array
     */
    public function request(string $endpoint, array $params = []) : array;

    /**
     * @return array
     * @throws AllCurrencyApilayerException
     */
    public function all() : array;

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float
     */
    public function convert(string $from, string $to, float $amount) : float;
}
