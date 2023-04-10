<?php

namespace uzdevid\click;

use yii\base\Component;
use yii\base\InvalidValueException;

class Click extends Component {
    public $merchant_id;
    public $merchant_user_id;
    public $service_id;
    public $secret_key;

    public $url = 'https://my.click.uz/services/pay';

    public function __construct($config = []) {
        parent::__construct($config);

        if (empty($this->merchant_id))
            throw new InvalidValueException('merchant ID not set or empty');
    }

    public function sendInvoiceByGet($data) {
        $params = [
            'merchant_id' => $this->merchant_id,
            'merchant_user_id' => $this->merchant_user_id,
            'service_id' => $this->service_id,
            'amount' => $data['amount'],
            'transaction_param' => $data['transaction_param'],
            'return_url' => $data['return_url'],
            'card_type' => $data['card_type']
        ];

        $params = http_build_query($params);
        return $this->url . '?' . $params;
    }
}