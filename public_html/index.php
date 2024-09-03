<?php

set_time_limit(0);

$path = '../';

require_once('include/auth.php');

?>
<!DOCTYPE HTML>
<html lang="en" dir="ltr">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <title>ICO</title>
  <meta name="Description" content="Cryptocurrency based token on Blockchain">
  <meta name="Author" content="ICO">

  <meta property="og:site_name" content="ICO">
  <meta property="og:type" content="website">
  <meta property="og:title" content="ICO">
  <meta property="og:url" content="https://ico.domain">
  <meta property="og:image" content="/images/og_image.jpg" >
  <meta property="og:description" content="Cryptocurrency based token on Blockchain">
  <meta name="csrf-token" content="" />

  <link rel="icon" type="image/png" href="images/favicon-16.png" sizes="16x16">
  <link rel="icon" type="image/png" href="images/favicon-32.png" sizes="32x32">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=0, maximum-scale=1" />

  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js'></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <script type="text/javascript" src="js/countdown.js"></script>
 <?php whitelist_js($presale_start); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link media="all" rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div class="container">

  <div class="header">

    <div class="header_container">

        <div class="logo"><a href="/"><img src="images/logo@2x.png" alt="ICO" height="49px"><b class="l1">ICO</b></a></div>

        <div class="navbar">
          <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
        </div>
          <div class="navbar_block">
            <div class="navbar_item"><a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Whitepaper</a></div>
            <div class="navbar_item"><a href="https://docs.google.com/spreadsheets/d/">Bounty</a></div>
            <div class="navbar_item"><a href="#team">Team</a></div>
            <div class="navbar_item"><a href="https://medium.com/">Blog</a></div>
            <div class="navbar_item"><a href="#faq">FAQ</a></div>
            <div class="navbar_item"><a href="#contacts">Contacts</a></div>
            <div class="navbar_item"><div class="sign_in">
                <?php 
                if($user_founded == 1){
                  print('<i class="fa fa-user-circle-o" aria-hidden="true"></i> <a onclick="changeform(1);$(\'#user_panel\').css(\'display\',\'block\');$(\'#blackbg\').css(\'display\',\'block\');">User panel <i class="fa fa-chevron-down" aria-hidden="true"></i></a>');
                }else{
                  print("<a href=\"#\" onclick=\"changeform(1);$('#signin').css('display','block');$('#blackbg').css('display','block');\">Sign In/Up</a>");
                }
                ?>
            </div></div>
            <div class="navbar_item"><a href="/">EN</a></div>
            <div class="navbar_item"><a href="/ru">RU</a></div>
          </div>
        

        <div class="header_right">
            <div class="lang">
                <a href="#!">EN <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                <div class="langs">
                    <a href="/">EN</a>
                    <a href="/ru">RU</a>
                </div>
            </div>
            <div class="sign_in">
                <?php 
                if($user_founded == 1){
                  print('<i class="fa fa-user-circle-o" aria-hidden="true"></i> <a onclick="changeform(1);$(\'#user_panel\').css(\'display\',\'block\');$(\'#blackbg\').css(\'display\',\'block\');">User panel <i class="fa fa-chevron-down" aria-hidden="true"></i></a>');
                }else{
                  print("<a href=\"#\" onclick=\"changeform(1);$('#signin').css('display','block');$('#blackbg').css('display','block');\">Sign In/Up</a>");
                }
                ?>
            </div>
            <div class="header_menu">
                <ul>
                    <li><a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Whitepaper</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/" target="_blank" rel="nofollow">Bounty</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="https://medium.com/" target="_blank" rel="nofollow">Blog</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contacts">Contacts</a></li>
                </ul>
            </div>
        </div>

    </div>

  </div>

<?php


