<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

	function ShowTopNavigationBar ($CurrentUser, $CurrentPlanet)
	{
		global $lang;

		if($CurrentUser['urlaubs_modus'] == 0)
			PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
		else
			doquery("UPDATE {{table}} SET `deuterium_sintetizer_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0 WHERE id_owner = ".intval($CurrentUser['id']),"planets");

		$parse				 			= $lang;
		$parse['dpath']      			= DPATH;
		$parse['image']      			= $CurrentPlanet['image'];

		if ( $CurrentUser['urlaubs_modus'] && $CurrentUser['db_deaktjava'] )
        {
            $parse['show_umod_notice']          .= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 2px solid red; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
        }
        else
        {
            if ( $CurrentUser['urlaubs_modus'] < time() )
            {
                $parse['show_umod_notice']       = $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 2px solid #1DF0F0; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_vacation_mode_active'] .'</td></tr></table><br>' : '';
            }
            else
            {
                $parse['show_umod_notice']       = $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 2px solid #1DF0F0; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_vacation_mode'] . date('d.m.Y h:i:s',$CurrentUser['urlaubs_until']).'</td></tr></table><br>' : '';	            
            }
                
            $parse['show_umod_notice']      .= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 2px solid red; text-align:center;background:transparent;"><tr style="background:transparent;"><td style="background:transparent;">' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
        }  


		$energy = Format::pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . Format::pretty_number($CurrentPlanet["energy_max"]);
		// Energie
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = Format::color_red($energy);
		} else {
			$parse['energy'] = $energy;
		}
		// Metal
		$metal = Format::pretty_number($CurrentPlanet["metal"]);
		if (($CurrentPlanet["metal"] >= $CurrentPlanet["metal_max"])) {
			$parse['metal'] = Format::color_red($metal);
		} else {
			$parse['metal'] = $metal;
		}
		// Cristal
		$crystal = Format::pretty_number($CurrentPlanet["crystal"]);
		if (($CurrentPlanet["crystal"] >= $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = Format::color_red($crystal);
		} else {
			$parse['crystal'] = $crystal;
		}
		// Deuterium
		$deuterium = Format::pretty_number($CurrentPlanet["deuterium"]);
		if (($CurrentPlanet["deuterium"] >= $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = Format::color_red($deuterium);
		} else {
			$parse['deuterium'] = $deuterium;
		}
		$parse['darkmatter'] 		= Format::pretty_number($CurrentUser["darkmatter"]);
		
		/*OFFICIERS IN TOPNAV*/
		if ($CurrentUser['rpg_commandant'] > 0){
			$parse['commandant'] = "commander_ikon.gif";
		}else{
			$parse['commandant'] 		= "commander_ikon_un.gif";
		}
        if ($CurrentUser['rpg_amiral'] > 0){
			$parse['amiral'] = "admiral_ikon.gif";
		}else{
			$parse['amiral'] = "admiral_ikon_un.gif";
		}
        if ($CurrentUser['rpg_ingenieur'] > 0){
			$parse['ingenieur'] = "ingenieur_ikon.gif";
		}else{
			$parse['ingenieur'] = "ingenieur_ikon_un.gif";
		}
		if ($CurrentUser['rpg_geologue'] > 0){
			$parse['geologue'] = "geologe_ikon.gif";
		}else{
			$parse['geologue'] = "geologe_ikon_un.gif";
		}
        if ($CurrentUser['rpg_technocrate'] > 0){
			$parse['technocrate'] = "technokrat_ikon.gif";
		}else{
			$parse['technocrate'] = "technokrat_ikon_un.gif";
		} 
		/*FIN OFFICIERS IN TOPNAV*/
		$TopBar 			 		= parsetemplate(gettemplate('general/topnav'), $parse);

		return $TopBar;
	}
?>