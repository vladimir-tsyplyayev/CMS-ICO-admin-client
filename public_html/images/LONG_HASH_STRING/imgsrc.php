<?php

set_time_limit(0);

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

$path = '../../';

$id = glob($path.'id/*.txt');

$admin_founded = 0;

if(isset($_GET['loginadmin'])){
    if(isset($_POST["adminpass"]) && !empty($_POST["adminpass"])){
    if(strcmp($_POST["adminpass"],'PASSWORD')==0){
      $admin_founded = 1;
      setcookie("admin",'LONG_HASH_FOR_COOKIE');
    }
  }
}

if(isset($_GET['logout'])){
  setcookie("admin",'');
  $admin_founded = 0;
  print('<script>
  window.location.replace("imgsrc.php");
  </script>');
}else{
  if(isset($_COOKIE["admin"])){
    if(!empty($_COOKIE["admin"])){
      if(strcmp($_COOKIE["admin"],'LONG_HASH_FOR_COOKIE')==0){
          $admin_founded = 1;
      }
    }
  }
}

if($admin_founded == 0){
  if(isset($_GET['loginadmin'])){
    print('<form method=post><input name="adminpass" /></form>');
  }
  die;
}
?>
<!DOCTYPE HTML>
<html lang="en" dir="ltr">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <title>ICO | Admin panel</title>
  <meta name="Description" content="">
  <meta name="Author" content="ICO">

  <meta name="csrf-token" content="" />

  <link rel="icon" type="image/png" href="images/favicon-16.png" sizes="16x16">
  <link rel="icon" type="image/png" href="images/favicon-32.png" sizes="32x32">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=0, maximum-scale=1" />

  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js'></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link media="all" rel="stylesheet" type="text/css" href="css/style.css" />
  <style>
  *{font-family: arial;color: #363636;}
.col{} .row{}
table{margin: 0 auto;margin-top: 80px;
margin-bottom: 30px;}
td{font-size: 14px;
padding: 6px 10px;}
tr{}
.gray{background: #ebf2f9;}
img{width: 500px;}
.header{position: fixed;
width: calc(100% - 20px);
height: 50px;
background: #fff;
top: 0;
padding: 10px;
left: 0;}
.btn{display: block;
background: #3b7ec2;
width: 62px;
border-radius: 6px;
color: #fff;
text-decoration: none;
font-size: 12px;
text-align: center;
padding: 5px;}
.logout{float: right;position: fixed;
top: 25px;
right: 25px;}
.top{background: #6198cf;}
.top td{color: #fff}
.filter{margin: 0 6px;
border: 1px solid #e9e9e9;
border-radius: 3px;
padding: 13px;
background: #f9fcff;float: left;}
.small{font-size: 10px}
.pointer{cursor: pointer;}
.results{font-size: 12px;
padding: 9px 16px;}
#popup, #popup2, #popup_email{position: fixed;
top: 77px;
left: 35%;
width: 500px;
background: #fff;
height: 500px;
border: 1px solid #ccc;
border-radius: 10px;
padding: 15px;z-index: 50;display: none;}
#popup textarea, #popup_email textarea{width: 99%;
height: 96%;}
#popup_email textarea{height: 68%;}
#popup_email input{width: 98%;
margin-bottom: 10px;}
#blackbg {
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.3;
    position: fixed;
    z-index: 29;
    display: none;
    top: 0;
}
.fa{
  float: right;
  cursor: pointer;
}
.red{
  color: #de192e;
}
.green{
  color: #34c834;
}
#loading{z-index: 50;
position: fixed;
width: 100px;
height: 100px;
background: #fff9;
top: 40%;
left: 45%;
border-radius: 100%;
display: none;}
#loading i{position: absolute;
top: 20px;
left: 18px;
font-size: 65px;
-webkit-animation:spin 2s linear infinite;
    -moz-animation:spin 2s linear infinite;
    animation:spin 2s linear infinite;
}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
.fa-1x{font-size: 9px;
color: #4999f3;
margin-left: 4px;
margin-top: 4px;}
  </style>
<?php 

