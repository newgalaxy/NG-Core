<?php
/**
 * PayPal successfull payment return
 *
 * @version 1.0
 * @author Martin Maly - http://www.php-suit.com
 * @copyright (C) 2008 martin maly
 */
 
 /*
* Copyright (c) 2008 Martin Maly - http://www.php-suit.com
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * Neither the name of the <organization> nor the
*       names of its contributors may be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY MARTIN MALY ''AS IS'' AND ANY
* EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL MARTIN MALY BE LIABLE FOR ANY
* DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
* SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

require_once('./class/paypal.php'); //when needed
require_once('./class/httprequest.php'); //when needed

//Use this form for production server 
//$r = new PayPal(true);

//Use this form for sandbox tests

    $r = new PayPal(true,2);

$final = $r->doPayment();

if ($final['ACK'] == 'Success') {
    $materia = $_GET['materia'];
    if($materia == 5){
  $precio = 4.99;
        $mo =   30000;
    }elseif($materia == 10){
  $precio = 9.99;
        $mo =   75000;
    }elseif($materia == 20){
  $precio = 19.99;
        $mo =   200000;
    }elseif($materia == 40){
  $precio = 49.99;
        $mo =   750000;
    }elseif($materia == 50){
    $precio = 99.99;
        $mo =   1750000;
    }

    //Promocion 35%
    //$mo = $mo *1.15;
    //$pushoverT = time()+ 10*24*60*60;
/* Details example:
Array
(
    [TOKEN] => EC-46K253307T956310E
    [TIMESTAMP] => 2010-12-12T09:38:01Z
    [CORRELATIONID] => cbf9ed77f3dbe
    [ACK] => Success
    [VERSION] => 52.0
    [BUILD] => 1613703
    [EMAIL] => buyer1_1292145548_per@maly.cz
    [PAYERID] => ZMU92MM4SPBHS
    [PAYERSTATUS] => verified
    [FIRSTNAME] => Test
    [LASTNAME] => User
    [COUNTRYCODE] => US
    [CUSTOM] => 10|USD|
)
*/	
	//echo'Añadimos la info a la bd de que es premium';

    define('INSIDE'  , TRUE);
    define('INSTALL' , FALSE);
    
    define('XGP_ROOT', '../../');
	include(XGP_ROOT . 'extension.inc.php');
	include(XGP_ROOT. 'global.php');
	//Process - Accept CALLBACK
	$parse			=	$lang;
    
    $user = intval($_GET['user']);
if($user != ''){    
    //Cogemos info del usuario
    $qryuser = doquery("SELECT darkmatter FROM {{table}} WHERE `id` = '".$user."'", 'users', true);
        
    doquery("UPDATE {{table}} SET `darkmatter`=darkmatter+".$mo." WHERE id=".$user."",
                    'users');
                    
    $qryuser2 = doquery("SELECT `darkmatter`, `id_planet` FROM {{table}} WHERE `id` = '".$user."'", 'users', true); 
	
	//Registrar al control de pagos
	doquery("INSERT INTO {{table}} (`id_player` ,`time` ,`amount` ,`amount_matter`) VALUES ('".$user."', '".time()."', '".$precio."', '".$mo."');","pagos");

$UserWhileLogin		= doquery ( "SELECT `id`, `username` FROM {{table}}", "users" );

while ( $UserList 	= mysql_fetch_array ( $UserWhileLogin ) )
{
	$name[$UserList['id']]	= $UserList['username'];
}

//MENSAJE DE ADQUISICION STAR
		$QryInsertMessage  = "INSERT INTO {{table}} SET ";
		$QryInsertMessage .= "`message_owner` 	= '". $user 	."', ";
		$QryInsertMessage .= "`message_sender` 	= '', ";
		$QryInsertMessage .= "`message_time` 	= '". time() 	."', ";
		$QryInsertMessage .= "`message_type` 	= '100', ";
		$QryInsertMessage .= "`message_from` 	= '', ";
		$QryInsertMessage .= "`message_subject` = 'Informe de Materia Oscura', ";
		$QryInsertMessage .= "`message_text` 	= '".$name[$user]." ha usted a obtenido ".$mo." unidades de Materia Oscura.';";

		doquery( $QryInsertMessage, 'messages');

		$QryUpdateUser  = "UPDATE `{{table}}` SET ";
		$QryUpdateUser .= "`new_message` = `new_message` + 1 ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $user ."';";
		doquery($QryUpdateUser, "users");
//MENSAJE DE ADQUISICION END
}
                    
echo("Compra realizada <a href=\"http://www.newgalaxy.com.ar/game.php?page=overview\">Volver al juego</a>");
} else {

	print_r($final);
}
?>
