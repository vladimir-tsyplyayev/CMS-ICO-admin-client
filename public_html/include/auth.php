<?php

set_time_limit(0);

$whitelist_emails = file(substr($path,3).'images/LONG_HASH_STRING/whitelist.txt');

$whitelist_left = 10000-count($whitelist_emails);

$datetime = new DateTime();
$newTZ = new DateTimeZone("Europe/London");
$datetime->setTimezone( $newTZ );

if($datetime->getTimestamp() > 1520416800){$whitelist_left=0;}

$presale_start=2;

if($datetime->getTimestamp() > 1524736800){$presale_start=1;}

$kyc_sent = glob($path.'users_id/*');
$total_users = (int)file_get_contents($path.'total_users.txt')*1;

$total_publishers = (int)file_get_contents($path.'total_publishers.txt')*1;

$total_advertisers = (int)file_get_contents($path.'total_advertisers.txt')*1;



$whitelist_added = 0;
if($whitelist_left>0){
  if(isset($_POST["whitelist"]) && !empty($_POST["whitelist"])){
    $email = filter_var($_POST['whitelist'], FILTER_VALIDATE_EMAIL);
      if($email){        
        $file = fopen(substr($path,3).'images/LONG_HASH_STRING/whitelist.txt', 'a');
        fputs ($file, trim(strip_tags($_POST["whitelist"])).'
');
        fclose($file);
        $whitelist_added = 1;
        $message = '<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=3Dedge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ICO - activate your account</title>
  <style type="text/css">
  body{height:100%;margin:0;padding:0;width:100%;font-family: arial;line-height: 150%;}
  .tab1{background-color: #f5f5f5;}
  .tab2{background-color: #fff;margin-top: 5px;}
  .tab2 td{height: 65px;}
  .line div{width: 530px;margin-top: 21px;height: 105px;border-bottom: solid 2px #e9e9e9;}
  .line div p{color: #35a2c9;margin: 3px;}
  .text{text-align: left;padding: 50px;font-size: 30px;color: #414e53;line-height: 100%;}
  .btn a{background: #06ae67;color: #fff;font-size: 30px;border-radius: 5px;width: 500px;height: 48px;display: block;text-decoration: none;padding-top: 10px;}
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
            <img src="https://ico.domain/images/logo@2x.png" width="50" /><p>ICO</p>
          </div>
        </td>
      </tr>
      <tr>
        <td valign="top" class="text">
          Hello,<br><br>
          Your e-mail '.$email.' saved to Whitelist.
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

                $headers = "From: ICO <no-reply@ico.domain>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";


                mail($email, 'ICO Whitelist', $message, $headers);
    }
  }
}


$invited = 0;




$user_founded = 0;
$confirmation_email_sent = 0;
$reset_email_sent = 0;
$new_pass_set = 0;
$uid = '';

if(isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])){

  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => array(
        'secret' => 'GOOGLE_RECAPTCHA_SECRET_KEY',
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
      )
  ));
  $resp = curl_exec($curl);
  curl_close($curl);

  if(strpos($resp, '"success": true') !== FALSE){
    if(isset($_POST["login"]) && !empty($_POST["login"])){
      $email = clear_string_e_mail($_POST["login"]);
      $email_filename = clear_string_email($_POST["login"]);
      if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)){
        if(isset($_POST["pass"]) && !empty($_POST["pass"])){
          $password = clear_string_pass($_POST["pass"]);

          if( isset($_POST["name"]) && !empty($_POST["name"]) &&
              isset($_POST["contact"]) && !empty($_POST["contact"]) &&
              isset($_POST["eth"]) && !empty($_POST["eth"]) &&
              isset($_POST["type"]) &&
              isset($_POST["agree"]) && !empty($_POST["agree"])
          ){

           if(!file_exists($path.'id/'.$email_filename.'.txt')){
            // Register

            // Verify POST content
            $name = clear_string_name($_POST["name"]);
            $name_filename = str_replace(' ', '', $name);
            if( strcmp($_POST["agree"],'on')==0 && 
                strlen($password)>5 &&
                strlen($name)>3 &&
                strlen(clear_string($_POST["contact"]))>5 && 
                strlen(clear_string($_POST["eth"]))==42 && 
                ($_POST["type"]==0 || $_POST["type"]==1 || $_POST["type"]==2)
            ){
              // Save new user data

              $total_users = 0;
              if(file_exists($path.'total_users.txt')){
                $total_users = (int)file_get_contents($path.'total_users.txt')*1;
              }
              $total_users++;
              if(file_exists($path.'users/'.$name_filename.$total_users.'.txt')){
                $total_users++;
              }
              $file = fopen($path.'total_users.txt',"w");
              fputs ($file, $total_users);
              fclose($file);

              if(strcmp($_POST["type"],'0')==0){
                $total_publishers = 0;
                if(file_exists($path.'total_publishers.txt')){
                  $total_publishers = file_get_contents($path.'total_publishers.txt')*1+1;
                }
                $file = fopen($path.'total_publishers.txt',"w");
                fputs ($file, $total_publishers);
                fclose($file);
              }
              if(strcmp($_POST["type"],'1')==0){
                $total_advertisers = 0;
                if(file_exists($path.'total_advertisers.txt')){
                  $total_advertisers = file_get_contents($path.'total_advertisers.txt')*1+1;
                }
                $file = fopen($path.'total_advertisers.txt',"w");
                fputs ($file, $total_advertisers);
                fclose($file);
              }
              if(strcmp($_POST["type"],'2')==0){
                $total_contributors = 0;
                if(file_exists($path.'total_contributors.txt')){
                  $total_contributors = file_get_contents($path.'total_contributors.txt')*1+1;
                }
                $file = fopen($path.'total_contributors.txt',"w");
                fputs ($file, $total_contributors);
                fclose($file);
              }
            
              if(!file_exists($path.'users/'.$name_filename.$total_users.'.txt')){
                $cookie = md5(rand(10,100).md5($email).get_code().md5($name).rand(10,100));
                $confirmation_code = get_code();
                $user_language = clear_string(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0, 2));


                $file = fopen($path.'users/'.$name_filename.$total_users.'.txt',"w");
                fputs ($file, '0
'.$email.'
'.md5($password.$email).'
'.$cookie.'
'.$name.'
'.clear_string($_POST["contact"]).'
'.clear_string($_POST["eth"]).'
'.$_POST["type"].'
'.$confirmation_code.'

'.$user_language.'
1|1|1|1|1|1|1
'.$_SERVER["REQUEST_TIME"].'


');
                fclose($file);

                preg_match_all('#(.*?)\(#i',$_SERVER["HTTP_USER_AGENT"],$browser1);
                preg_match_all('#\)(.*?)#i',$_SERVER["HTTP_USER_AGENT"],$browser2);
                preg_match_all('#\((.*?)\)#i',$_SERVER["HTTP_USER_AGENT"],$os);

                $file = fopen($path.'users_logs/'.$name_filename.$total_users.'.txt',"w");
                fputs ($file, $_SERVER["REQUEST_TIME"].'|
'.$_SERVER["REMOTE_ADDR"].'|
'.clear_string($browser1[1][0]).' '.clear_string($browser2[1][0]).'|
'.clear_string($os[1][0]).'|');
                fclose($file);

                $file = fopen($path.'id/'.$email_filename.'.txt',"w");
                fputs ($file, $name_filename.'
'.$total_users);
                fclose($file);


                $file = fopen($path.'users_emails.txt',"a");
                fputs ($file, $email.'
');
                fclose($file);


                setcookie("hash",$cookie);
                setcookie("uname",$name);
                setcookie("uid",$total_users);
                $user_founded = 1;
                $user_name = $name;
                $user_status = 0;
                $uid = $total_users;

                // send confirm email


                $message = '<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=3Dedge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ICO - activate your account</title>
  <style type="text/css">
  body{height:100%;margin:0;padding:0;width:100%;font-family: arial;line-height: 150%;}
  .tab1{background-color: #f5f5f5;}
  .tab2{background-color: #fff;margin-top: 5px;}
  .tab2 td{height: 65px;}
  .line div{width: 530px;margin-top: 21px;height: 105px;border-bottom: solid 2px #e9e9e9;}
  .line div p{color: #35a2c9;margin: 3px;}
  .text{text-align: left;padding: 50px;font-size: 30px;color: #414e53;line-height: 100%;}
  .btn a{background: #06ae67;color: #fff;font-size: 30px;border-radius: 5px;width: 500px;height: 48px;display: block;text-decoration: none;padding-top: 10px;}
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
            <img src="https://ico.domain/images/logo@2x.png" width="50" /><p>ICO</p>
          </div>
        </td>
      </tr>
      <tr>
        <td valign="top" class="text">
          Hi, '.$name.'!<br><br>
          Click the button below to activate your account.
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" class="btn">
          <a href="https://ico.doamin/index.php?register_code='.$confirmation_code.'&email='.$email.'">Activate account</a>
        </td>
      </tr>
      <tr>
        <td valign="top" align="center" class="link">
          <div>
            If the button doesn\'t work, copy and paste the following link into your browser:<br>
            <a href="https://ico.doamin/index.php?register_code='.$confirmation_code.'&email='.$email.'">https://ico.doamin/index.php?register_code='.$confirmation_code.'&email='.$email.'</a>
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







                $headers = "From: ICO <no-reply@ico.doamin>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";


                mail($email, 'Activate your account', $message, $headers);
                $confirmation_email_sent = 1;

              }

            }

           }

          }else{
            // Login
            if(file_exists($path.'id/'.$email_filename.'.txt')){
              $udata = file($path.'id/'.$email_filename.'.txt');
              if(file_exists($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt')){
                $md = file($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt');
                if(strcmp(trim($md[2]),md5($password.$email))==0){
                  $user_founded = 1;
                  setcookie("hash",trim($md[3]));
                  setcookie("uname",trim($md[4]));
                  setcookie("uid",trim($udata[1]));
                  $user_name = trim($md[4]);
                  $user_status = trim($md[0]);
                  $uid = trim($udata[1]);
                  $name_filename = str_replace(' ', '', trim($md[4]));

                  preg_match_all('#(.*?)\(#i',$_SERVER["HTTP_USER_AGENT"],$browser1);
                  preg_match_all('#\)(.*?)#i',$_SERVER["HTTP_USER_AGENT"],$browser2);
                  preg_match_all('#\((.*?)\)#i',$_SERVER["HTTP_USER_AGENT"],$os);

                  if(file_exists($path.'users_logs/'.trim($udata[0]).trim($udata[1]).'.txt')){
                    $users_logs = file($path.'users_logs/'.trim($udata[0]).trim($udata[1]).'.txt');
                  }
                  $file = fopen($path.'users_logs/'.trim($udata[0]).trim($udata[1]).'.txt',"w");
                  fputs ($file, trim($users_logs[0]).$_SERVER["REQUEST_TIME"].'|
'.trim($users_logs[1]).$_SERVER["REMOTE_ADDR"].'|
'.trim($users_logs[2]).clear_string($browser1[1][0]).' '.clear_string($browser2[1][0]).'|
'.trim($users_logs[3]).clear_string($os[1][0]).'|');
                  fclose($file);

                }
              }
            }
          }


        }else{
          // Reset password

          // Check if email exists in db
          if(file_exists($path.'users_emails.txt')){
            $users_emails = file($path.'users_emails.txt');

            $here = 0;
            foreach ($users_emails as $i => $v) {
              if(strcmp(trim($v), $email)==0){
                $here = 1; break;
              }
            }

            if($here==1){
              // send confirm email
              $confirmation_code = get_code();

              $file = fopen($path.'reset/'.$confirmation_code.'.txt',"w");
              fputs ($file, $email);
              fclose($file);

              $message = 'Confirm your email address to reset password of your ICO account '.$email.'. \n\n https://ico.doamin/index.php?forgot_code='.$confirmation_code;
              $headers = 'From: ICO <verify@ico.doamin>';
              mail($email, 'Confirm reset password of ICO account.', $message, $headers);
              $reset_email_sent = 1;
            }
          }
        }
      }
    }

    // Save new password
    if(isset($_POST['forgot_code']) && !empty($_POST["forgot_code"])){
      if(file_exists($path.'reset/'.clear_string($_POST['forgot_code']).'.txt')){
        if(isset($_POST['pass']) && !empty($_POST["pass"])){
          $password = clear_string_pass($_POST["pass"]);
          $email = file_get_contents($path.'reset/'.clear_string($_POST['forgot_code']).'.txt');
          $email_filename = clear_string_email($email);
          if(file_exists($path.'id/'.$email_filename.'.txt')){
            $udata = file($path.'id/'.$email_filename.'.txt');
            if(file_exists($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt')){
              $md = file($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt');
              $file = fopen($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt',"w");
              foreach ($md as $i => $v) {
                if($i==2){
                  fputs ($file, md5($password.trim($md[1])).'
');
                }else{
                  fputs ($file, trim($v).'
');
                }
              }
              fclose($file);
              $new_pass_set = 1;
            }
          }
        }
      }
    }
  }
}

if(isset($_GET['logout'])){
  setcookie("hash",'0');
  setcookie("uname",'');
  setcookie("uid",'');
  $user_founded = 0;
  print('<script>
  window.location.replace("index.php");
  </script>');
}else{
  if(isset($_COOKIE["hash"]) && isset($_COOKIE["uname"]) && isset($_COOKIE["uid"])){
    if(!empty($_COOKIE["hash"]) && !empty($_COOKIE["uname"]) && !empty($_COOKIE["uid"])){
      $name = clear_string_name($_COOKIE["uname"]);
      $uid = clear_string_name($_COOKIE["uid"]);
      $name_filename = str_replace(' ', '', $name);
      if(file_exists($path.'users/'.$name_filename.$uid.'.txt')){
        $md = file($path.'users/'.$name_filename.$uid.'.txt');
        if(strcmp(trim($md[3]),$_COOKIE["hash"])==0){
          $user_founded = 1;
          $user_name = $name;
          $user_status = trim($md[0]);
        }
      }
    }
  }
}





$email_confirmed = 0;
if(isset($_GET['register_code']) && isset($_GET['email'])){
  $email_filename = clear_string_email($_GET["email"]);
  if(file_exists($path.'id/'.$email_filename.'.txt')){
    $udata = file($path.'id/'.$email_filename.'.txt');
    if(file_exists($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt')){
      $md = file($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt');
      if(strcmp(trim($md[8]),$_GET['register_code'])==0){
        $file = fopen($path.'users/'.trim($udata[0]).trim($udata[1]).'.txt',"w");
        foreach ($md as $i => $v) {
          if($i==0){
            fputs ($file, '1
');
          }else{
            fputs ($file, trim($v).'
');
          }
        }
        fclose($file);
        $email_confirmed = 1;
      }
    }
  }
}


$forgot_code_ok = 0;
if(isset($_GET['forgot_code']) && !empty($_GET["forgot_code"])){
  if(file_exists($path.'reset/'.clear_string($_GET['forgot_code']).'.txt')){
    // Set new password
    $forgot_code_ok = $_GET['forgot_code'];
  }
}





if($user_founded == 1){
  if(isset($_POST['form_id']) && !empty($_POST["form_id"])){
    if(file_exists($path.'users/'.$name_filename.$uid.'.txt')){
      $md = file($path.'users/'.$name_filename.$uid.'.txt');
        
      if($_POST['form_id']==1){

        if(isset($_POST['name']) && !empty($_POST["name"]) &&
          isset($_POST['phone']) &&
          isset($_POST['skype']) &&
          isset($_POST['telegram']) &&
          isset($_POST['viber']) &&
          isset($_POST['icq']) &&
          isset($_POST['jabber']) &&
          isset($_POST['gender']) &&
          isset($_POST['age']) &&
          isset($_POST['country'])
          ){

            $file = fopen($path.'users/'.$name_filename.$uid.'.txt',"w");
            fputs ($file, trim($md[0]).'
'.trim($md[1]).'
'.trim($md[2]).'
'.trim($md[3]).'
'.clear_string_name($_POST["name"]).'
'.clear_string($_POST['skype']).'|'.clear_string($_POST['telegram']).'|'.clear_string($_POST['viber']).'|'.clear_string($_POST['icq']).'|'.clear_string($_POST['jabber']).'
'.trim($md[6]).'
'.trim($md[7]).'
'.trim($md[8]).'
'.clear_string($_POST["phone"]).'
'.clear_string($_POST["country"]).'
'.trim($md[11]).'
'.trim($md[12]).'
'.clear_string($_POST["gender"]).'
'.clear_string($_POST["age"]).'
');
              fclose($file);

        }

        if(@$_FILES['passport']){
          if($_FILES['passport']['error'] === UPLOAD_ERR_OK){
            $expansion = strtolower(pathinfo($_FILES['passport']['name'], PATHINFO_EXTENSION));
            if(strcmp($expansion,'jpg')==0 ||
              strcmp($expansion,'jpeg')==0 || 
              strcmp($expansion,'png')==0 || 
              strcmp($expansion,'pdf')==0){

                move_uploaded_file($_FILES['passport']['tmp_name'], $path.'users_id/'.$name_filename.$uid.'_'.str_replace(' ', '_', $_FILES['passport']['name']));

            }
          }
        }


      }
    
      if($_POST['form_id']==2){

        if(isset($_POST['old_pass']) && !empty($_POST["old_pass"]) &&
          isset($_POST['new_pass']) && !empty($_POST["new_pass"]) &&
          isset($_POST['verify_pass']) && !empty($_POST["verify_pass"])
          ){

          $old_pass = clear_string_pass($_POST["old_pass"]);

          if(strcmp(trim($md[2]),md5($old_pass.trim($md[1])))==0){

            $new_pass = clear_string_pass($_POST["new_pass"]);
            $verify_pass = clear_string_pass($_POST["verify_pass"]);

            if(strcmp($new_pass,$verify_pass)==0){

              $file = fopen($path.'users/'.$name_filename.$uid.'.txt',"w");
              foreach ($md as $i => $v) {
                if($i==2){
                  fputs ($file, md5($new_pass.trim($md[1])).'
');
                }else{
                  fputs ($file, trim($v).'
');
                }
              }
              fclose($file);
            }
          }
        }
      }

      if($_POST['form_id']==3){

        

          $subs = '';
          for ($i=1; $i <= 7; $i++) {
            if(isset($_POST['mail'.$i]) && !empty($_POST['mail'.$i])){
              if(strcmp($_POST['mail'.$i],'on')==0){$subs .= '1|';}
            }else{$subs .= '0|';}
          }

          $file = fopen($path.'users/'.$name_filename.$uid.'.txt',"w");
              foreach ($md as $i => $v) {
                if($i==11){
                  fputs ($file, $subs.'
');
                }else{
                  fputs ($file, trim($v).'
');
                }
              }
          fclose($file);

      }
    }
  }
}




function clear_string($str){
  return trim(str_replace('
','',str_replace(' ','',str_replace('.','',str_replace('/','',str_replace('?','',str_replace('*','',str_replace(':','',strip_tags($str)))))))));
}

function clear_string_e_mail($str){
  return trim(str_replace('
','',str_replace(' ','',str_replace('/','',str_replace('?','',str_replace('*','',str_replace(':','',strip_tags($str))))))));
}

function clear_string_pass($str){
  return trim(str_replace('
','',str_replace(' ','',str_replace('/','',strip_tags($str)))));
}

function clear_string_name($str){
  return trim(str_replace('
','',str_replace('.','',str_replace('/','',str_replace('?','',str_replace('*','',str_replace(':','',strip_tags($str))))))));
}

function clear_string_email($str){
  return trim(str_replace('
','',str_replace(' ','',str_replace('.','_',str_replace('@','_',str_replace('/','',str_replace('?','',str_replace('*','',str_replace(':','',strip_tags($str))))))))));
}

function get_code(){
  $all_letters = '0123456789abcdefghijklmnopqrstuvwxyz';
  $code = '';
  for($i=0;$i<rand(50,70);$i++){
    $code .= substr($all_letters,rand(0,strlen($all_letters)),1);
  }
  return $code;
}




function whitelist_js($presale_start){
  print('<script type="text/javascript">
      window.d=new Date(');
  if($presale_start==1){
    print('1526551200000');
  }
  if($presale_start==2){
      print('1524736800000');
  }

  
  print(');
    </script>');
}



$geth_host = '127.0.0.1';
$geth_port = '3332';//5001';


function do_call($host, $port, $request) {  
    $url = "http://$host:$port/";
    $url = 'https://mainnet.infura.io/INFURA_KEY';
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
    //print('>>>>>>>'.$data);     
    if(curl_errno($ch)){
      //print curl_error($ch);
    }else{
      return $data;
    }
    curl_close($ch);
}

function wei2eth($wei){
    return bcdiv($wei,'1000000000000000000',18);
}



?>