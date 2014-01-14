<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('LOGIN'   , TRUE);
define('XGP_ROOT',	'./');

$InLogin = TRUE;

include(XGP_ROOT . 'global.php');

includeLang ( 'PUBLIC' );
$parse = $lang;
switch ( $_GET[page] )
{
	case'lostpassword':
		function sendnewpassword($mail)
		{
			global $lang;

			$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $mail ."' LIMIT 1;", 'users', TRUE);

			if (empty($ExistMail['email']))
			{
				message($lang['mail_not_exist'], "index.php?modo=claveperdida",2, FALSE, FALSE);
			}
			else
			{
				$Caracters="aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count=strlen($Caracters);
				$NewPass="";
				$Taille=6;
				srand((double)microtime()*1000000);
				for($i=0;$i<$Taille;$i++)
				{
					$CaracterBoucle=rand(0,$Count-1);
					$NewPass=$NewPass.substr($Caracters,$CaracterBoucle,1);
				}
				$Title 	= $lang['mail_title'];
				$Body 	= $lang['mail_text'];
				$Body  .= $NewPass;
				mail($mail,$Title,$Body);
				$NewPassSql = md5($NewPass);
				$QryPassChange = "UPDATE {{table}} SET ";
				$QryPassChange .= "`password` ='". $NewPassSql ."' ";
				$QryPassChange .= "WHERE `email`='". $mail ."' LIMIT 1;";
				doquery( $QryPassChange, 'users');
			}
		}

		if ( $_POST )
		{
			sendnewpassword ( $_POST['email'] );
			message ( $lang['mail_sended'] , "./" , 2 , FALSE , FALSE );
		}
		else
		{
			$parse['year']		   = date ( "Y" );
			$parse['version']	   = VERSION;
			$parse['forum_url']    = read_config ( 'forum_url' );
			display ( parsetemplate ( gettemplate ( 'public/lostpassword' ) , $parse ) , FALSE , '' , FALSE , FALSE );
		}
	break;
	case 'staff':
		    $parse['year']		   = date ( "Y" );
			$parse['cpyright']     = "by FGServers Productions FGS. All rights reserved";
			$parse['version']	   = VERSION;
			$parse['servername']   = read_config ( 'game_name' );
			$parse['forum_url']    = read_config ( 'forum_url' );
			
			$parse['footer']       = parsetemplate ( gettemplate ( 'public/index_footer' ) , $parse );

			display ( parsetemplate ( gettemplate ( 'public/index_staff' ) , $parse ) , FALSE , '' , FALSE , FALSE );
	break;
	case 'pranger':
		    /*TEST CODE*/
			$query	= doquery ( "SELECT * FROM {{table}} ORDER BY `id`;" , 'banned' );
			
			$i 				= 0;
			$subTemplate	= gettemplate ( 'public/index_pranger_row' );

			while ( $u = mysql_fetch_array ( $query ) )
			{
				$parse['player']	= $u[1];
				$parse['reason']	= $u[2];
				$parse['since']		= date ( "d/m/Y G:i:s" , $u[4] );
				$parse['until']		= date ( "d/m/Y G:i:s" , $u[5] );
				$parse['by']		= $u[6];

				$i++;
	
				$body .= parsetemplate ( $subTemplate , $parse );
			}

			if ( $i == 0 )
			{
				$parse['banned_msg']	.= $lang['bn_no_players_banned'];
			}
			else
			{
				$parse['banned_msg']	.= $lang['bn_exists'] . $i . $lang['bn_players_banned'];
			}

			$parse['banned_players']	= $body;
			
			/*END TEST CODE*/
			$parse['year']		   = date ( "Y" );
			$parse['cpyright']     = "by FGServers Productions FGS. All rights reserved";
			$parse['version']	   = VERSION;
			$parse['servername']   = read_config ( 'game_name' );
			$parse['forum_url']    = read_config ( 'forum_url' );
			
			$parse['footer']       = parsetemplate ( gettemplate ( 'public/index_footer' ) , $parse );

			display ( parsetemplate ( gettemplate ( 'public/index_pranger' ) , $parse ) , FALSE , '' , FALSE , FALSE );
	break;
	default:
		if ($_POST)
		{
			$login = doquery("SELECT `id`,`username`,`password`,`banaday` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' AND `password` = '" . md5($_POST['password']) . "' LIMIT 1", "users", TRUE);

			if($login['banaday'] <= time() && $login['banaday'] != '0')
			{
				doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0' WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
				doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
			}

			if ($login)
			{
				if (isset($_POST["rememberme"]))
				{
					$expiretime = time() + 31536000;
					$rememberme = 1;
				}
				else
				{
					$expiretime = 0;
					$rememberme = 0;
				}

				@include('config.php');
				$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
				setcookie(read_config ( 'cookie_name' ), $cookie, $expiretime, "/", "", 0);

				doquery("UPDATE `{{table}}` SET `current_planet` = `id_planet` WHERE `id` ='".$login["id"]."'", 'users');

				unset ( $dbsettings );
				header ( 'location:game.php?page=overview' );
				exit;
			}
			else
			{
				message ( $lang['login_error'] , "./" , 1 , FALSE , FALSE );
			}
		}
		else
		{
			$online_users             = doquery("SELECT COUNT(DISTINCT(id)) as `onlinenow` FROM {{table}} WHERE `onlinetime` > '" . (time()-900) ."';", 'users', true);
			$parse['online_users']    = $online_users['onlinenow'] + 4; 
			$reg_users                = doquery('SELECT COUNT(*) as `players` FROM {{table}} WHERE 1', 'users', true);
			$parse['users_amount']    = $reg_users['players'];
			
			if(read_config ( 'game_disable' ) == 1)
			  $parse['online_status'] = "<font color=lime>Online</font>";
			else
			  $parse['online_status'] = "<font color=red>Offline</font>";
			
			$parse['year']		   = date ( "Y" );
			$parse['cpyright']     = "by FGServers Productions FGS. All rights reserved";
			$parse['version']	   = VERSION;
			$parse['servername']   = read_config ( 'game_name' );
			$parse['forum_url']    = read_config ( 'forum_url' );
			
			$parse['footer']       = parsetemplate ( gettemplate ( 'public/index_footer' ) , $parse );

			display ( parsetemplate ( gettemplate ( 'public/index_body' ) , $parse ) , FALSE , '' , FALSE , FALSE );
		}
}
?>