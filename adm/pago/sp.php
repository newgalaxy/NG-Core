<?php

$mo =   intval($_GET['amount']);
$tiempo =   floor($mo/25000);
$_GET['idgame'] =  $_GET['pub0'];

	if($_GET['sid'] == sha1('SeGuRiDaD_MiNiuNiS'.$_GET['uid'].$_GET['amount'].$_GET['pub0'])){
	define('INSIDE'  , true);
	define('INSTALL' , false);
	define('LOGIN'   , true);

	$InLogin = true;

	$xgp_root = '../../';
	include($xgp_root . 'extension.inc.php');
	include($xgp_root . 'common.' . $phpEx);
	//Process - Accept CALLBACK
    $tiemposuma =   $tiempo*24*60*60;
    
    if ($game_config['univip'] > time()){
        $tiempovip  =   $game_config['univip'] + $tiemposuma;
    }else{
        $tiempovip  =   time()+$tiemposuma;
    }

	update_config2("univip",$tiempovip);
	$parse			=	$lang;
	$parse['tiempovip'] 	=		date( 'd/m/Y G:i',$tiempovip); 
    
    $user = intval($_GET['uid']);
    //Cogemos info del usuario
    $qryuser = doquery("SELECT darkmatter FROM {{table}} WHERE `id` = '".$user."'", 'users', true);
        

doquery("UPDATE {{table}} SET `darkmatter`=darkmatter+".$mo." WHERE id=".$user."",
                    'users');
    echo("Transacción procesada correctamente =)");
      $qryuser2 = doquery("SELECT darkmatter FROM {{table}} WHERE `id` = '".$user."'", 'users', true);                
                    
      include($new_esgame_root . "includes/functions/class.phpmailer.php");
            include($new_esgame_root . "includes/functions/class.smtp.php");
  
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            //$mail->Mailer = "smtp";
            $mail->Host = "smtp.sendgrid.net";
            $mail->Port = 587;
            $mail->Username = "XXXXXXXXX";
            $mail->Password = "XXXXXXXXX";
            $mail->From = "XXXXXXXXX@XXXXXXXXX.com";
            $mail->FromName = "XXXXXXXXX - Venta MO";
             
             $mail->AddAddress('XXXXXXXXX@gmail.com');
             $mail->Subject = "Compra MO por XXXXXXXXX - Universo".$lang['idgame'];
             
				$email="El usuario nº".$user." del universo nº".$lang['idgame']." ha completado una oferta de ".$mo." de MO de valor por XXXXXXXXX el día ".date(time())."<br /> Antes de la compra el usuario tenía ".$qryuser['darkmatter']." y despues de la compra tenía".$qryuser2['darkmatter'];
                $mail->MsgHTML($email);
                $mail->IsHTML(true);              
                $mail->Send();    
                    }else{
                        
                        header("Status: 404 Not Found");
                    }
                    
?>