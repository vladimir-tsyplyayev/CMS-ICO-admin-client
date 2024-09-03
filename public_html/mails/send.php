<?php

set_time_limit(0);

if(file_exists('code.txt')){ $code = file('code.txt');}else{$code[0]='';}
if(!isset($code[0])){$code[0]='';}

if($_POST['snd']==123 || (isset($_GET['snd']) && strcmp($_GET['snd'],trim($code[0]))==0)){

	$mails = file('maillist.txt');

	$i_tmp = file('i.txt');
	$i=(int)trim($i_tmp[0])*1;

//foreach ($mails as $i => $v) {

	$email = explode('|',trim($mails[$i]));


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
  .text{text-align: left;padding: 50px;font-size: 14px;color: #414e53;line-height: 24px;}
  .text p{font-size: 18px;margin: 0;}
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
            <img src="https://ico.domain/images/logo@2x.png" width="50" /><p>ICO</p>
          </div>
        </td>
      </tr>
      <tr>
        <td valign="top" class="text">
          <p>Dear '.$email[1].',<br><br>
          <p>Your KYC application approved and your ETH address accepted for whitelist 40% discount.<br><br>
          <p>ICO tokens crowdsale is now live, so you can signin to ico.domain and start to contribute.</p><br>
          <br>
          <p>Best regards,</p>
          ICO Team<br>
          <br>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" class="btn">
          <a href="https://ico.domain">Sign in</a>
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






	if(mail($email[0], 'Your KYC approved.', $message, $headers)){

		$filec = fopen('sent_'.date("m.d.y").'.txt', 'a');
		fputs ($filec, $email.'
');
		fclose($filec);

		//print($email.'<br>');
	
	}else{
		$filec = fopen('errors_'.date("m.d.y").'.txt', 'a');
		fputs ($filec, $email.'
');
		fclose($filec);

	}
	sleep(rand(10,20));

//}

	$i++;

	if(count($mails)<$i){
		print('Done!');
		$filec = fopen('i.txt', 'w');
		fputs ($filec, '0');
		fclose($filec);
		die;
	}

	$filec = fopen('i.txt', 'w');
	fputs ($filec, $i);
	fclose($filec);


	$new_code = rand(1000,10000);
	$filec = fopen('code.txt', 'w');
	fputs ($filec, $new_code);
	fclose($filec);

	print($i.' - '.$email[0].'<br><script>
	window.location.replace("send.php?snd='.$new_code.'");
	</script>');

}else{
	print('<form method="post"><input name="snd"></form>');
}

?>