/* filters */
$filter = array(100,100,100,100);
if(isset($_GET['whitelist'])){$filter[0]=$_GET['whitelist'];}
if(isset($_GET['KYC'])){$filter[1]=$_GET['KYC'];}
if(isset($_GET['status'])){$filter[2]=$_GET['status'];}
if(isset($_GET['type'])){$filter[3]=$_GET['type'];}
/* filters */

  ?>
</head>
<body>
<div class="container">

  <?php

$whitelist = file('whitelist.txt');

$id = glob($path.'id/*.txt');

print('<form id="table_data"><table cellspacing=0 cellpadding=0>');
  print('<tr class="row top">');
    print('<td class="col"><input type="checkbox" id="select_all"/></td>');
    print('<td class="col">ID</td>');
    print('<td class="col">Login</td>');
    print('<td class="col">Status</td>');
    print('<td class="col">KYC</td>');
    print('<td class="col small">Whitelist</td>');
    print('<td class="col">E-mail</td>');
    print('<td class="col">Name</td>');
    print('<td class="col">Contact</td>');
    print('<td class="col">Token</td>');
    print('<td class="col">ETH</td>');
    print('<td class="col">ETH address</td>');
    print('<td class="col">Type</td>');
    print('<td class="col">Phone</td>');
    print('<td class="col small">Country</td>');
    print('<td class="col">Date</td>');
    print('<td class="col">Age</td>');
  print('</tr>');

foreach($id as $i => $v){
  $id_data = file($v);
  $users_id[trim($id_data[1])] = trim($id_data[0]);
  $filename[trim($id_data[0])] = trim($id_data[0]).trim($id_data[1]);
}
ksort($users_id);

$types = array(0,0,0);

$results = 0;

$col_color = 0;

