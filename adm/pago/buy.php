<?php
/**
 * Pay with PayPal
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
$tiempo =    $_GET['tiempo'];
if($_POST['materia']){
    $materia =  $_POST['materia'];
    $user    =  $_GET['user'];
}else{
    $materia =   $_GET['materia'];
}
require_once('./class/paypal.php'); //where necessary
require_once('./class/httprequest.php'); //where necessary

    define('INSIDE'  , TRUE);
    define('INSTALL' , FALSE);
    define('XGP_ROOT', '../../');
    include(XGP_ROOT . 'global.php');

$idgame  =  intval($_GET['idgame']);
$tiempo =    $_GET['tiempo'];
if($_POST['materia']){
    $materia =  $_POST['materia'];
    //$user    =  $_GET['user'];
}else{
    $materia =   $_GET['materia'];
}
//Use this form for production server 
//$r = new PayPal(true);
$user = $user['id'];

$UserWhileLogin		= doquery ( "SELECT `id`, `username` FROM {{table}}", "users" );

while ( $UserList 	= mysql_fetch_array ( $UserWhileLogin ) )
{
	$name[$UserList['id']]	= $UserList['username'];
}


    $r = new PayPal(true,2);
 
if($materia == '5'){
        $descripcion_compra	=	'30.000 unidades de Materia Oscura para '.$name[$user]." con el ID: ".$user;
    //$precio = 8.5;
  $precio = 4.99;
}elseif($materia == '10'){
        $descripcion_compra	=	'75.000 unidades de Materia Oscura para '.$name[$user]." con el ID: ".$user;
    //$precio = 8.5;
  $precio = 9.99;
}elseif($materia == '20'){
        $descripcion_compra =   '200.000 unidades de Materia Oscura para '.$name[$user]." con el ID: ".$user;
    //$precio = 8.5;
  $precio = 19.99;
}elseif($materia == '40'){
        $descripcion_compra =   '750.000 unidades de Materia Oscura para '.$name[$user]." con el ID: ".$user;
    //$precio = 8.5;
  $precio = 49.99;
}elseif($materia == '50'){
        $descripcion_compra =   '1.750.000 unidades de Materia Oscura para '.$name[$user]." con el ID: ".$user;
    //$precio = 8.5;
    $precio = 99.99;
}


//echo('user'.$user.'idgame:'.$idgame.$descripcion_compra);

$ret = ($r->doExpressCheckout($precio, $descripcion_compra, '', 'USD'));

//An error occured. The auxiliary information is in the $ret array

echo 'Error: ';

print_r($ret);

header('Location: http://www.newgalaxy.com.ar/game.php?page=overview');
?>
