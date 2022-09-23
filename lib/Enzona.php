<?php

namespace Enzona;
use enzona\api\Payment;



class Enzona
{


    const SCOPE_PAYMENT = 'enzona_business_payment';
    const SCOPE_QR = 'enzona_business_qr';


    protected $apiRouteToken = 'token';
    protected $apiRoutePayment = 'payment/v1.0.0/payments';
    protected $apiRoutePaymentCancel = 'cancel';
    protected $apiRoutePaymentComplete = 'complete';

    protected $urlSandbox = 'https://apisandbox.enzona.net/';
    protected $urlHost= 'https://api.enzona.net/';
    protected $url = '';

    protected $apiKey = '';

    protected $apiSecret = '';

    protected $accessToken = '';

    protected $username='';
    protected $password='';

    protected $sandBox = false;

    public function __construct($username, $password, $key, $secret, $sandbox)
    {
        $this->username = $username;
        $this->password = $password;
        $this->apiKey = $key;
        $this->apiSecret = $secret;
        $this->url = ($sandbox) ? $this->sandBoxhost : $this->urlHost;
    }


    // Get Token
    public function requestToken()
    {
        $uri = $this->url . $this->apiRouteToken;
        $param = "grant_type=password&username=$this->username&password=$this->password&scope=enzona_business_payment enzona_business_qr";
        //$param = array("grant_type" => "password", "username" => "lrodriguez90", "password" => "Macroseso@0619+", "scope" => "enzona_business_payment enzona_business_qr");

        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic " . base64_encode($this->apiKey . ':' . $this->apiSecret)
        ));

        $result = curl_exec($ch);
        $error = curl_error($ch);
        $erno = curl_errno($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $res = json_decode($result, true);
            foreach ($res as $key => $value) {
                $value = $res['access_token'];
            }
            $response = $value;
            curl_close($ch);
            $this->accessToken=$response;
            return $response;
        } else {
            $response = false;
        }
    }

public function createPayment($data){
    return $this->apiPayment($data);
}
public function cancelPayment($data){
    return $this->apiPaymentCancel($data);
}
public function completePayment($data){
    return $this->apiPaymentComplete($data);
}


}
