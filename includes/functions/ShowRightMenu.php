<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowRightMenu ()
{
	global $lang, $user;

	$parse					= $lang;
	$parse['dpath']			= DPATH;
	$parse['version']   	= VERSION;
	$parse['servername']	= read_config ( 'game_name' );
	$parse['forum_url']     = read_config ( 'forum_url' );
	
	if ($user['rpg_commandant'] > 0){
		$parse['google_ads']	= "";
	}else{
		$parse['google_ads']  	= $lang['google_ads_2'];
	}

	return parsetemplate(gettemplate('general/right_menu'), $parse);
}
?>