foreach($users_id as $i => $v){

  if(file_exists($path.'users/'.$filename[$v].'.txt'))
    $user_data[$i] = file($path.'users/'.$filename[$v].'.txt');

  $photo_id[$i] = '';
  $photos = glob($path.'users_id/'.$filename[$v].'_*');
  if(isset($photos[0])){$photo_id[$i] = $photos[0];}

  if(isset($user_data[$i][0])){
  if($user_data[$i][0]){


/* filters */

  $whitelisted_user = '';
  foreach ($whitelist as $wi => $wv) {
      if(strcmp(trim($wv), trim($user_data[$i][1]))==0){
        $whitelisted_user = 1; 
        break;
      }
    }
  $KYC_user = '';
  if(isset($photo_id[$i])) if(strlen($photo_id[$i])>0) $KYC_user = 1;

  if(!isset($user_data[$i][17])) $user_data[$i][17] = '';
  if(!isset($user_data[$i][18])) $user_data[$i][18] = '';
  if(!isset($user_data[$i][19])) $user_data[$i][19] = '';

  if(
      ( ($filter[0]==0 && !$whitelisted_user == 1) ||
        ($filter[0]==1 && $whitelisted_user == 1) ||
        ($filter[0]==2 && $whitelisted_user == 1 && !strcmp('1',trim($user_data[$i][19]))==0) || 
        ($filter[0]==3 && $whitelisted_user == 1 && strcmp('1',trim($user_data[$i][19]))==0) || 
        $filter[0]==100) &&


      ( ($filter[1]==0 && !$KYC_user == 1) || 
        ($filter[1]==2 && $KYC_user == 1) || 
        ($filter[1]==1 && $KYC_user == 1 && !strcmp('1',trim($user_data[$i][17]))==0 && !strcmp('1',trim($user_data[$i][18]))==0) || 
        ($filter[1]==3 && strcmp('1',trim($user_data[$i][17]))==0) || 
        ($filter[1]==4 && strcmp('1',trim($user_data[$i][18]))==0) ||
        $filter[1]==100) &&

      (strcmp($filter[2],trim($user_data[$i][0]))==0 || $filter[2]==100) &&

      (strcmp($filter[3],trim($user_data[$i][7]))==0 || $filter[3]==100)
    )
  {

    $col_color++;

/* filters */




  $results++;

  print('<tr class="row'); if($col_color%2)print(' gray'); print('">');
    print('<td class="col"><input id="'.$filename[$v].'" class="checkbox" type="checkbox">');
    print('<td class="col">'.$i.'</td>');
    print('<td class="col">'.$v.'</td>');
    print('<td class="col">');print($user_data[$i][0]);/*print('<select name="status" onchange="change_status(\''.$filename[$v].'\',this)">');
      print('<option value="0"'); if(isset($user_data[$i][0])) if($user_data[$i][0]==0) print(' selected'); print('>New<option/>');
      print('<option value="1"'); if(isset($user_data[$i][0])) if($user_data[$i][0]==1) print(' selected'); print('>Email<option/>');
      print('<option value="2"'); if(isset($user_data[$i][0])) if($user_data[$i][0]==2) print(' selected'); print('>KYC<option/>');
      print('<option value="3"'); if(isset($user_data[$i][0])) if($user_data[$i][0]==3) print(' selected'); print('>Active<option/>');
      print('<option value="4"'); if(isset($user_data[$i][0])) if($user_data[$i][0]==4) print(' selected'); print('>Ban<option/>');
    print('</select>');*/print('</td>');

    print('<td class="col" id="kyc_'.$filename[$v].'">'); if($KYC_user == 1) {

      foreach ($photos as $iph => $vph) {
        print('<i id="photo" fn="'.$vph.'" class="fa fa-address-card');

        if(strcmp('1',trim($user_data[$i][17]))==0) print(' red'); 
        if(strcmp('1',trim($user_data[$i][18]))==0) print(' green');

        print('" aria-hidden="true"></i>');
      }

    } print('</td>');

    print('<td class="col" id="wl_'.$filename[$v].'">'); if($whitelisted_user == 1) {print('<i class="fa fa-check');

    if(strcmp('1',trim($user_data[$i][19]))==0) {print(' green');}

    print('" aria-hidden="true"></i>'); } print('</td>');

    print('<td class="col small" id="email_'.$filename[$v].'">'); if(isset($user_data[$i][1])) print(trim($user_data[$i][1])); print('</td>');

    print('<td class="col" id="name_'.$filename[$v].'">'); if(isset($user_data[$i][13])) if(strcmp(trim($user_data[$i][13]),'0')==0){print('Mr. ');}else if(strcmp(trim($user_data[$i][13]),'1')==0){print('Mrs. ');}else{print('Ms. ');} if(isset($user_data[$i][4])) print(trim($user_data[$i][4])); print('</td>');
    print('<td class="col small">'); if(isset($user_data[$i][5])) {
      $contacts = explode('|', $user_data[$i][5]);
      foreach ($contacts as $j => $w) {
        if(strlen(trim($w))>0) print($w.'<br>');
      }
      
    } print('</td>');
    print('<td class="col" id="token_'.$filename[$v].'">'); if(isset($user_data[$i][16])) print($user_data[$i][16]); print('</td>');
    print('<td class="col" id="ethv_'.$filename[$v].'">'); if(isset($user_data[$i][15])) print($user_data[$i][15]); if(isset($user_data[$i][6])) if(strlen(trim($user_data[$i][6]))==42) {print(' <a href="https://ethplorer.io/address/'.trim($user_data[$i][6]).'" target="_blank"><i class="fa fa-external-link-square fa-1x" aria-hidden="true"></i></a>');} print('</td>');
    print('<td class="col small" id="eth_'.$filename[$v].'">'); if(isset($user_data[$i][6])) if(strlen(trim($user_data[$i][6]))==42) {print(trim($user_data[$i][6]));}else{print('<b class="red">'.trim($user_data[$i][6]).'</b>');} print('</td>');
    print('<td class="col">'); if(isset($user_data[$i][7])) print($user_data[$i][7]); print('</td>');
    print('<td class="col small">'); if(isset($user_data[$i][9])) print($user_data[$i][9]); print('</td>');
    print('<td class="col">'); if(isset($user_data[$i][10])) print($user_data[$i][10]); print('</td>');
    print('<td class="col small">'); if(isset($user_data[$i][12])) print(gmdate("d.m.Y H:i", trim($user_data[$i][12]))); print('</td>');
    print('<td class="col">'); if(isset($user_data[$i][14])) print($user_data[$i][14]); print('</td>');


  print('</tr>');
  $types[trim($user_data[$i][7])] ++;
  }
  }
}else{
  print('<tr class="row'); if($i%2)print(' gray'); print('">
    <td class="col">'.$i.'</td>
    <td class="col">'.$filename[$v].'</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    <td class="col">--</td>
    </tr>');
}
}
print('</table></form>');

?>
  <div class="header">
    <div class="filter">
      <form>
        Filter by:

        Whitelist <select name="whitelist">
          <option value="100"<?php if($filter[0]==100) print(' selected'); ?>>All</option>
          <option value="0"<?php if($filter[0]==0) print(' selected'); ?>>No</option>
          <option value="1"<?php if($filter[0]==1) print(' selected'); ?>>Yes</option>
          <option value="2"<?php if($filter[0]==2) print(' selected'); ?>>New</option>
          <option value="3"<?php if($filter[0]==3) print(' selected'); ?>>Active</option>
          </select>

        Status <select name="status">
          <option value="100"<?php if($filter[2]==100) print(' selected'); ?>>All</option>
          <option value="0"<?php if($filter[2]==0) print(' selected'); ?>>Email</option>
          <option value="1"<?php if($filter[2]==1) print(' selected'); ?>>KYC</option>
          <option value="2"<?php if($filter[2]==2) print(' selected'); ?>>Active</option>
          <option value="3"<?php if($filter[2]==3) print(' selected'); ?>>Stoped</option>
          <option value="4"<?php if($filter[2]==4) print(' selected'); ?>>Ban</option>
          </select>

        KYC <select name="KYC">
          <option value="100"<?php if($filter[1]==100) print(' selected'); ?>>All</option>
          <option value="0"<?php if($filter[1]==0) print(' selected'); ?>>No</option>
          <option value="1"<?php if($filter[1]==1) print(' selected'); ?>>New</option>
          <option value="2"<?php if($filter[1]==2) print(' selected'); ?>>Uploaded</option>
          <option value="3"<?php if($filter[1]==3) print(' selected'); ?>>KYC E-mail</option>
          <option value="4"<?php if($filter[1]==4) print(' selected'); ?>>KYC Full</option>
          </select> 

        Type <select name="type">
          <option value="100"<?php if($filter[3]==100) print(' selected'); ?>>All</option>
          <option value="0"<?php if($filter[3]==0) print(' selected'); ?>>Publisher</option>
          <option value="1"<?php if($filter[3]==1) print(' selected'); ?>>Advertiser</option>
          <option value="2"<?php if($filter[3]==2) print(' selected'); ?>>Contributor</option>
          </select> 
        <input type="submit" value="Filter" />
      </form>
    </div>

    <div class="filter">
        Set status <select id="status">
          <option value="100">--</option>
          <option value="0">0 Email</option>
          <option value="1">1 KYC</option>
          <option value="2">2 Active</option>
          <option value="3">3 Stoped</option>
          <option value="4">4 Ban</option>
          </select>
          <input type="button" id="apply" value="Apply" />
          <input type="button" id="refresh" value="Refresh" />
          <input type="button" id="edit" value="Edit" />
          <input type="button" id="copy" value="Copy addresses" />
          E-mail <select id="mail_subj">
          <option value="100">--</option>
          <option value="0">E-mail Approved</option>
          <option value="1">KYC Approved</option>
          <option value="2">Whitelist</option>
          <option value="3">News Sale%</option>
          <option value="4">Token balance</option>
          </select>
          <input type="button" id="email_send" value="Send" />
    </div>

    <div class="filter small results">
      <?php print('Results: '.$results.' of '.count($users_id).'<br>');
print('Publishers '.$types[0].', Advertisers '.$types[1].', Contributors '.$types[2]); ?>
    </div>


    <a href="?logout" class="btn logout">Logout</a>
  </div>




 </div>


<div id="popup"><i class="fa fa-times" id="close" aria-hidden="true"></i><textarea id="eth_data"></textarea></div>

<div id="popup_email"><i class="fa fa-times" id="close3" aria-hidden="true"></i>Subject: <input id="email_subject" /><input id="email_saddresses" />Message: <textarea id="popup_email_data"></textarea><br>Emails to send: <b id="emails_to_send"></b><br><input type="button" id="start_email_sending" value="Start sending" class="btn" /></div>

<div id="popup2"><i class="fa fa-times" id="close2" aria-hidden="true"></i><img /></div>
<div id="loading"><i class="fa fa-spinner" aria-hidden="true"></i></div>
<div id="blackbg"></div>

<script>




$('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    checkboxes.prop('checked', $(this).is(':checked'));
});


