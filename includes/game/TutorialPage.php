<?php

/**----------*
* Tutorial original de ogame con las originales recompenzas y comandante.
* Tutorial ByJonaMiX y Powermaster.
*----------*
* Version 1
*----------*
* Mision 5 Finalizada y aumentada la seguridad con Mysql_real_scape_string.
* Mision 6 Reparada y mejorada.
*----------*
* Version 2
*---------*
* Mision 7 Ahora toma el espionaje.
* Mision 8 Reparada.
*----------*
* Version 3
*----------*
* Mision 9 Reparada y reformulada.
* Mision 9 Ahora entrega premio comandante x 3 dias.
* Mision 9 beta time.
*
*/
if(!defined('INSIDE')){ die(header("location:../../"));}

class TutorialPage
{
	function __construct ( $CurrentUser , $CurrentPlanet )
	{
		global $lang, $resource;
		$parse = $lang;
		$parse['dpath'] = DPATH;
		$requer = 0;
		switch ($_GET['mision']){
			
			case 'exit':
				message($lang['tutorial_exit'], 'game.php?page=overview', 5, TRUE, TRUE);
			break;
				
			case 'fin':
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m ] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				
				$template = gettemplate('tutorial/tutorial_fin');
			break;
			
			case 10:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m ] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				
				if($CurrentUser['tut_10_rec'] >= 1){
					$parse['rec'] = 'accept';
					++$requer;
				}else{
					$parse['rec'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 1 and $CurrentUser['tut_10'] == 0){
					doquery("UPDATE {{table}} SET `". $resource[209] ."` = `". $resource[209] ."` + 1 WHERE `id` = '". $CurrentPlanet['id'] ."';", 'planets');
					doquery("UPDATE {{table}} SET `tut_10` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=11', 3);
				}
				
				if($requer == 1 and $CurrentUser['tut_10'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=10&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_10'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_btn_finish'] .'" onclick="window.location = \'game.php?page=tutorial&mision=11\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				
				$template = gettemplate('tutorial/tutorial_10');
			break;
			
			case 9:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'.$m] = 'accept';
					}else{
						$parse['tut_'.$m] = 'delete';
					}
				}
				
				$planets = doquery( "SELECT count(*) AS `total` FROM {{table}} WHERE `id_owner` = '" . $CurrentUser["id"]."';", 'planets', TRUE );
				if($planets['total'] >= 2){
					$parse['colonia'] = 'accept';
					++$requer;
				}else{
					$parse['colonia'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 1 and $CurrentUser['tut_9'] == 0){
					doquery("UPDATE {{table}} SET `rpg_commandant` = '".(time()+(60*60*24*3))."' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					doquery("UPDATE {{table}} SET `tut_9` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=10', 3);
				}
				
				if($requer == 1 and $CurrentUser['tut_9'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=9&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_9'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=10\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				
				$template = gettemplate('tutorial/tutorial_9');
				break;
			
			case 8:
				for($m = 1; $m <= 10; $m++ ){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				$parse['exp_pln'] = ( MAX_PLANET_IN_SYSTEM + 1 );
				if($CurrentUser['tut_8_exp'] >= 1){
					$parse['exp'] = 'accept';
					++$requer;
				}else{
					$parse['exp'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 1 and $CurrentUser['tut_8'] == 0){
					doquery("UPDATE {{table}} SET `". $resource[202] ."` = `". $resource[202] ."` + 5 , `". $resource[205] ."` = `". $resource[205] ."` + 2 WHERE `id` = '". $CurrentPlanet['id'] ."';", 'planets');
					doquery("UPDATE {{table}} SET `tut_8` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=9', 3);
				}
				
				if($requer == 1 and $CurrentUser['tut_8'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=8&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_8'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=9\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				
				$template = gettemplate('tutorial/tutorial_8');
			break;
			
			case 7:
				for($m = 1; $m <= 10; $m++ ){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				if($CurrentPlanet[$resource[210]] >= 1){
					$parse['sond'] = 'accept';
					++$requer;
				}else{
					$parse['sond'] = 'delete';
				}
				if($CurrentUser['tut_7_esp'] >= 1){
					$parse['esp'] = 'accept';
					++$requer;
				}else{
					$parse['esp'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 2 and $CurrentUser['tut_7'] == 0){
					doquery("UPDATE {{table}} SET `". $resource[210] ."` = `". $resource[210] ."` + 2 WHERE `id` = '". $CurrentPlanet['id'] ."';", 'planets');
					doquery("UPDATE {{table}} SET `tut_7` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=8', 3);
				}
				
				if($requer == 2 and $CurrentUser['tut_7'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=7&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_7'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=8\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				$template = gettemplate('tutorial/tutorial_7');
			break;
			
			case 6:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m ] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				if($CurrentPlanet[$resource[22]] >= 1 or $CurrentPlanet[$resource[23]] >= 1 or $CurrentPlanet[$resource[24]] >= 1){
					$parse['alm'] = 'accept';
					++$requer;
				}else{
					$parse['alm'] = 'delete';
				}
				if($CurrentUser['tut_6_mer'] >= 1){
					$parse['mer'] = 'accept';
					++$requer;
				}else{
					$parse['mer'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 2 and $CurrentUser['tut_6'] == 0){
					$rand = mt_rand(22, 24);
					$CurrentPlanet[$resource[$rand]] += 1;
					doquery("UPDATE {{table}} SET `". $resource[$rand] ."` = '". $CurrentPlanet[$resource[$rand]] ."' WHERE `id` = '". $CurrentPlanet['id'] ."';", 'planets');
					doquery("UPDATE {{table}} SET `tut_6` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=7', 3);
				}
				
				if($requer == 2 and $CurrentUser['tut_6'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=6&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_6'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=7\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				
				$template = gettemplate('tutorial/tutorial_6');
			break;
			
			case 5:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				
				if(isset(mysql_real_scape_string($_POST['forum_content'])) and  strpos(mysql_real_scape_string($_POST['forum_content']), read_config (  'forum_url' )) !== FALSE){
					doquery("UPDATE {{table}} SET `tut_5_forum` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
				}
				
				if($CurrentPlanet['name'] != "Planeta Principal" and $CurrentPlanet['name'] != $lang['sys_colo_defaultname']){
					$parse['planet'] = 'accept';
					++$requer;
				}else{
					$parse['planet'] = 'delete';
				}
				if($CurrentUser['tut_5_forum'] == 1){
					$parse['forum'] = 'accept';
					++$requer;
				}else{
					$parse['forum'] = 'delete';
				}
				$buddyrow = doquery( "SELECT count(*) AS `total` FROM {{table}} WHERE `sender` = '" . $CurrentUser["id"]."' OR `owner` = '" . $CurrentUser["id"]."';", 'buddy', true );
				if($buddyrow['total'] >= 1){
					$parse['buddy'] = 'accept';
					++$requer;
				}else{
					$parse['buddy'] = 'delete';
				}
				$allyrow = doquery( "SELECT count(*) AS `total` FROM {{table}} WHERE `ally_id` = '" . $CurrentUser["ally_id"]."';", 'users', true );
				if($CurrentUser['ally_id'] != 0 and $allyrow['total'] >= 4){
					$parse['ally'] = 'accept';
					++$requer;
				}else{
					$parse['ally'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 4 and $CurrentUser['tut_5'] == 0){
					$CurrentUser['darkmatter'] += 3500;
					doquery("UPDATE {{table}} SET `tut_5` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					doquery("UPDATE {{table}} SET `darkmatter` = '". $CurrentUser['darkmatter'] ."' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=6', 3);
				}
				
				if($requer == 4 and $CurrentUser['tut_5'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=5&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_5'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=6\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				$template = gettemplate('tutorial/tutorial_5');
			break;
			
			case 4:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				if($CurrentPlanet[$resource[31]] >= 1){
					$parse['inv_1'] = 'accept';
					++$requer;
				}else{
					$parse['inv_1'] = 'delete';
				}
				if($CurrentUser[$resource[115]] >= 2){
					$parse['comb_2'] = 'accept';
					++$requer;
				}else{
					$parse['comb_2'] = 'delete';
				}
				if($CurrentPlanet[$resource[202]] >= 1){
					$parse['navp_1'] = 'accept';
					++$requer;
				}else{
					$parse['navp_1'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 3 and $CurrentUser['tut_4'] == 0){
					$CurrentPlanet['deuterium'] += 200;
					doquery("UPDATE {{table}} SET `tut_4` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time());
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=5', 3);
				}
				
				if($requer == 3 and $CurrentUser['tut_4'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=4&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}elseif($CurrentUser['tut_4'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=5\'" style="width:150px;height:30px;color:green;" />';
				}else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				$template = gettemplate('tutorial/tutorial_4');
			break;
			
			case 3:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				if($CurrentPlanet[$resource[1]] >= 10){
					$parse['met_10'] = 'accept';
					++$requer;
				}else{
					$parse['met_10'] = 'delete';
				}
				if($CurrentPlanet[$resource[2]] >= 7){
					$parse['cris_7'] = 'accept';
					++$requer;
				}else{
					$parse['cris_7'] = 'delete';
				}
				if($CurrentPlanet[$resource[3]] >= 5){
					$parse['deut_5'] = 'accept';
					++$requer;
				}else{
					$parse['deut_5'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 3 and $CurrentUser['tut_3'] == 0){
					$CurrentPlanet['metal'] += 2000;
					$CurrentPlanet['crystal'] += 500;
					doquery("UPDATE {{table}} SET `tut_3` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time());
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=4', 3);
				}
				
				if($requer == 3 and $CurrentUser['tut_3'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=3&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}
				elseif($CurrentUser['tut_3'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=4\'" style="width:150px;height:30px;color:green;" />';
				}
				else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				$template = gettemplate('tutorial/tutorial_3');
			break;
			
			case 2:
				for($m = 1; $m <= 10; $m++ ){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}elseif($user['tut_'. $m ] == 0){
						$parse['tut_'. $m] = 'delete';
					}
				}
				if($CurrentPlanet[$resource[3]] >= 2){
					$parse['deu_4'] = 'accept';
					++$requer;
				}else{
					$parse['deu_4'] = 'delete';
				}
				if($CurrentPlanet[$resource[14]] >= 2){
					$parse['robot_2'] = 'accept';
					++$requer;
				}else{
					$parse['robot_2'] = 'delete';
				}
				if($CurrentPlanet[$resource[21]] >= 1){
					$parse['han_1'] = 'accept';
					++$requer;
				}else{
					$parse['han_1'] = 'delete';
				}
				if($CurrentPlanet[$resource[401]] >= 1){
					$parse['lanz_1'] = 'accept';
					++$requer;
				}else{
					$parse['lanz_1'] = 'delete';
				}
				
				if($_GET['continue'] == 1 and $requer == 4 and $CurrentUser['tut_2'] == 0){
					doquery("UPDATE {{table}} SET `".$resource[401]."` = `".$resource[401]."` + 1 WHERE `id` = '".$CurrentPlanet['id']."';", 'planets');
					doquery("UPDATE {{table}} SET `tut_2` = '1' WHERE `id` = '".$CurrentUser['id']."';", 'users');
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=3', 3);
				}
				
				if($requer == 4 and $CurrentUser['tut_2'] == 0) {
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=2&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}
				elseif($CurrentUser['tut_2'] == 1) {
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=3\'" style="width:150px;height:30px;color:green;" />';
				}
				else {
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				$template = gettemplate('tutorial/tutorial_2');
			break;
			
			case 1:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_'. $m] == 1){
						$parse['tut_'. $m] = 'accept';
					}else{
						$parse['tut_'. $m] = 'delete';
					}
				}
				if($CurrentPlanet[$resource[1]] >= 4){
					$parse['met_4'] = 'accept';
					++$requer;
				}else{
					$parse['met_4'] = 'delete';
				}
				if($CurrentPlanet[$resource[2]] >= 2){
					$parse['cris_2'] = 'accept';
					++$requer;
				}else{
					$parse['cris_2'] = 'delete';
				}
				if($CurrentPlanet[$resource[4]] >= 4){
					$parse['sol_4'] = 'accept';
					++$requer;
				}else{
					$parse['sol_4'] = 'delete';
				}
				
				if($_GET['continue'] == 1 && $requer == 3 && $CurrentUser['tut_1'] == 0){
					$CurrentPlanet['metal'] += 150;
					$CurrentPlanet['crystal'] += 75;
					doquery("UPDATE {{table}} SET `tut_1` = '1' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
					PlanetResourceUpdate ( $user, $CurrentPlanet, time());
					message('<p style="color:lime;">'. $lang['tutorial_mision_comp'] .'</p>', 'game.php?page=tutorial&mision=2', 3);
				}
				
				if($requer == 3 and $CurrentUser['tut_1'] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=1&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
				}
				elseif($CurrentUser['tut_1'] == 1){
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_mis_siguiente'] .'" onclick="window.location = \'game.php?page=tutorial&mision=2\'" style="width:150px;height:30px;color:green;" />';
				}
				else{
					$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
				}
				$template = gettemplate('tutorial/tutorial_1');
			break;
			
			default:
				for($m = 1; $m <= 10; $m++){
					if($CurrentUser['tut_' . $m] == 1){
						$parse['tut_' . $m] = 'accept';
					}else{
						$parse['tut_' . $m] = 'delete';
					}
				}
				$parse['game_name'] = read_config ( 'game_name' );
				if ($CurrentUser['tut_1' ] == 0){
					$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&mision=1\'" value="'. $lang['tutorial_comenzar'] .'" style="cursor:pointer;width:180px;height:27px;"/>';
				} else {
					$parse['button'] = '<input type="button" value="'. $lang['tutorial_continuar'] .'" onclick="window.location = \'game.php?page=tutorial&mision=1\'" style="cursor:pointer;width:180px;height:27px;"/>';
				}
				$template = gettemplate('tutorial/tutorial');
			
		}

		display(parsetemplate($template,$parse));
	}
}
?>