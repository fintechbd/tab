<?php

namespace Fintech\Tab\Vendors;

use ErrorException;
use Fintech\Core\Abstracts\BaseModel;
use Fintech\Tab\Contracts\BillPayment;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class SSLUtility implements BillPayment
{
    /**
     * SSLVirtualRecharge configuration.
     *
     * @var array
     */
    private mixed $config;

    /**
     * SSLVirtualRecharge Url.
     *
     * @var string
     */
    private mixed $apiUrl;

    private string $status = 'sandbox';

    private PendingRequest $client;

    private mixed $options;

    /**
     * SSLVirtualRecharge constructor.
     */
    public function __construct()
    {
        $this->config = config('fintech.tab.providers.sslwireless');

        if ($this->config['mode'] === 'sandbox') {
            $this->apiUrl = $this->config[$this->status]['endpoint'];
            $this->status = 'sandbox';

        } else {
            $this->apiUrl = $this->config[$this->status]['endpoint'];
            $this->status = 'live';
        }

        $this->client = Http::withoutVerifying()
            ->baseUrl($this->apiUrl)
            ->acceptJson()
            ->contentType('application/json')
            ->withHeaders([
                'AUTH-KEY' => $this->config[$this->status]['auth_key'],
                'STK-CODE' => $this->config[$this->status]['stk_code'],
            ]);
    }

    /**
     * Method to make a request to the topup service provider
     * for a quotation of the order. that include charge, fee,
     * commission and other information related to order.
     */
    public function requestQuote(BaseModel $order): mixed
    {

        $params = $order->order_data['pay_bill_data'];
        $params['transaction_id'] = $order->order_number;
        $params['utility_auth_key'] = '';
        $params['utility_secret_key'] = '';

        $serviceStat = business()->serviceStat()->list([
            'role_id' => $order->order_data['service_stat_data']['role_id'],
            'service_id' => $order->order_data['service_stat_data']['service_id'],
            'source_country_id' => $order->order_data['service_stat_data']['source_country_id'],
            'destination_country_id' => $order->order_data['service_stat_data']['destination_country_id'],
            'service_vendor_id' => $order->order_data['service_stat_data']['service_vendor_id'],
            'enabled' => true,
            'paginate' => false,
        ])->first();

        if ($serviceStat) {
            $serviceStatData = $serviceStat->service_stat_data ?? [];
            $params['utility_auth_key'] = $serviceStatData['utility_auth_key'] ?? null;
            $params['utility_secret_key'] = $serviceStatData['utility_secret_key'] ?? null;
        }

        return $this->post('/bill-info', $params);
    }

    private function post($url = '', $payload = [])
    {
        $response = $this->client->post($url, $payload)->json();

        if ($response['status'] == 'api_success') {
            return [
                'status' => true,
                'amount' => intval($response['data']['total_amount']),
                'message' => $response['status_title'] ?? null,
                'origin_message' => $response,
            ];
        }

        return [
            'status' => false,
            'amount' => null,
            'message' => $response['status_title'] ?? null,
            'origin_message' => $response,
        ];
    }

    /**
     * Method to make a request to the topup service provider
     * for an execution of the order.
     *
     * @throws ErrorException
     */
    public function executeOrder(BaseModel $order): mixed
    {
        $params = [
            'transaction_id' => $order->order_data[''],
            'utility_auth_key' => $this->options[$order->order_data['']]['utility_auth_key'],
            'utility_secret_key' => $this->options[$order->order_data['']]['utility_secret_key'],
        ];

        return $this->post('/bill-payment', $params);
    }

    /**
     * Method to make a request to the topup service provider
     * for the progress status of the order.
     *
     * @throws ErrorException
     */
    public function orderStatus(BaseModel $order): mixed
    {
        $params = [
            'transaction_id' => $order->order_data[''],
            'utility_auth_key' => $this->options[$order->order_data['']]['utility_auth_key'],
            'utility_secret_key' => $this->options[$order->order_data['']]['utility_secret_key'],
        ];

        return $this->post('/bill-status', $params);
    }

    /**
     * Method to make a request to the topup service provider
     * for the track real-time progress of the order.
     *
     * @throws ErrorException
     */
    public function trackOrder(BaseModel $order): mixed
    {
        $params = [
            'transaction_id' => $order->order_data[''],
            'utility_auth_key' => $this->options[$order->order_data['']]['utility_auth_key'],
            'utility_secret_key' => $this->options[$order->order_data['']]['utility_secret_key'],
        ];

        return $this->post('/bill-status', $params);
    }

    /**
     * Method to make a request to the topup service provider
     * for the cancellation of the order.
     *
     * @throws ErrorException
     */
    public function cancelOrder(BaseModel $order): mixed
    {
        $params = [
            'transaction_id' => $order->order_data[''],
            'utility_auth_key' => $this->options[$order->order_data['']]['utility_auth_key'],
            'utility_secret_key' => $this->options[$order->order_data['']]['utility_secret_key'],
        ];

        return $this->post('/bill-cancel', $params);
    }

    private function get($url = '', $payload = [])
    {
        return $this->client->get($url, $payload)->json();

    }
}
