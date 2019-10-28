<?php


namespace App\Services;


use App\Exceptions\AllCurrencyApilayerException;
use App\Models\Currency;

class CurrencyService implements CurrencyLayerInterface
{
    /**
     * @var string
     */
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     * @throws AllCurrencyApilayerException
     */
    public function all()  : array
    {
        try {
            $response = $this->request('/live', [
                'source'     => Currency::USD,
                'currencies' => implode(',', Currency::AVAILABLE_CURRENCIES),
            ]);

            return $response['quotes'];
        } catch (\Throwable $e) {
            throw new AllCurrencyApilayerException('getting quotes failed');
        }
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float
     * @throws AllCurrencyApilayerException
     */
    public function convert(string $from, string $to, float $amount): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);
        try {
            $currencies = $this->all();
            if($from == Currency::USD) {
                return $amount * $currencies[Currency::USD . $to];
            } else {
                return $amount * $currencies[Currency::USD . $from] * $currencies[Currency::USD . $to];
            }
        } catch (AllCurrencyApilayerException $e) {
            throw $e;
        }
    }

    /**
     * Execute the API request.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function request(string $endpoint, array $params = []) : array
    {
        $params['access_key'] = $this->key;
        $url = static::ENDPOINT . $endpoint . '?' . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $rsp = json_decode($json, true);
        if (array_key_exists('error', $rsp)) {
            $error = $rsp['error'];
            throw new \InvalidArgumentException($error['info'], $error['code']);
        }

        return $rsp;
    }
}