$('#apply').click(function() {
  window.alert_data = '';

  $("#table_data input:checkbox").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
        window.alert_data = window.alert_data + $this.attr("id") + "|";
    }
  });

  if($("#status option:selected").val()!=100){
    var new_status = $("#status option:selected").val();
    var data = 'key=dsvniwurh2339rhdsdf&data='+window.alert_data+'&status='+new_status;
    
    $.ajax({
      type: "POST", url: "save.php", data: data, beforeSend: function(){}, complete: function(returnData){}, success: function(html){ 
      } 
    });

  }
  
});


$('#copy').click(function() {
  window.alert_data = '[';
  window.qc = 0;
  $("#table_data input:checkbox").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
      if($this.attr("id")!="select_all"){
        if(window.qc>0){ window.alert_data = window.alert_data + ', ';}
        window.alert_data = window.alert_data + '"' +$("#eth_"+$this.attr("id")).html() + '"';
        window.qc++;
      }
    }
  });
  window.alert_data = window.alert_data + ']';

  $('#eth_data').html(window.alert_data);
  $('#blackbg').css('display','block');
  $('#popup').css('display','block');
});




$('#refresh').click(function() {
  window.alert_data = '';
  window.eth_to_check = 0;

  $("#table_data input:checkbox").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
      if($this.attr("id")!="select_all"){
        window.alert_data = window.alert_data +$("#eth_"+$this.attr("id")).html() + '|' + $this.attr("id") + '||';
        window.eth_to_check ++;
      }
    }
  });

  var data = 'key=vnoi4rfjsdkf430df&data='+window.alert_data;

  $('#blackbg').css('display','block');
  $('#loading').css('display','block');
    
  $.ajax({
    type: "POST", url: "save.php", data: data, beforeSend: function(){}, complete: function(returnData){}, success: function(html){//alert(html);
        $('#blackbg').css('display','none');
        $('#loading').css('display','none');

        var arr = html.split('||');
        
        for (var i = 0; i < arr.length; i++) {
          var arr2 = arr[i].split('|');
          //alert(arr2.length);

          $('#ethv_'+arr2[0]).html(arr2[1]);
          $('#token_'+arr2[0]).html(arr2[2]);

          if(arr2[3]==1){
            $('#kyc_'+arr2[0]+' i').css('color','#de192e');
          }
          if(arr2[4]==1){
            $('#kyc_'+arr2[0]+' i').css('color','#34c834');
          }
          if(arr2[5]==1){
            $('#wl_'+arr2[0]+' i').css('color','#34c834');
          }
        
        }

      }/*,
      timeout: 300*/
  });


  
});





