<?php

/**
 * TechDetails
 *
 * @version 1.0
 * @copyright 2008 by JonaMiX
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class TechDetailsPage
{
	public function __construct($CurrentUser, $CurrentPlanet)
	{
		global $resource, $requeriments, $lang;
		
		$parse 			= $lang;
		
		$Id                  = $_GET['techid'];
		$PageTPL             = gettemplate('techtree/techtree_details');

		$parse['te_dt_id']   = $Id;
		$parse['te_dt_id_of'] = $ResClass;
		$parse['te_dt_name'] = $lang['tech'][$Id];
		
		if (isset($requeriments[$Id]))
		{
			foreach($requeriments[$Id] as $ResClass => $Level) 
			{
				if ( isset( $CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level) 
				{
						$parse['required_list'] .= "<font color=\"#00ff00\">";
						$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] ." ". $Level .")";
				} 
				elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level) 
				{
					$parse['required_list'] .= "<font color=\"#00ff00\">";
					$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] ." ". $Level .")";
				} 
				else 
				{
					$parse['required_list'] .= "<font color=\"#ff0000\">";
					$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] ." ". $Level .")</font>";
				}
				//$parse['required_list'] .= "<a style=\"color:#ff0000\" href='?page=techtreedetails&techid=".$ResClass."'>[i]</a>";	
				$parse['required_list'] .= "<br>";
			}
		}		

		$parse['Liste'] = $parse['required_list'];
		$page = parsetemplate($PageTPL, $parse);

		display ($page);
	}
}
?>