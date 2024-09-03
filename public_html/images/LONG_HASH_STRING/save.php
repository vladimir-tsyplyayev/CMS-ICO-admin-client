<?php

set_time_limit(0);

$path = '../../../';



          function do_call($request) {
            $url = 'https://mainnet.infura.io/YVsQI1RzuAyC6mi5t6Sw';
            $header[] = "Content-type: application/json";
            $header[] = "Content-length: ".strlen($request);
    
            $ch = curl_init();   
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
            $data = curl_exec($ch);  

            if (curl_errno($ch)) {

            }else{
              return $data;
            }
            curl_close($ch);
          }

          function wei2eth($wei){
            return ($wei / 1000000000000000000);
          }




if(isset($_COOKIE["admin"])){
    if(!empty($_COOKIE["admin"])){
      if(strcmp($_COOKIE["admin"],'LONG_HASH_FOR_COOKIE')==0){

if(isset($_POST)){

  if(isset($_POST['key'])){


    // Change status

    if(strcmp("dsvniwurh2339rhdsdf", $_POST['key'])==0){
      if(isset($_POST['data']) && isset($_POST['status'])) {
        if(is_numeric($_POST['status'])){

          $files = explode('|', $_POST['data']);
          foreach ($files as $j => $w) {
            if(strlen(trim($w))>0){
              if(file_exists($path.'users/'.$w.'.txt')){
                $user_data = file($path.'users/'.$w.'.txt');

                $fp = fopen($path.'users/'.$w.'.txt', "w");
                foreach ($user_data as $i => $v) {
                  if($i==0){
                    fputs ($fp, trim(strip_tags($_POST['status'])).'
');
                  }else{
                    fputs ($fp, trim($v).'
');
                  }
                }
                fclose($fp);
              }
            }
          }
        }
      }
    }


    // Get balances

    if(strcmp("vnoi4rfjsdkf430df", $_POST['key'])==0){

      if(isset($_POST['data'])) {

        $eth_data = explode('||', $_POST['data']);

        foreach ($eth_data  as $i => $v) {
         if(strlen(trim($v))>0){

          $eth = explode('|', $v);

          if(strlen($eth[0])==42) {

            $contract_address = '0x...'; // Ethereum Smart-contract address
            $address = $eth[0];

            $balanceof_hash = '0x70a08231'; // Smart-contract functions hashe
            $kyc1_hash = '0xe2aa71c9'; // Smart-contract functions hashe
            $kyc2_hash = '0x21763dce'; // Smart-contract functions hashe
            $whitelist_hash = '0x6bc20157'; // Smart-contract functions hashe

            if(file_exists($path.'users/'.$eth[1].'.txt')){

        
              $sign = $balanceof_hash.'000000000000000000000000'.substr($address, 2);
              $request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"from": "'.$address.'", "to": "'.$contract_address.'", "data": "'.$sign.'"}, "latest"], "id":1}';

              $response = do_call($request);

              $response2 = json_decode($response,true);
              $address_token_balance = hexdec($response2['result'])/1000000000000000000;

              if($address_token_balance < 1 && $address_token_balance > 0){
                if($address_token_balance < 0.1 && $address_token_balance > 0){
                  $address_token_balance = number_format(($address_token_balance), 3, ',', '');
                }else{
                  $address_token_balance = number_format(($address_token_balance), 1, ',', '');
                }
              }else{
                $address_token_balance = number_format(($address_token_balance), 0, ',', '');
              }

              sleep(3);

              $request = '{"jsonrpc":"2.0","method":"eth_getBalance","params":["'.$address.'", "latest"],"id":1}';
              $response = do_call($request);
              $response2 = json_decode($response,true);
              $myhexstring2 = hexdec($response2['result']);
              $eth_balance = wei2eth($myhexstring2);
              $eth_balance = number_format(($eth_balance), 2, ',', '');

              sleep(3);

              $sign = $kyc1_hash.'000000000000000000000000'.substr($address, 2);
              $request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"from": "'.$address.'", "to": "'.$contract_address.'", "data": "'.$sign.'"}, "latest"], "id":1}';
              $response = do_call($request);
              $response2 = json_decode($response,true);
              if(strcmp('0x0000000000000000000000000000000000000000000000000000000000000001',$response2['result'])==0){
                $kyc1 = 1;
              }else{
                $kyc1 = 0;
              }

              sleep(3);

              $sign = $kyc2_hash.'000000000000000000000000'.substr($address, 2);
              $request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"from": "'.$address.'", "to": "'.$contract_address.'", "data": "'.$sign.'"}, "latest"], "id":1}';
              $response = do_call($request);
              $response2 = json_decode($response,true);
              if(strcmp('0x0000000000000000000000000000000000000000000000000000000000000001',$response2['result'])==0){
                $kyc2 = 1;
              }else{
                $kyc2 = 0;
              }

              sleep(3);

              $sign = $whitelist_hash.'000000000000000000000000'.substr($address, 2);
              $request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"from": "'.$address.'", "to": "'.$contract_address.'", "data": "'.$sign.'"}, "latest"], "id":1}';
              $response = do_call($request);
              $response2 = json_decode($response,true);
              if(strcmp('0x0000000000000000000000000000000000000000000000000000000000000001',$response2['result'])==0){
                $whitelist = 1;
              }else{
                $whitelist = 0;
              }

              sleep(3);

            
              $user_data = file($path.'users/'.$eth[1].'.txt');

              $fp = fopen($path.'users/'.$eth[1].'.txt', "w");
              for ($i=0; $i <= 14 ; $i++) { 
                if(isset($user_data[$i])){
                  fputs ($fp, trim($user_data[$i]).'
');
                }else{
                  fputs ($fp, '
');
                }
              }
              fputs ($fp, $eth_balance.'
'.$address_token_balance.'
'.$kyc1.'
'.$kyc2.'
'.$whitelist.'
');
              fclose($fp);

              print($eth[1].'|'.$eth_balance.'|'.$address_token_balance.'|'.$kyc1.'|'.$kyc2.'|'.$whitelist.'||');
            }


          }
        }
       }
      }
    }



    if(strcmp("xcvn93q48hdfsglsuq34059jzsdg", $_POST['key'])==0){
      if(isset($_POST['data']) && isset($_POST['email_subject']) && isset($_POST['email_mesage'])) {

        $sent_emails = 0;
        $fp = fopen('sent_log.txt', "a");

        $files = explode('|', $_POST['data']);
        foreach ($files as $j => $w) {
          if(strlen(trim($w))>0){
            if(file_exists($path.'users/'.$w.'.txt')){
              $user_data = file($path.'users/'.$w.'.txt');
              $email_settings = explode('|', trim($user_data[11]));
              $email_address = trim($user_data[1]);
              $email_name = ucfirst(trim($user_data[4]));
              $email_eth = trim($user_data[6]);
              $subject = str_replace('[name]', $email_name, $_POST['email_subject']);
              $message_text = str_replace('[br]', '<br>', str_replace('[eth]', $email_eth, $_POST['email_mesage']));






$message = '<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=3Dedge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ICO - Whitelist</title>
  <style type="text/css">
  body{height:100%;margin:0;padding:0;width:100%;font-family: arial;line-height: 150%;}
  .tab1{background-color: #f5f5f5;}
  .tab2{background-color: #fff;margin-top: 5px;}
  .tab2 td{height: 65px;}
  .line div{width: 530px;margin-top: 21px;height: 105px;border-bottom: solid 2px #e9e9e9;}
  .line div p{color: #35a2c9;margin: 3px;}
  .text{text-align: left;padding: 50px;font-size: 14px;color: #414e53;line-height: 24px;font-weight: normal;}
  .text p{font-size: 18px;margin: 0;font-weight:normal;}
  .btn a{margin-bottom: 50px;background: #06ae67;color: #fff;font-size: 30px;border-radius: 5px;width: 500px;height: 48px;display: block;text-decoration: none;padding-top: 10px;}
  .btn a:hover{background: #09b61d;}
  .link{border-bottom: solid 2px #e9e9e9;}
  .link div{width: 500px;text-align: left;margin-top: 40px;margin-bottom: 30px;font-size: 17px;}
  .link a{word-wrap: break-word;color: #21b8e6;}
  .footer{background-color: #f5f5f5;font-size: 12px;color: #8c8c8c;padding-top: 16px;}
  .footer div{border-bottom: solid 2px #e9e9e9;width: 550px;height: 60px;padding-bottom: 8px;}
  .footer img{width: 32px;padding: 10px;}
  </style>
</head>
<body>
  <center>
    <table class="tab1" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
      <tr>
        <td align="center" valign="top">
    <table class="tab2" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="600">
      <tr>
        <td valign="top" align="center" class="line">
          <div>
            <img src="/images/logo@2x.png" width="50" /><p>ICO</p>
          </div>
        </td>
      </tr>
      <tr>
        <td valign="top" class="text">
          <p>Dear '.$email_name.',<br><br>
          <p>'. $message_text.'</p><br>
          <br>
          <p>Best regards,</p>
          ICO Team<br>
          <br>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" class="btn">
          <a href="/">Contribute Now!</a>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" class="link">
          This email was sent by ICO for '.$email_name.'.<br><br>
          If you don\'t want to receive these emails in the future, please <a href="/">unsubscribe</a> in "User panel" with changing your settings of email notifications.<br><br>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" class="footer">
          <div>
            <a href="https://twitter.com/ICO"><img src="https://ci5.googleusercontent.com/proxy/eaTwJuECnKmdDb_CAVfrpjs1HnsHmhhv1yUkUvT7uCdiuHnGlMz9RrL9BXAwY8eAWJ3-ePYYeLKIfI32CzbJLwdy8FPO9MhJ5bx0SzUG4dB3lV9Vy95SwR9hhcQLpzuHMQk0JqccJFM=s0-d-e1-ft#https://cdn-images.mailchimp.com/icons/social-block-v2/outline-gray-twitter-48.png" /></a>
            <a href="https://fb.me/ico"><img src="https://ci3.googleusercontent.com/proxy/K-7MO1X4dcTImwIlNmMs2REN5rNHYCXmuAQ-VQfe6pJgGU0Yqes9LwsqW9FRcQii4Wx4Rw1T-kX-XIDfIVoIl-l-i7-o8C7HY3AusTMJugfjUICDmRsIhQKdrQN7aC0hgiDtVHX_n8ww=s0-d-e1-ft#https://cdn-images.mailchimp.com/icons/social-block-v2/outline-gray-facebook-48.png" /></a>
            <a href="/"><img src="https://ci3.googleusercontent.com/proxy/AfViubF5WP_j3rTuhsKqTthZD-kdPG_e60HFqXp2ZtL1PivNBqFyzT18YD_SCWNeNq4dWGgrgi6urNW6FpZGDa8VD2Sr532O2aDWiW_DARkup3iBiONSc8YR6TvzF2hXWXoBrlE=s0-d-e1-ft#https://cdn-images.mailchimp.com/icons/social-block-v2/outline-gray-link-48.png" /></a>
          </div>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" class="footer">
          Copyright © 2018, All rights reserved.
        </td>
      </tr>
    </table>
    </td>
      </tr>
    </table>
  </center>
</body>
</html>';




                $headers = "From: ICO Team <no-reply@ico.domain>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";

              
              if(mail($email_address, $subject, $message, $headers)) {
                $sent_emails++;
                fputs ($fp, $email_address.'|'.$w.'|OK
');
              }else{
                fputs ($fp, $email_address.'|'.$w.'|Error
');
              }
           

              sleep(5);

            }
          }
        }

        fclose($fp);
        print($sent_emails);


      }
    }


  }

}



}}}



?>