$('td i#photo').click(function() {

  //alert($(this).attr('fn'));

  var imgfilename = 'prox.php?key=dfvm9348tjfsdogifq0234itj&url=' + encodeURIComponent($(this).attr('fn'));

  if(imgfilename.slice(-3)=='pdf'){
    $('#popup2 iframe').css('display','block');
    $('#popup2 img').css('display','none');
  }else{
    $('#popup2 img').css('display','block');
    $('#popup2 img').attr('src', imgfilename);
    $('#popup2 iframe').css('display','none');
  }
  $('#blackbg').css('display','block');
  $('#popup2').css('display','block');
});








$('#email_send').click(function() {
  window.alert_data = '';
  window.emails_to_send = 0;

  $("#table_data input:checkbox").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
      if($this.attr("id")!="select_all"){
        window.alert_data = window.alert_data + $this.attr("id") + '|';
        window.emails_to_send++;
      }
    }
  });

  email_message = '';
  email_subject = '';

  if($('#mail_subj').val()==0){ // E-mail Approved
    email_subject = '[name], your account approved to contribute tokens with limit';
    email_message = 'Congratulations, you account approved for tokens contribution with amount limit not more than 1.5 ETH.[br][br]Your ETH address [eth] was executed by our ICO manager with Crowdsale smart-contract in to ethereum blockchain.[br][br]You can check your ETH address here:[br]https://etherscan.io/address/0x39b948d3f844bb9e0e3b375901bb43d4866ef4bb#readContract[br]At line "50. KYC1" will return "true" with your ETH address.[br][br]To increase your amount limit more than 1.5 ETH please complete KYC with uploading your ID file in User panel on ICO website.[br][br]You can also contribute tokens with discount 30% during pre-ICO from March 8th, 2018 till March 19, 2018.';
  }
  if($('#mail_subj').val()==1){ // KYC Approved
    email_subject = '[name], your KYC approved to contribute tokens';
    email_message = 'Congratulations, you KYC approved for tokens contribution without limits.[br][br]Your ETH address [eth] was executed by our ICO manager with Crowdsale smart-contract in to ethereum blockchain.[br][br]You can check your ETH address here:[br]https://etherscan.io/address/0x39b948d3f844bb9e0e3b375901bb43d4866ef4bb#readContract[br]At line "7. KYC2" will return "true" with your ETH address.[br][br]You can also contribute tokens with discount 30% during pre-ICO from March 8th, 2018 till March 19, 2018.';
  }
  if($('#mail_subj').val()==2){ // Whitelist
    email_subject = '[name], your account approved to contribute tokens with whitelist discount 40%';
    email_message = 'Congratulations, you account approved for tokens contribution with whitelist discount 40%.[br][br]Your ETH address [eth] was executed by our ICO manager with Crowdsale smart-contract in to ethereum blockchain.[br][br]You can check your ETH address here:[br]https://etherscan.io/address/0x39b948d3f844bb9e0e3b375901bb43d4866ef4bb#readContract[br]At line "27. WhiteList" will return "true" with your ETH address.[br][br]You can contribute tokens with whitelist discount 40% during pre-ICO from March 8th, 2018 till March 19, 2018.';
  }
  if($('#mail_subj').val()==3){ // News Sale%
    email_subject = 'First round of ICO starts in less than 1 day with 20% bouns';
    email_message = '1st ICO round start on March 29th. ICO team give to our contributors bouns 20% for 6 250 000 tokens.';
  }
  if($('#mail_subj').val()==4){ // Token balance
    email_subject = '[name], your tokens balance has changed';
    email_message = 'You tokens balance has changed.[br][br]You can check your tokens balance in "User panel" at ICO website or here:[br]https://etherscan.io/token/0x39b948d3f844bb9e0e3b375901bb43d4866ef4bb?a=[eth]';
  }

  



  $('#emails_to_send').html(window.emails_to_send);
  $('#email_subject').attr('value', email_subject);
  $('#email_saddresses').attr('value', window.alert_data);
  $('#popup_email_data').html(email_message);
  $('#blackbg').css('display','block');
  $('#popup_email').css('display','block');
});










