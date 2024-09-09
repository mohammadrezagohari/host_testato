<?php
/**
 * Created by PhpStorm.
 * User: Mohamamdreza Gohari
 * Date: 2024/2/25
 * Time: 3:03 AM
 */

/**
 * Return Configuration Provider Laravel for Melat bank
 */
return array(
    'callBackURL' => env('BANK_MELLAT_CALL_BACK_URL', 'https://testato.ir/bankport/melat/callback'),
    'wsdl' => env('BANK_MELLAT_WSDL', 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl'),
    'operationServer' => env('BANK_MELLAT_OPERATION_SERVER', 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat'),
    'userName' => env('BANK_MELLAT_USERNAME', 'taland1399'),
    'userPassword' => env('BANK_MELLAT_USER_PASSWORD', '97476144'),
    'terminalId' => env('BANK_MELLAT_TERMINAL_ID', '5634860')

);
