<?php

namespace App\Services\Bank\Melat;

use nusoap_client;
use Exception;
use Illuminate\Support\Facades\Config;
use CodeDredd\Soap\Facades\Soap;

//use SoapClient;

class MelatBankPort
{
    protected $soapClient;
    protected $wsdl;
    public $config;
    public $callBackURL;

    public function __construct()
    {
        $this->wsdl = Config('BankMellatPayment.wsdl');
        $this->config = Config('BankMellatPayment');
        $this->callBackURL = 'https://testato.ir/bankport/melat/callback';//$this->config['BankMellatPayment.callBackURL'];
//        $this->soapClient = Soap::baseWsdl($this->wsdl);
        $this->soapClient = Soap::baseWsdl("https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl");
    }

    public function paymentRequest($amount, $orderId, $additionalData = '', $payerId = 0)
    {
        if ($amount && $amount > 100 && $orderId) {
            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'amount' => $amount,
                'localDate' => date("Ymd"),
                'localTime' => date("His"),
                'additionalData' => $additionalData,
                'callBackUrl' => $this->callBackURL,
                'payerId' => $payerId
            ];
            try {
//                $result = $this->soapClient->call('bpPayRequest',$parameters);
                $result = Soap::baseWsdl("https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl")->bpPayRequest($parameters);
                \Log::info('result', ['result is' => $result]);
                dd($result->clientError());
                // Display the result
                $res = explode(',', $result->return);
                if ($res[0] == "0") {
                    return [
                        'result' => true,
                        'res_code' => $res[0],
                        'ref_id' => $res[1]
                    ];
                } else {
                    return [
                        'result' => false,
                        'res_code' => $res[0],
                        'ref_id' => isset($res[1]) ? $res[1] : null
                    ];
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

    }

    public function verifyPayment($orderId, $saleOrderId, $saleReferenceId)
    {
        $this->soapClient = new nusoap_client(Config('BankMellatPayment.wsdl'));

        if ($orderId && $saleOrderId && $saleReferenceId) {

            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'saleOrderId' => $saleOrderId,
                'saleReferenceId' => $saleReferenceId,
            ];

            try {

                // Call the SOAP method
                return $this->soapClient->bpVerifyRequest($parameters);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else
            return false;
    }

}
