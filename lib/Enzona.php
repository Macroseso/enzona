<?php

namespace macroseso\Enzona;
use macroseso\api\Payment;



class Enzona
{


    const SCOPE_PAYMENT = 'enzona_business_payment';
    const SCOPE_QR = 'enzona_business_qr';


    protected $tokenRoute = 'token';
    protected $apiRoute = 'payment/v1.0.0/payments';
    protected $cancelRoute = 'cancel';
    protected $completeRoute = 'complete';

    protected $sandBoxhost = 'https://apisandbox.enzona.net/';
    protected $host = 'https://api.enzona.net/';
    protected $usedHost = '';

    protected $apiKey = '';

    protected $apiSecret = '';

    protected $accessToken = '';

    protected $username='';
    protected $password='';

    protected $sandBox = false;

    public function __construct($username, $password, $key, $secret, $box)
    {
        $this->username = $username;
        $this->password = $password;
        $this->apiKey = $key;
        $this->apiSecret = $secret;
        $this->sandBox = $box;
        $this->usedHost = ($this->sandBox == true) ? $this->sandBoxhost : $this->host;
    }


    // Get Token
    public function requestToken()
    {
        $uri = $this->usedHost . $this->tokenRoute;
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

    // crear pago
    public function curl($data)
    {

        $body = json_encode($data);
        $uri = $this->usedHost . $this->apiRoute;


        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: Application/json",
            "Authorization: Bearer ".$this->accessToken,
            "Content-Type: Application/json"
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        $erno = curl_errno($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code == 200) {
            $response = json_decode($result);
        } else {
            $response = false;
        }

        return (array)$response;
    }


     // Cancelar  pago
     public function cancel($uuid)
     {
 
         $uri = $this->usedHost . $this->apiRoute .'/'.$uuid.'/'. $this->cancelRoute;
 
 
         $ch = curl_init($uri);
         curl_setopt($ch, CURLOPT_HEADER, false);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_TIMEOUT, 300);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             "Accept: Application/json",
             "Authorization: Bearer ".$this->accessToken,
             "Content-Type: Application/json"
         ));
 
         $result = curl_exec($ch);
         $error = curl_error($ch);
         $erno = curl_errno($ch);
         $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         curl_close($ch);
 
         if ($code == 200) {
             $response = json_decode($result);
         } else {
             $response = false;
         }
 
         return (array)$response;
     }

      // Completar el pago  pago
      public function complete($uuid)
      {
  
          $uri = $this->usedHost . $this->apiRoute .'/'.$uuid.'/'. $this->completeRoute;
  
  
          $ch = curl_init($uri);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_TIMEOUT, 300);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Accept: Application/json",
              "Authorization: Bearer ".$this->accessToken,
              "Content-Type: Application/json"
          ));
  
          $result = curl_exec($ch);
          $error = curl_error($ch);
          $erno = curl_errno($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);
  
          if ($code == 200) {
              $response = json_decode($result);
          } else {
              $response = false;
          }
  
          return (array)$response;
      }
}
