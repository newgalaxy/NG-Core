<?php
	/**
	* @project XG Proyect
	* @version 2.10.x build 0000
	* @copyright Copyright (C) 2008 - 2012
	*/

	define('INSIDE'  , TRUE);
	define('INSTALL' , FALSE);
	define('IN_ADMIN', TRUE);
	define('XGP_ROOT', './../');
	include(XGP_ROOT . 'global.php');
	if ( $EditUsers != 1 )
	{
		die(message ($lang['404_page']));
	}
		$parse = $lang;
		$lin = doquery("SELECT * FROM `{{table}}`", "galaxy");
		$count = 0;
		while($Deb = mysql_fetch_assoc($lin))
		{
			if($Deb['metal'] > 0 OR $Deb['crystal']> 0)
			{
				$parse['debris_planet_id']	= $Deb['id_planet'];
				$parse['debris_c_g']				= $Deb['galaxy'];
				$parse['debris_c_s']				= $Deb['system'];
				$parse['debris_c_p']				= $Deb['planet'];
				
				if($Deb['id_luna']	!= 0 or $Deb['id_luna'])
				{
					$parse['debris_luna']			= $lang['yes_dam'];
				}
				else
				{
					$parse['debris_luna']			= $lang['no_dam'];
				}

				$parse['debris_metal']			= $Deb['metal'];
				$parse['debris_crystal']		= $Deb['crystal'];
				$parse['debris_rows']			 .= parsetemplate(gettemplate('adm/EditorDebris/DebrisBodyRow'), $parse);
				$count++;
			}
		}

	if($count == 0)
	{
		$parse['debris_rows']		= "<tr><th colspan=\"8\"><font style=\"color: red; font-weight: bold;\">".$lang['detect_dam']."</font></th></tr>";
	}
		$parse['autor_xd']			= "<font style=\"color: black; font-weight: bold;\">Mod by teostra6 ;)</font>";
		switch($_GET['mod'])
		{
			case 'delete':
			if($_GET['ix'])
			{
				$QryUpdateDebris  = "UPDATE {{table}} SET ";
				$QryUpdateDebris .= "`metal` = '0', ";
				$QryUpdateDebris .= "`crystal` = '0' ";
				$QryUpdateDebris .= "WHERE ";
				$QryUpdateDebris .= "`id_planet` = '".$_GET['ix']."' ";
				doquery( $QryUpdateDebris, "galaxy");
				header("Location: EditorDebrisPage.php");
			}
			break;
			case 'deleteAll':
			$lin = doquery("SELECT * FROM `{{table}}`", "galaxy");
			while($Deb = mysql_fetch_assoc($lin))
			{             
				if($Deb['metal'] > 0 OR $Deb['crystal']> 0)
				{
					$QryUpdateDebris  = "UPDATE {{table}} SET ";
					$QryUpdateDebris .= "`metal` = '0', ";
					$QryUpdateDebris .= "`crystal` = '0' ";
					$QryUpdateDebris .= "WHERE ";
					$QryUpdateDebris .= "`id_planet` = '".$Deb['id_planet']."' ";
					doquery( $QryUpdateDebris, "galaxy");
				}
			}
			header("Location: EditorDebrisPage.php");
			break;
			case 'edit':
			if($_GET['ix'])
			{
				$sm = doquery("SELECT * FROM {{table}} WHERE id_planet=".$_GET['ix']."", "galaxy", true);
				$parse['debris_metal_me'] = $sm['metal'];
				$parse['debris_crystal_me'] = $sm['crystal'];
				if($_POST)
				{
					if(is_numeric($_POST['debris_metal_edit']) AND is_numeric($_POST['debris_crystal_edit']))
					{
						$QryUpdateDebris  = "UPDATE {{table}} SET ";
						$QryUpdateDebris .= "`metal` = '".$_POST['debris_metal_edit']."', ";
						$QryUpdateDebris .= "`crystal` = '".$_POST['debris_crystal_edit']."' ";
						$QryUpdateDebris .= "WHERE ";
						$QryUpdateDebris .= "`id_planet` = '".$_GET['ix']."';";
						doquery($QryUpdateDebris , 'galaxy');
						header("Location: EditorDebrisPage.php");
					}
				}
				display(parsetemplate(gettemplate('adm/EditorDebris/DebrisBodyEdit'), $parse), false, '', true, false);
			}
			break;
			case 'create':
			if($_POST)
			{
				if(is_numeric($_POST['debris_metal_create']) AND is_numeric($_POST['debris_crystal_create']) AND is_numeric($_POST['g_ic']) AND is_numeric($_POST['s_ic']) AND is_numeric($_POST['p_ic']))
				{
					$linke = doquery("SELECT * FROM `{{table}}` WHERE `galaxy` = '".$_POST['g_ic']."' AND `system` = '".$_POST['s_ic']."' AND `planet` = '" .$_POST['p_ic']. "';", 'galaxy', true);
					if($linke)
					{
						$QryUpdateDebris  = "UPDATE {{table}} SET ";
						$QryUpdateDebris .= "`metal` = '".$_POST['debris_metal_create']."', ";
						$QryUpdateDebris .= "`crystal` = '".$_POST['debris_crystal_create']."' ";
						$QryUpdateDebris .= "WHERE ";
						$QryUpdateDebris .= "`id_planet` = '".$linke['id_planet']."';";
						doquery($QryUpdateDebris , 'galaxy');
						header("Location: EditorDebrisPage.php");
					}
					else
					{
						$parse['mess'] ="<tr><th colspan=\"3\"><font style=\"color: red;\">".$lang['debris_no_coor_dam']."</font></th></tr>";
					}
				}
				else
				{
					$parse['mess'] ="<tr><th colspan=\"3\"><font style=\"color: red;\">".$lang['inval_dam']."</font></th></tr>";
				}
			}
			display(parsetemplate(gettemplate('adm/EditorDebris/DebrisBodyCreate'), $parse), false, '', true, false);
			break;
		}
		display(parsetemplate(gettemplate('adm/EditorDebris/DebrisBody'), $parse), false, '', true, false);
?>