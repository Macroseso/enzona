<?php

namespace macroseso\api\Payment;
use macroseso\Enzona;

class Payment{
     // crear pago
     public function apiPayment($data)
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
      public function apiPaymentCancel($uuid)
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
       public function apiPaymentComplete($uuid)
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

?>
