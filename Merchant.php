<?php

namespace uzdevid\click;

use Roid\lib\Arr;
use Roid\Modules\Payment\Roid\Roid;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class Merchant extends Controller {
    const SUCCESS = 0;
    const SIGN_CHECK_FAILED = -1;
    const INCORRECT_PARAMETER_AMOUNT = -2;
    const ACTION_NOT_FOUND = -3;
    const ALREADY_PAID = -4;
    const USER_DOES_NOT_EXIST = -5;
    const TRANSACTION_DOES_NOT_EXIST = -6;
    const FAILED_TO_UPDATE_USER = -7;
    const ERROR_IN_REQUEST_FROM_CLICK = -8;
    const TRANSACTION_CANCELLED = -9;

    protected function signString($complete) {
        $arr = [
            Yii::$app->request->post('click_trans_id'),
            Yii::$app->request->post('service_id'),
            self::SECRET_KEY,
            Yii::$app->request->post('merchant_trans_id'),
            $complete ? Yii::$app->request->post('merchant_prepare_id') : '',
            Yii::$app->request->post('amount'),
            Yii::$app->request->post('action'),
            Yii::$app->request->post('sign_time'),
        ];

        return implode('', $arr);
    }

    public function actionPrepare($id, $error = 0, $error_note = 'success') {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [
            'click_trans_id' => Yii::$app->request->post('click_trans_id'),
            'merchant_trans_id' => Yii::$app->request->post('merchant_trans_id'),
            'merchant_prepare_id' => (int)$id,
            'error' => $error,
            'error_note' => $error_note
        ];
        return $this->asJson($response);
    }

    public function actionComplete($id, $error = 0, $error_note = 'success') {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [
            'click_trans_id' => Yii::$app->request->post('click_trans_id'),
            'merchant_trans_id' => Yii::$app->request->post('merchant_trans_id'),
            'merchant_confirm_id' => $id,
            'error' => $error,
            'error_note' => $error_note
        ];
        return $this->asJson($response);
    }
}