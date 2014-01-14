<?php

/**
 * @project NGClasic
 * @Pagina Oficiales
 * Version 1
 *----------*
 * Primera fase para poder colocarle el tiempo de caducidad 7 dias y 1 mes.
 * Solucionado el error de tiempo.
 * Solucionado el bucle de tiempo y precio.
 * Version 2
 *----------*
 * Solucionado el bug que necesitaba el maximo de mo para poder contratar el oficial ahora solo pide lo minimo para poder contratarlo.
 * Solucionado el bug de multiplixidad en varias paginas del juegos.
 * Solucionado los enlaces ahora deben mostrarse bien.
 * Solucionado varios errores minimos.
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class MicroPaymentPage
{
	public function __construct ( &$CurrentUser )
	{
		global $resource, $reslist, $lang;

		$parse 	= $lang;
		//$bloc	= $lang;
		$parse['darkmatter'] 		= Format::pretty_number($CurrentUser["darkmatter"]);
		$parse['skin']				= $CurrentUser['dpath'];
		$mode	= isset ( $_GET['mode'] ) ? $_GET['mode'] : NULL;

		if ($mode == 2)
		{
			$Selected    = $_GET['offi'];

			if ( in_array($Selected, $reslist['officier']) )
			{
				$Result =	$this->IsOfficierAccessible ( $CurrentUser, $Selected );
				$Price	=	$this->GetOfficierPrice ( $Selected );

				if ( $Result !== FALSE )
				{
					if($_GET['time'] == "month"){
					$var = (time()+(60*60*24*90));
					$CurrentUser['darkmatter']         -= $Price;
					}elseif($_GET['time'] == "week"){
					$var = (time()+(60*60*24*7));
					$CurrentUser['darkmatter']         -= ($Price/10);
					}

					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`darkmatter` = '". $CurrentUser['darkmatter'] ."', ";
					$QryUpdateUser .= "`".$resource[$Selected]."` = '". $var ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
					doquery( $QryUpdateUser, 'users' );
				}
				else
				{
					header("location:game.php?page=micropayment");
				}
			}

			header("location:game.php?page=micropayment");

		}
		else
		{
			$OfficierRowTPL			=	gettemplate('micropayment/micropayment_row');
			$parse['disp_off_tbl']  = ''; 

			foreach($lang['tech'] as $Element => $ElementName)
			{
				if ($Element >= 600 && $Element <= 604)
				{
					$Result         = $this->IsOfficierAccessible ($CurrentUser, $Element);
					$Price			= $this->GetOfficierPrice ( $Element );
					$bloc['dpath']		= DPATH;
					$bloc['off_id']   	= $Element;
					$rowsql = doquery("SELECT `rpg_commandant`, `rpg_geologue`, `rpg_amiral`, `rpg_ingenieur`, `rpg_technocrate` FROM {{table}} WHERE `id`='".$CurrentUser['id']."'","users",true);		
					$bloc['off_status']	= ( ( $rowsql[$resource[$Element]] > 1 ) ? $lang['of_active'].") - ".$lang['fgf_time']."(".date("D M j H:i:s", ($rowsql[$resource[$Element]] )).""	 : $lang['of_inactive'] );
					$bloc['off_name']	= $ElementName;
					$bloc['off_desc'] 	= $lang['res']['descriptions'][$Element];
					$bloc['off_impro']  = $lang['res']['improvements'][$Element];
					$bloc['off_img']  	= $lang['res']['off_icons'][$Element];

					if ( $rowsql[$resource[$Element]] < 1 &&  $CurrentUser['darkmatter'] >= $Price)
						$bloc['off_link'] = "
						<a href=\"game.php?page=micropayment&mode=2&offi=".$Element."&time=month\">
						<b>".$lang['of_time_months']."<br /><font color=\"lime\"><strong>".$lang['of_time_for']." ".Format::pretty_number ( $Price ) . '</strong></font><br />' . $lang['Darkmatter']."</b>
						</a>
						";
					else
						$bloc['off_link'] = "
						<a href=\"game.php?page=micropayment&mode=2&offi=".$Element."&time=month\">
						<b>".$lang['of_time_months']."<br /><font color=\"lime\"><strong>".$lang['of_time_for']." ".Format::pretty_number ( $Price ) . '</strong></font><br />' . $lang['Darkmatter']."</b>
						</a>
						";
						//$bloc['off_link'] = "<font color=\"red\">3 meses por<br /><strong>sólo ".Format::pretty_number ( $Price ) . '</strong><br />' . $lang['Darkmatter'] . "</font>";
						
					if ( $rowsql[$resource[$Element]] < 1 &&  $CurrentUser['darkmatter'] >= $Price/10)
						$bloc['off_link2'] = "
						<a href=\"game.php?page=micropayment&mode=2&offi=".$Element."&time=week\">
						<b>".$lang['of_time_weeks']."<br /><font color=\"lime\"><strong>".$lang['of_time_for']." ".Format::pretty_number ( ($Price/10) ) . '</strong></font><br />' . $lang['Darkmatter']."</b>	
						</a>
						";
					else
						$bloc['off_link2'] = "
						<a href=\"game.php?page=micropayment&mode=2&offi=".$Element."&time=week\">
						<b>".$lang['of_time_weeks']."<br /><font color=\"lime\"><strong>".$lang['of_time_for']." ".Format::pretty_number ( ($Price/10) ) . '</strong></font><br />' . $lang['Darkmatter']."</b>	
						</a>
						";
						//$bloc['off_link2'] = "<font color=\"red\">1 semana por<br /><strong>sólo ".Format::pretty_number ( ($Price/10) ) . '</strong><br />' . $lang['Darkmatter'] . "</font>";


					$parse['disp_off_tbl'] .= parsetemplate( $OfficierRowTPL , $bloc );
				}
			}
			$page = parsetemplate( gettemplate('micropayment/micropayment_table'), $parse);
		}

		display($page);
	}

	private function IsOfficierAccessible ( $CurrentUser , $Officier )
	{
		global $resource, $pricelist;

		if ( $CurrentUser[$resource[$Officier]] < $pricelist[$Officier]['max']  )
		{
			$cost['darkmatter']  = floor ( $pricelist[$Officier]['darkmatter'] );

			if ( $cost['darkmatter'] > $CurrentUser['darkmatter'] )
			{
				if ( $cost['darkmatter']/10 > $CurrentUser['darkmatter'] )
				{
					return FALSE;
				}
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	private function GetOfficierPrice ( $Officier )
	{
		global $pricelist;

		return floor ( $pricelist[$Officier]['darkmatter'] );
	}
}
?>