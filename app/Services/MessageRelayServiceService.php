<?php
namespace App\Services;

class MessageRelayServiceService
{
    protected $soapClient;

    public function __construct()
    {
        $this->soapClient = app('SoapClient', [
            'wsdl' => 'http://vesal.armaghan.net:8080/core/MessageRelayService?wsdl'
        ]);
    }

    public function performRequest($action, $parameters)
    {
        try {
            return $this->soapClient->__soapCall($action, [$parameters]);
        } catch (\SoapFault $e) {
            // Handle exceptions or add logging here
            return null;
        }
    }
}
