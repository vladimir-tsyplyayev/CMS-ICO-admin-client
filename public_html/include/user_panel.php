<?php

set_time_limit(0);


if(file_exists($path.'users/'.$name_filename.$uid.'.txt')){
  $md = file($path.'users/'.$name_filename.$uid.'.txt');
  $contacts = explode('|', trim($md[5]));

}
if(file_exists($path.'users_logs/'.$name_filename.$uid.'.txt')){
  $log = file($path.'users_logs/'.$name_filename.$uid.'.txt');
}



/*
$whitelist_emails = file(substr($path,3).'images/LONG_HASH_STRING/whitelist.txt');

$whitelist_left = 10000-count($whitelist_emails);
*/
if($whitelist_left>0){
  $address_token_balance = 0;

}else{

$contract_address_to_pay = '0x...'; // Ethereum Smart-contract address

$contract_address = '0x39b948d3f844bb9e0e3b375901bb43d4866ef4bb';  // Ethereum Smart-contract address
$address = trim($md[6]);
$balanceof_hash = '0x70a08231';
$sign = $balanceof_hash.'000000000000000000000000'.substr($address, 2);
$request = '{"jsonrpc":"2.0", "method":"eth_call", "params":[{"from": "'.$address.'", "to": "'.$contract_address.'", "data": "'.$sign.'"}, "latest"], "id":1}';
$response = do_call($geth_host, $geth_port, $request);
$response2 = json_decode($response,true);
$token_balance1 = $response2['result'];
$address_token_balance = hexdec($token_balance1);

if($address_token_balance < 0.00001){
  $address_token_balance = number_format(($address_token_balance), 5, ',', '');
}

}


$TOKENS_rate = 3400;