if(time()-60 > filemtime('sale.txt')){
  $contract_address = '0x...'; // Ethereum Smart-contract address
  
  /*
  // ether Rised
  $request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"to": "'.$contract_address.'", "data": "0xcd72ab69"}, "latest"], "id":1}';
  */
  // Tokens sold
  $request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"to": "'.$contract_address.'", "data": "0x518ab2a8"}, "latest"], "id":1}';

  $response = do_call($geth_host, $geth_port, $request);
  $response2 = json_decode($response,true);
  $token_balance1 = $response2['result'];
  //$sold = hexdec($token_balance1);
  $sold = (hexdec($token_balance1)/1000000000000000000);

  $filec = fopen('sale.txt', 'w');
  fputs ($filec, $sold);
  fclose($filec);
}else{
  $sale_data = file_get_contents('sale.txt');
  $sale_data_ex = explode('|', $sale_data);
  $sold = $sale_data_ex[0];
}

//$for_sale = 5000000;
$for_sale = 6250000;
$for_sale = 43750000;
$for_sale = 55000000;

//$percent = sprintf("%d%%", $sold / $for_sale * 100);

$percent = round($sold / $for_sale * 1000)/10;
?>




  <div class="devices"></div>
  <div class="intro">
    <div class="slogan">ICO<br>Tokens<br><em>CRYPTOCURRENCY</em></div>
    <div class="presale">
<?php

print('2nd ICO Round is over.');
/*
if($presale_start==2){
  print('1st ICO Round is over.');
}else{
  //print('Pre-sale is live now! 30% Discount.');
  print('2nd ICO Round is live now!<Br>Bonus 10%');
}*/?><br>
 
     <?php /* <div class="sale_targets">Available: <?php print($for_sale - $sold); ?> tokens</div>
*/ ?>
      <div class="rised">
        <div class="sold_num" style="left:<?php if($sold / $for_sale < 0.5){ print($percent.'%');}else{print('calc('.$percent.' - 60px);bottom: 60px;top: unset');} ?>"><?php print(round($sold)); ?></div>
        <div class="sale_target"><?php print($for_sale); ?></div>
        <div class="process">
          <div class="sold" style="width:<?php if($percent>0 && $percent<1){print(($percent+1)); }else{ print($percent);} ?>%"></div>
        </div>
      </div>

    </div>
    <div class="timer">
<?php 

/*
if($presale_start==2){
  print('2nd ICO round start on ');
}else{
  print('2nd ICO round ends on ');
} , 10:00 AM UTC<br>
    <div id="countdown"></div>*/?></div>

    <div class="cryptocurrency"></div>
    <div class="rocket">
      <div class="rocket"></div>
      <div class="smoke"></div>
    </div>
    <canvas></canvas>
  </div>

<?php /*
<div class="stat_block">
  <div class="stat"><div class="stat_value"><?php print($total_advertisers); ?></div><div class="stat_text">Registered advertisers</div></div>
  <div class="stat"><div class="stat_value"><?php print($total_publishers); ?></div><div class="stat_text">Registered publishers</div></div>
  <?php /*
  <div class="stat"><div class="stat_value"><?php print($total_contributors); ?></div><div class="stat_text">Registered contributors</div></div>
  <div class="stat"><div class="stat_value"><?php print($total_users); ?></div><div class="stat_text">Registered users</div></div>
    */ /*?>
  <div class="stat"><div class="stat_value"><?php print(count($kyc_sent)); ?></div><div class="stat_text">Apporoved KYC</div></div>

</div>
*/ ?>