$('#start_email_sending').click(function() {

  var data = 'key=xcvn93q48hdfsglsuq34059jzsdg&email_subject=' + $('#email_subject').val() + '&email_mesage=' + $('#popup_email_data').html() + '&data=' + $('#email_saddresses').val();

  $('#emails_to_send').html(window.emails_to_send + '. (Sending now. Please wait.)');

$.ajax({
    type: "POST", url: "save.php", data: data, beforeSend: function(){}, complete: function(returnData){}, success: function(html){


      $('#emails_to_send').html(window.emails_to_send + '. (Sent: ' + html + ')');


    }/*,
    timeout: (window.emails_to_send * 6)*/
  });
});














$("#blackbg").click(function () {
    $(this).css('display','none');
    if($("#popup").is(':visible')){
      $('#popup').css('display','none');
    }
    if($("#popup2").is(':visible')){
      $('#popup2').css('display','none');
    }
    if($("#popup_email").is(':visible')){
      $('#popup_email').css('display','none');
    }
});

$("#close").click(function () {
    if($("#blackbg").is(':visible')){
      $('#blackbg').css('display','none');
    }
    if($("#popup").is(':visible')){
      $('#popup').css('display','none');
    }
});

$("#close2").click(function () {
    if($("#blackbg").is(':visible')){
      $('#blackbg').css('display','none');
    }
    if($("#popup2").is(':visible')){
      $('#popup2').css('display','none');
    }
});

$("#close3").click(function () {
    if($("#blackbg").is(':visible')){
      $('#blackbg').css('display','none');
    }
    if($("#popup_email").is(':visible')){
      $('#popup_email').css('display','none');
    }
});


</script>

</body>
</html>





