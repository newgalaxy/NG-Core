<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowLeftMenu ()
{
	global $lang, $user, $planetrow;

	$parse					= $lang;
	$parse['dpath']			= DPATH;
	$parse['version']   	= VERSION;
	$parse['servername']	= read_config ( 'game_name' );
	$parse['forum_url']     = read_config ( 'forum_url' );
	$parse['user_rank']     = $user['total_rank'];
	
	//Planet Menu
	$parse['planetlist'] 			= '';
	$ThisUsersPlanets    			= SortUserPlanets ( $user );

	while ($planetrow = mysql_fetch_array($ThisUsersPlanets))
	{
		if ($planetrow["destruyed"] == 0)
		{
			$parse['planetlist'] .= "\n<option ";
			if ($planetrow['id'] == $user['current_planet'])
				$parse['planetlist'] .= "selected=\"selected\" ";
				$parse['planetlist'] .= "value=\"game.php?page=$_GET[page]&amp;gid=$_GET[gid]&amp;cp=".$planetrow['id']."";
				$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
				$parse['planetlist'] .= "&amp;re=0\">";
			if($planetrow['planet_type'] != 3)
				$parse['planetlist'] .= "".$planetrow['name'];
			else
				$parse['planetlist'] .= "".$planetrow['name'] . " (" . $lang['fcm_moon'] . ")";
				$parse['planetlist'] .= "&nbsp;[".$planetrow['galaxy'].":";
				$parse['planetlist'] .= "".$planetrow['system'].":";
				$parse['planetlist'] .= "".$planetrow['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
		}
	}
	
	/*Officiers Improves*/
	$parse['messages_link'] = ($user['rpg_commandant'] > 0) ?"":"&mode=show&messcat=100";
	$parse['empire_link'] 	= ($user['rpg_commandant'] > 0) ?"<tr><td><div align=\"center\"><font color=\"#FFFFFF\"><a href='game.php?page=imperium'>".$lang['lm_empire']."</a></font></div></td></tr>": "";
	/*End Officiers Improves*/
	
	if ($user['authlevel'] == 3){
		$parse['admin_link']	="<div id=\"notice\" style=\"width:97px;margin: 5px; padding: 5px;border: 2px solid #ffd700; text-align: center; font-weight:bold; color: skyblue\">
		<span><a href=\"adm/index.php\" target=\"_top\"> <font color=\"#ffd700\">" . $lang['lm_administration'] . "</font></a></span>";
	}
	elseif ($user['authlevel'] == 2){
		$parse['admin_link']	="<div id=\"notice\" style=\"width:97px;margin: 5px; padding: 5px;border: 2px solid skyblue; text-align: center; font-weight:bold; color: skyblue\">
		<span><a href=\"adm/index.php\" target=\"_top\"> <font color=\"skyblue\">" . $lang['lm_sgo'] . "</font></a></span>";
	}
	elseif ($user['authlevel'] == 1){
		$parse['admin_link']	="<div id=\"notice\" style=\"width:97px;margin: 5px; padding: 5px;border: 2px solid red; text-align: center; font-weight:bold; color: skyblue\">
		<span><a href=\"adm/index.php\" target=\"_top\"> <font color=\"red\">" . $lang['lm_go'] . "</font></a></span>";
	}
	else{
		$parse['admin_link']  	= "";
	}
	
	/*OFFICIERS DB LIMIT CHECK*/
	$kr = doquery("SELECT `id`,`rpg_commandant`, `rpg_geologue`, `rpg_amiral`, `rpg_ingenieur`, `rpg_technocrate` FROM {{table}}","users");		
	while ( $rk = mysql_fetch_array ($kr ) )
	{
		if(time() > $rk['rpg_commandant'] && $rk['rpg_commandant'] != 0){
		doquery("UPDATE {{table}} SET `rpg_commandant`='0' WHERE `id`='".$rk['id']."' LIMIT 1;","users");		
		}if(time() > $rk['rpg_geologue'] && $rk['rpg_geologue'] != 0){
		doquery("UPDATE {{table}} SET `rpg_geologue`='0' WHERE `id`='".$rk['id']."' LIMIT 1;","users");		
		}if(time() > $rk['rpg_amiral'] && $rk['rpg_amiral'] != 0){
		doquery("UPDATE {{table}} SET `rpg_amiral`='0' WHERE `id`='".$rk['id']."' LIMIT 1;","users");		
		}if(time() > $rk['rpg_ingenieur'] && $rk['rpg_ingenieur'] != 0){
		doquery("UPDATE {{table}} SET `rpg_ingenieur`='0' WHERE `id`='".$rk['id']."' LIMIT 1;","users");		
		}if(time() > $rk['rpg_technocrate'] && $rk['rpg_technocrate'] != 0){
		doquery("UPDATE {{table}} SET `rpg_technocrate`='0' WHERE `id`='".$rk['id']."' LIMIT 1;","users");		
		}
	}
	/*FIN OFFICIERS DB LIMIT CHECK*/
	
	$parse['mp_num'] = $user['new_message']; 
	if($user['new_message'] > 0) 
		$parse['mp_num'] = "<font color=red>".$user['new_message']."</font>";
		
	return parsetemplate(gettemplate('general/left_menu'), $parse);
}
?>