<div class="section blue contact_block" id="contacts">
  <div class="section_container">
        <div class="title_block">
            <h2>Contacts</h2>


                <table class="contact_table" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td>General Contact</td>
                        <td><a href="mailto:">info@ico</a></td>
                    </tr>
                    <tr>
                        <td>Contributors Relations</td>
                        <td><a href="mailto:">info@ico</a></td>
                    </tr>
                    <tr>
                        <td>Bounty Campaign</td>
                        <td><a href="mailto:">info@ico</a></td>
                    </tr>
                    <tr>
                        <td>Press Inquiries</td>
                        <td><a href="mailto:">info@ico</a></td>
                    </tr>
                    <tr>
                        <td>Job</td>
                        <td><a href="mailto:">info@ico</a></td>
                    </tr>
                    </tbody>
                </table>

                <div class="socials">
        <a href="https://t.me/" target="_blank" rel="nofollow"><i class="fa fa-telegram fa-2x" aria-hidden="true"></i></a>
        <a href="https://twitter.com/" target="_blank" rel="nofollow"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
        <a href="https://fb.me/" target="_blank" rel="nofollow"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
        <a href="https://www.linkedin.com/" target="_blank" rel="nofollow"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
        <a href="https://www.reddit.com/" target="_blank" rel="nofollow"><i class="fa fa-reddit fa-2x" aria-hidden="true"></i></a>
        <a href="https://angel.co/" target="_blank" rel="nofollow"><i class="fa fa-angellist fa-2x" aria-hidden="true"></i></a>
        <a href="https://www.youtube.com/" target="_blank" rel="nofollow"><i class="fa fa-youtube-square fa-2x" aria-hidden="true"></i></a>
        <a href="https://medium.com/" target="_blank" rel="nofollow"><i class="fa fa-medium fa-2x" aria-hidden="true"></i></a>
        <a href="https://github.com/" target="_blank" rel="nofollow"><i class="fa fa-github-square fa-2x" aria-hidden="true"></i></a>
                </div>



                    
        </div>
  </div>
</div>



<div class="section footer">
    <div class="section_container">
        <div class="title_block">

          <div class="links">
            <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Privacy policy</a> |
            <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Risk factors</a> |
            <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Legal disclaimers</a> |
            <a href="https://medium.com/" target="_blank" rel="nofollow">Blog</a> |
            <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow" target="_blank" rel="nofollow">Whitepaper</a> |
            <a href="https://docs.google.com/spreadsheets/d/" target="_blank" rel="nofollow">Bounty</a> |
            <a href="#team">Team</a> |
            <a href="#faq">FAQ</a> |
            <?php
            if($user_founded == 0){
              print("<a href=\"#\" onclick=\"changeform(1);$('#signin').css('display','block');$('#blackbg').css('display','block');\">Sign in</a> |");
            }
            ?>
            <a href="#contacts">Contacts</a>
            <div class="langs">
                    <a href="/">EN</a>
                    <a href="/ru">RU</a>
                </div>
          </div>

<p><img src="images/comodo-ssl.png" width="100" /></p>

<p><i class="fa fa-copyright" aria-hidden="true"></i> 2018 ICO</p>

</div>



 </div>
  </div>
</div>



<?php 