$photos = glob($path.'users_id/'.$name_filename.$uid.'_*');


 print('<div id="user_panel">
                      <div class="profile_name">
                        <h2>'.$user_name.'</h2>
                        <p>');
 if(isset($md[7])){
  if($md[7]==0) print('Publisher');
  if($md[7]==1) print('Advertiser');
  if($md[7]==2) print('Contributor');
} print(' ID: '.$uid.'</p>
                        <a href="?logout">Logout</a>
                      </div>
                      <div class="navbar_panel">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                      </div>
                      <div class="profile_nav">
                        <div class="profile_nav_item" id="nav_item_2">Tokens <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                        <div class="profile_nav_item" id="nav_item_1">Account <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                        <div class="profile_nav_item" id="nav_item_7">Referrals <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                        <div class="profile_nav_item" id="nav_item_3">Privacy and safety <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                        <div class="profile_nav_item" id="nav_item_4">Password <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                        <div class="profile_nav_item" id="nav_item_5">Email notifications <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                        <div class="profile_nav_item" id="nav_item_6">Your data <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                      </div>
                      <div class="profile_dashboard">
                      <b>1 ETH = 3400 Tokens</b>'); 

/*
    https://ethplorer.io/address/0x
*/
if($whitelist_left<1){ print('<a class="tokens_balance" href="https://etherscan.io/token/'.$contract_address.'?a='.$address.'" target="_blank">Balance: '.number_format(($address_token_balance/1000000000000000000), 0, ',','').' Tokens = '.number_format(($address_token_balance/$TOKENS_rate/1000000000000000000), 3, ',','').' ETH</a>');}
                        print(' <a onclick="$(\'#user_panel\').css(\'display\',\'none\');$(\'#blackbg\').css(\'display\',\'none\');"><i class="fa fa-times" aria-hidden="true"></i></a>
                      </div>
                      <div class="profile_head content_item_1 active">Account (status: '); if(isset($md[0])){
if($md[0]==0){print('e-mail not confirmed');}
if($md[0]==1){print('KYC not confirmed');}
if($md[0]==2){print('Active');}
if($md[0]==3){print('Stoped');}
if($md[0]==4){print('Banned');}
                    } print(')</div>
                      <div class="profile_head content_item_2">Buy Tokens</div>
                      <div class="profile_head content_item_3">Privacy and safety</div>
                      <div class="profile_head content_item_4">Password</div>
                      <div class="profile_head content_item_5">Email notifications</div>
                      <div class="profile_head content_item_6">Your data</div>
                      <div class="profile_head content_item_7">Affiliate program</div>
                      <div class="profile_content">
                        <div class="profile_content_item content_item_1 active">
                          
                            <form method="post" enctype="multipart/form-data">
                              <input type="hidden" name="form_id" value="1" />
                              <table>'); if(isset($md[0])){ if($md[0]==1){print('

                                <tr>
                                  <td class="red">Passport or<br>ID card or<br>Driving license</td><td class="upload_files">');
                              if(strlen($photos[0])>0){
                                print('Uploaded files:<br>');
                                foreach ($photos as $photos_i => $photos_v) {
                                  print('<b>'.str_replace($path.'users_id/'.$name_filename.$uid.'_', '', $photos_v).'</b><br>');
                                }
                                print('<br>');
                              }
                              print('<div class="passport_container"><input name="passport" class="item_input passport" type="file" accept=".jpg, .jpeg, .png, .pdf" />
<div class="passport_bg">
<i class="fa fa-id-card fa-3x" aria-hidden="true"></i> <p>.jpg, .png or .pdf<br>should be more than 500kb, 300DPI</p> <label class="passport-button">Select File</label></div>
                                  </div></td>
                                </tr>');
                                }}

                                print('<tr>
                                  <td>Full name</td><td><input name="name" class="item_input" value="'.$user_name.'"/></td>
                                </tr><tr>
                                  <td>Email</td><td><input class="item_input" value="'); if(isset($md[1])){print(trim($md[1]).'" readonly ');}else{print('" placeholder="Add a E-mail"');}; print('/><a onclick="window.alert(this.title);" title="If you would like to change your email address, please contact support."><i class="fa fa-cog fa-2x" aria-hidden="true"></i></a></td>
                                </tr><tr>
                                  <td>Phone</td><td><input name="phone" class="item_input" value="'); if(isset($md[9])){print(trim($md[9]));}else{print('" placeholder="Add a Phone');}; print('"/></td>
                                </tr><tr>
                                  <td>Ethereum address</td><td><input class="item_input" value="'); if(isset($md[6])){print(trim($md[6]).'" readonly ');}else{print('" placeholder="Add a Ethereum address"');}; print('/><a onclick="window.alert(this.title);" title="If you would like to change your Ethereum address, please contact support."><i class="fa fa-cog fa-2x" aria-hidden="true"></i></a></td>
                                </tr><tr>
                                  <td>Skype</td><td><input name="skype" class="item_input" value="'); if(isset($contacts[0])){print(trim($contacts[0]));}else{print('" placeholder="Add a Skype');}; print('"/></td>
                                </tr><tr>
                                  <td>Telegram</td><td><input name="telegram" class="item_input" value="'); if(isset($contacts[1])){print(trim($contacts[1]));}else{print('" placeholder="Add a Telegram');}; print('"/></td>
                                </tr><tr>
                                  <td>Viber</td><td><input name="viber" class="item_input" value="'); if(isset($contacts[2])){print(trim($contacts[2]));}else{print('" placeholder="Add a Viber');}; print('"/></td>
                                </tr><tr>
                                  <td>ICQ</td><td><input name="icq" class="item_input" value="'); if(isset($contacts[3])){print(trim($contacts[3]));}else{print('" placeholder="Add a ICQ');}; print('"/></td>
                                </tr><tr>
                                  <td>Jabber</td><td><input name="jabber" class="item_input" value="'); if(isset($contacts[4])){print(trim($contacts[4]));}else{print('" placeholder="Add a Jabber');}; print('"/></td>
                                </tr><tr>
                                </tr><tr>
                                  <td>Gender</td><td>
                                  <input type="radio" name="gender" value="0"'); if(isset($md[13])){if(strcmp(trim($md[13]),'0')==0){print(' checked="checked"');}}; print('>
                                  <label>Mr</label>
                                  <input type="radio" name="gender" value="1"'); if(isset($md[13])){if(strcmp(trim($md[13]),'1')==0){print(' checked="checked"');}}; print('>
                                  <label>Mrs</label>
                                  <input type="radio" name="gender" value="2"'); if(isset($md[13])){if(strcmp(trim($md[13]),'2')==0){print(' checked="checked"');}}; print('>
                                  <label>Ms</label></td>
                                </tr><tr>
                                </tr><tr>
                                  <td>Age</td><td><input name="age" class="item_input" value="'); if(isset($md[14])){print(trim($md[14]));}else{print('" placeholder="Years old');}; print('"/></td>
                                </tr><tr>
                                  <td>Country</td><td>
                                  <select class="item_input" id="user_country" name="country">');
$country = array("" => "Select the country you live in", "af" => "Afghanistan", "al" => "Albania", "dz" => "Algeria", "ad" => "Andorra", "ao" => "Angola", "ag" => "Antigua &amp; Barbuda", "ar" => "Argentina", "am" => "Armenia", "au" => "Australia", "at" => "Austria", "az" => "Azerbaijan", "bs" => "Bahamas", "bh" => "Bahrain", "bd" => "Bangladesh", "bb" => "Barbados", "by" => "Belarus", "be" => "Belgium", "bz" => "Belize", "bj" => "Benin", "bt" => "Bhutan", "bo" => "Bolivia", "ba" => "Bosnia &amp; Herzegovina", "bw" => "Botswana", "br" => "Brazil", "bn" => "Brunei", "bg" => "Bulgaria", "bf" => "Burkina Faso", "bi" => "Burundi", "kh" => "Cambodia", "cm" => "Cameroon", "ca" => "Canada", "cv" => "Cape Verde", "ky" => "Cayman Islands", "cf" => "Central African Republic", "td" => "Chad", "cl" => "Chile", "co" => "Colombia", "km" => "Comoros", "cg" => "Congo - Brazzaville", "cd" => "Congo - Kinshasa", "ck" => "Cook Islands", "cr" => "Costa Rica", "ci" => "Côte d’Ivoire", "hr" => "Croatia", "cu" => "Cuba", "cy" => "Cyprus", "cz" => "Czech Republic", "dk" => "Denmark", "dj" => "Djibouti", "dm" => "Dominica", "do" => "Dominican Republic", "ec" => "Ecuador", "eg" => "Egypt", "sv" => "El Salvador", "gq" => "Equatorial Guinea", "er" => "Eritrea", "ee" => "Estonia", "et" => "Ethiopia", "fj" => "Fiji", "fi" => "Finland", "fr" => "France", "ga" => "Gabon", "gm" => "Gambia", "ge" => "Georgia", "de" => "Germany", "gh" => "Ghana", "gr" => "Greece", "gd" => "Grenada", "gt" => "Guatemala", "gn" => "Guinea", "gw" => "Guinea-Bissau", "gy" => "Guyana", "ht" => "Haiti", "hn" => "Honduras", "hk" => "Hong Kong SAR China", "hu" => "Hungary", "is" => "Iceland", "in" => "India", "id" => "Indonesia", "ir" => "Iran", "iq" => "Iraq", "ie" => "Ireland", "il" => "Israel", "it" => "Italy", "jm" => "Jamaica", "jp" => "Japan", "jo" => "Jordan", "kz" => "Kazakhstan", "ke" => "Kenya", "ki" => "Kiribati", "xk" => "Kosovo", "kw" => "Kuwait", "kg" => "Kyrgyzstan", "la" => "Laos", "lv" => "Latvia", "lb" => "Lebanon", "ls" => "Lesotho", "lr" => "Liberia", "ly" => "Libya", "li" => "Liechtenstein", "lt" => "Lithuania", "lu" => "Luxembourg", "mo" => "Macau SAR China", "mk" => "Macedonia", "mg" => "Madagascar", "mw" => "Malawi", "my" => "Malaysia", "mv" => "Maldives", "ml" => "Mali", "mt" => "Malta", "mh" => "Marshall Islands", "mr" => "Mauritania", "mu" => "Mauritius", "mx" => "Mexico", "fm" => "Micronesia", "md" => "Moldova", "mc" => "Monaco", "mn" => "Mongolia", "me" => "Montenegro", "ma" => "Morocco", "mz" => "Mozambique", "na" => "Namibia", "nr" => "Nauru", "np" => "Nepal", "nl" => "Netherlands", "nz" => "New Zealand", "ni" => "Nicaragua", "ne" => "Niger", "ng" => "Nigeria", "nu" => "Niue", "no" => "Norway", "om" => "Oman", "pk" => "Pakistan", "pw" => "Palau", "ps" => "Palestinian Territories", "pa" => "Panama", "pg" => "Papua New Guinea", "py" => "Paraguay", "pe" => "Peru", "ph" => "Philippines", "pl" => "Poland", "pt" => "Portugal", "qa" => "Qatar", "ro" => "Romania", "ru" => "Russia", "rw" => "Rwanda", "ws" => "Samoa", "sm" => "San Marino", "st" => "São Tomé &amp; Príncipe", "sa" => "Saudi Arabia", "sn" => "Senegal", "rs" => "Serbia", "sc" => "Seychelles", "sl" => "Sierra Leone", "sg" => "Singapore", "sk" => "Slovakia", "si" => "Slovenia", "sb" => "Solomon Islandså", "so" => "Somalia", "za" => "South Africa", "kr" => "South Korea", "es" => "Spain", "lk" => "Sri Lanka", "kn" => "St. Kitts &amp; Nevis", "lc" => "St. Lucia", "vc" => "St. Vincent &amp; Grenadines", "sr" => "Suriname", "sz" => "Swaziland", "se" => "Sweden", "ch" => "Switzerland", "tw" => "Taiwan", "tj" => "Tajikistan", "tz" => "Tanzania", "th" => "Thailand", "tl" => "Timor-Leste", "tg" => "Togo", "to" => "Tonga", "tt" => "Trinidad &amp; Tobago", "tn" => "Tunisia", "tr" => "Turkey", "tm" => "Turkmenistan", "tc" => "Turks &amp; Caicos Islands", "tv" => "Tuvalu", "ug" => "Uganda", "ua" => "Ukraine", "ae" => "United Arab Emirates", "gb" => "United Kingdom", "us" => "United States", "uy" => "Uruguay", "uz" => "Uzbekistan", "vu" => "Vanuatu", "va" => "Vatican City", "ve" => "Venezuela", "vn" => "Vietnam", "ye" => "Yemen", "zm" => "Zambia", "zw" => "Zimbabwe");
foreach ($country as $i => $v) {
  print('<option value="'.$i.'"');
  if(isset($md[10])){
    if(strcmp(trim($md[10]),$i)==0) print(' selected');
  }
  print('>'.$v.'</option>');
}
print('</select>
                                  </td>
                                </tr><tr>
                                  <td></td><td><input type="submit" class="save_btn" value="Save"></td>
                                </tr>
                              </table>
                        </form>
                      </div>
                      <div class="profile_content_item content_item_2">
                        '); 
if($md[0]==0){print('While your e-mail is not confirmed, Token smart-contract will not accept your transfer. <br>Please check your e-mail box and follow confirmation URL.');}
if($md[0]==1){print('<div class="attention attention_active">Your KYC is not confirmed. Please go to "Account" and upload photo of your Passport or ID card or Driving license and wait for moderator confirmation e-mail.<br><br>While your KYC is not confirmed, ICO smart-contract will accept transfer amount not more than 1.5 ETH from your specified ETH address.</div><br>');}


if($whitelist_left<1){ print('<p>

<img src="https://chart.googleapis.com/chart?cht=qr&chl='.$contract_address_to_pay.'&chs=200x200" />
<br>Copy the address below into your application and send ETH in one payment<br><br>
<a href="https://etherscan.io/address/'.$contract_address_to_pay.'" target="_blank"><i class="fa fa-external-link-square fa-1x" aria-hidden="true"></i> View contract on Etherscan</a></p>

<p class="contract_address"><textarea readonly>'.$contract_address_to_pay.'</textarea></p>


<p>Token receipt time may take from several minutes to half an hour depending on network load<br><br>
You should transfer the necessary sum to ICO smart contract address to get the tokens.<br><br>
You should transfer tokens from the address you own. Tokens come automatically after ETH transfer. Don\'t send ETH from exchanges, use own wallet.<br><br>
The GAS limit should be more than 150000 Gwei</p>
<div class="attention"><b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ATTENTION!</b>
Send ETH directly only from wallets you have total control. If you use the exchange wallets you will not get the ICO tokens. The exchange will get them.</div>');}; print('


                      </div>
                      <div class="profile_content_item content_item_3">
                        <form method=post>
                          <table>
                            <tr>
                              <td class="chb"><input type="checkbox" checked class="checkbox" disabled="disabled" /></td><td>If selected, you agree with <a href="https://drive.google.com/file/d/" target="_blank">Privacy policy</a></td>
                            </tr><tr>
                              <td class="chb"><input type="checkbox" checked class="checkbox" disabled="disabled" /></td><td>If selected, you agree with <a href="https://drive.google.com/file/d/" target="_blank">White paper</a>
                            </tr><tr>
                              <td class="chb"><input type="checkbox" checked class="checkbox" disabled="disabled" /></td><td>If selected, you agree with <a href="https://drive.google.com/file/d/" target="_blank">Risk factors</a></td>
                            </tr><tr>
                              <td class="chb"><input type="checkbox" checked class="checkbox" disabled="disabled" /></td><td>If selected, you agree with <a href="https://drive.google.com/file/d/" target="_blank">Legal disclaimers</a></td>
                            </tr><tr>
                              <td></td><td><input type="submit" disabled="disabled" class="save_btn" value="Save"></td>
                            </tr>
                          </table>
                        </form>
                      </div>
                      <div class="profile_content_item content_item_4">
                      <form method=post>
                        <input type="hidden" name="form_id" value="2" />
                          <table>
                            <tr>
                              <td>Current password</td><td><input type="password" name="old_pass" class="item_input" required></td>
                            </tr><tr>
                              <td>New password</td><td><input type="password" name="new_pass" class="item_input" required></td>
                            </tr><tr>
                              <td>Verify password</td><td><input type="password" name="verify_pass" class="item_input" required></td>
                            </tr><tr>
                              <td></td><td><input type="submit" class="save_btn" value="Save changes"></td>
                            </tr>
                          </table>
                        </form>
                      </div>');
$subsc = array(1,1,1,1,1,1,1);
if(isset($md[11])){
  if(strlen(trim($md[11]))>0){
    $subsc = explode('|', trim($md[11]));
  }
}
                      
                      print('<div class="profile_content_item content_item_5">
                      <form method=post>
                        <input type="hidden" name="form_id" value="3" />
                          <table>
                            <tr>
                              <td colspan="2">Email me when</td>
                            </tr><tr>
                              <td class="chb"><input name="mail1" type="checkbox"'); if(isset($subsc[0])){if($subsc[0]==1){print(' checked');}} print(' class="checkbox" /></td><td>Your tokens balance changing.</td>
                            </tr><tr>
                              <td colspan="2"><br>Email you with</td>
                            </tr><tr>
                              <td class="chb"><input name="mail2" type="checkbox"'); if(isset($subsc[1])){if($subsc[1]==1){print(' checked');}} print(' class="checkbox" /></td><td>News about product and feature updates</td>
                            </tr><tr>
                              <td class="chb"><input name="mail3" type="checkbox"'); if(isset($subsc[2])){if($subsc[2]==1){print(' checked');}} print(' class="checkbox" /></td><td>Tips on getting more out of tokens</td>
                            </tr><tr>
                              <td class="chb"><input name="mail4" type="checkbox"'); if(isset($subsc[3])){if($subsc[3]==1){print(' checked');}} print(' class="checkbox" /></td><td>Things you missed since you last logged into tokens</td>
                            </tr><tr>
                              <td class="chb"><input name="mail5" type="checkbox"'); if(isset($subsc[4])){if($subsc[4]==1){print(' checked');}} print(' class="checkbox" /></td><td>News about tokens on partner products and other third party services</td>
                            </tr><tr>
                              <td class="chb"><input name="mail6" type="checkbox"'); if(isset($subsc[5])){if($subsc[5]==1){print(' checked');}} print(' class="checkbox" /></td><td>Participation in tokens research surveys</td>
                            </tr><tr>
                              <td class="chb"><input name="mail7" type="checkbox"'); if(isset($subsc[6])){if($subsc[6]==1){print(' checked');}} print(' class="checkbox" /></td><td>Tips on tokens business products</td>
                            </tr><tr>
                              <td></td><td><input type="submit" class="save_btn" value="Save changes"></td>
                            </tr>
                          </table>
                        </form>
                      </div>');



                      print('<div class="profile_content_item content_item_7">
                      <form method=post>
                        <input type="hidden" name="form_id" value="7" />
                          <table>');
                            if($invited == 0){
                            
                            print('
                            <tr>
                              <td></td><td>To join affiliate program, please enter invite code below<br><br></td>
                            </tr>
                            <tr>
                              <td></td><td><input name="invite" class="item_input" value="" placeholder="Invite code" /></td>
                            </tr>
                            <tr>
                              <td></td><td><input type="submit" class="save_btn" value="Join"></td>
                            </tr>');

                          }else{

                          }
                          
                          print('</table>
                        </form>
                      </div>');



                      $ip_registration = '';
                      if(isset($log)){
                        $logs[1] = explode('|', trim($log[1]));
                        $ip_registration = $logs[1][0];
                      }

                      print('<div class="profile_content_item content_item_6">
                      <table>
                        <tr>
                          <td>User ID:</td><td># '.$uid.'</td>
                        </tr><tr>
                          <td>Account creation:</td><td>'.date('M d, Y', trim($md[12])).' at '.date('g:i A', trim($md[12])).' '.$ip_registration.'</td>
                        </tr>');

                        if(isset($log)){
                          print('<tr>
                          <td><br>Your devices:</td><td><br>You\'ve logged in with these devices</td>
                        </tr>');
                          foreach ($log as $i => $v) {
                            $logs[$i] = explode('|', trim($v));
                          }
                          $devices = array_unique($logs[3]);
                          $browsers = array_unique($logs[2]);
                          foreach ($devices as $i => $v) {
                            print('<tr>
                          <td></td><td>'.str_replace(';',' ',$v).'</td>
                        </tr>');
                          }
                          print('<tr>
                          <td colspan="2"><br>These are browsers and devices linked to your account besides the ones you use to log in.<br><br></td>
                        </tr><tr>
                          <td>Browsers:</td><td>'.(count($browsers)-1).' browsers</td>
                        </tr><tr>
                          <td>Devices:</td><td>'.(count($devices)-1).' devices</td>
                        </tr><tr>
                          <td colspan="2"><br>Account access history</td>
                        </tr><tr>
                          <td></td><td>See your last '.(count($logs[0])-1).' logins.<br><br></td>
                        </tr>');
                          foreach (array_reverse($logs[0]) as $i => $v) {
                            if(strlen($logs[0][$i])>0 && $i<8){
                              print('<tr>
                                <td>'.date('M d, Y', $logs[0][$i]).' at '.date('g:i A', $logs[0][$i]).'</td><td>'.$logs[1][$i].' '.$logs[2][$i].' '.str_replace(';', ' ', $logs[3][$i]).'</td>
                              </tr>');
                            }
                          }
                        }
                      print('</table>


                      </div>
                    </div>
                  </div>
                ');

?>