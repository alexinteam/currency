<?php


namespace App\Libs;


class CurrencyLayer
{
    /**
     * API base URL.
     */
    const ENDPOINT = 'http://apilayer.net/api';

    /**
     * API endpoint parameters.
     */
    private $source = null;
    private $currencies = null;
    private $from = null;
    private $to = null;
    private $amount = null;
    private $date = null;
    private $start_date = null;
    private $end_date = null;
    private $access_key = null;

    /**
     * CurrencyLayer constructor.
     */
    public function __construct()
    {
        $this->access_key = config('services.apilayerKey');
    }
    /**
     * @param $source
     *
     * @return $this
     */
    public function source($source)
    {
        $this->source = $source;
        return $this;
    }
    /**
     * @param $currencies
     *
     * @return $this
     */
    public function currencies($currencies)
    {
        $this->currencies = $currencies;
        return $this;
    }
    /**
     * @param $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }
    /**
     * @param $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }
    /**
     * @param $amount
     *
     * @return $this
     */
    public function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * @param $date
     *
     * @return $this
     */
    public function date($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Request the API's "live" endpoint.
     *
     * @return array
     */
    public function live()
    {
        return $this->request('/live', [
            'currencies' => $this->currencies,
            'source'     => $this->source,
        ]);
    }

    /**
     * Request the API's "convert" endpoint.
     *
     * @return array
     */
    public function convert()
    {
        return $this->request('/convert', [
            'from'   => $this->from,
            'to'     => $this->to,
            'amount' => $this->amount,
            'date'   => $this->date,
        ]);
    }

    /**
     * Request the API's "change" endpoint.
     *
     * @return array
     */
    public function change()
    {
        return $this->request('/change', [
            'currencies' => $this->currencies,
            'source'     => $this->source,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
        ]);
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
    protected function request(string $endpoint, array $params = []) : array
    {
        $params['access_key'] = $this->access_key;
        $url = self::ENDPOINT . $endpoint . '?' . http_build_query($params);
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