if($whitelist_added == 1){

print('
<div id="alert"><a onclick="$(\'#alert\').css(\'display\',\'none\');$(\'#blackbg\').css(\'display\',\'none\');"><i class="fa fa-times" aria-hidden="true"></i></a>
  <p>Your e-mail saved to White List</p>
</div>');

}


if($user_founded == 1){
  require_once('include/user_panel.php');
}

?>

<div id="signin"><a onclick="$('#signin').css('display','none');$('#blackbg').css('display','none');"><i class="fa fa-times" aria-hidden="true"></i></a>
  <p class="signin_form">Authentication</p><p class="register_form">Registration</p><p class="forgot_form">Reset your password</p><p class="forgot_form_new_pass">Enter new password</p>
  <form method="post">
    <div class="input register_form">
      <input type="text" name="name" class="email" placeholder="Full Name (min 4 latin chars)" required>
    </div>
    <div class="input">
      <input type="email" name="login" class="email" placeholder="E-mail" required>
    </div>
    <div class="input" id="pass_form">
      <input type="password" name="pass" class="email" placeholder="Password (min 6 chars)" required>
    </div>
    <div class="input register_form">
      <input type="text" name="contact" class="email" placeholder="Skype, ICQ, Telegram, Viber, Jabber">
    </div>
    <div class="input register_form">
      <input type="text" name="eth" class="email" placeholder="Ethereum address 0x...40 chars..." required>
    </div>
    <div class="input noinput type register_form">
      <input type="radio" name="type" value="2" checked>
      <label>Contributor</label>
      <input type="radio" name="type" value="0">
      <label>Publisher</label>
      <input type="radio" name="type" value="1">
      <label>Advertiser</label>   
    </div>
   <?php /* <div class="input register_form">
      <input type="text" name="invite" class="email" placeholder="Invaite reqired for publishers only" >
    </div> */ ?>
    <div class="input noinput register_form" id="agree">
      <input type="checkbox" class="checkbox" name="agree" /> I read and accepted: <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Privacy policy</a>, <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Whitepaper</a>, <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Risk factors</a>, <a href="https://drive.google.com/file/d/" target="_blank" rel="nofollow">Legal disclaimers</a>, <a href="https://publications.europa.eu/en/publication-detail/-/publication/0bff31ef-0b49-11e5-8817-01aa75ed71a1/language-en" target="_blank" rel="nofollow">Anti-Money-Laundering (AML)</a> conditions. I'm not US or Canada citizen or resident.
    </div>
    <div class="g-recaptcha" data-sitekey="GOOGLE_RECAPTCHA_API_KEY"></div>
    
    <?php
      if(!$forgot_code_ok == 0){
        print('<input type="hidden" name="forgot_code" value="'.$forgot_code_ok.'">');
      }
    ?>
    <input type="submit" class="signin_btn register_form mob_btn" value="Register">
    <input type="submit" class="signin_btn signin_form mob_btn" value="Sign in">
    <input type="submit" class="signin_btn forgot_form mob_btn" value="Reset">
    <input type="submit" class="signin_btn forgot_form_new_pass" value="Save">
    <div class="signin_opt">
      <a href="#!" onclick="changeform(0);" class="signin_form signin_btn mob_btn2" id="register_form">Register</a>
      <a href="#!" onclick="changeform(1);" class="register_form" id="signin_form">Sign in</a>
      <a href="#!" onclick="changeform(2);" id="forgot_form">Forgot password?</a>
    </div>
  </form>
  
</div>




<div id="blackbg"<?php if($whitelist_added == 1){print('style="display:block;"');} ?>></div>

</div>




<?php

if(!isset($_COOKIE['cookiepolicy'])){

print('<div id="cookie_alert"><a onclick="document.cookie=\'cookiepolicy=1\';$(\'#cookie_alert\').css(\'display\',\'none\');"><i class="fa fa-times" aria-hidden="true"></i></a>
  <b>Cookie Policy</b>
  <p>ICO website uses cookies to improve user experience and collect anonymous visitor statistics using Google Analytics. If you continue browsing the website without changing your browser settings, it will be accepted that you are happy to receive all cookies at website.</p>
  <p><a href="https://drive.google.com/file/d/">Learn more</a><a href="#!" class="got_btn" onclick="document.cookie=\'cookiepolicy=1\';$(\'#cookie_alert\').css(\'display\',\'none\');">Got it!</a></p>
</div>');

//setcookie("cookiepolicy", 1);

}

?>


<a class="scrollToTop"></a>



<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-..."></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-...');
</script>

<script type='text/javascript' src='js/main.js'></script>
<?php /*<script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>*/?>

<?php

if(!$forgot_code_ok == 0){

  print("<script type='text/javascript'>
    window.onload = function() {
  changeform(1);
  $('#signin').css('display','block');
  $('#blackbg').css('display','block');
  $('.signin_form').css('display','none');
  $('#forgot_form').css('display','none');
  $('.email').css('display','none');
  $('.input').css('display','none');
  $('input').removeAttr('required');
  $('.input').removeAttr('required');
  $('#pass_form input').attr('required', true);
  $('#pass_form').css('display','block');
  $('#pass_form input').css('display','block');
  $('.forgot_form_new_pass').css('display','block');
  $('#g-recaptcha-response').attr('required', true);
}
  </script>");

}

?>
</body>
</html>

