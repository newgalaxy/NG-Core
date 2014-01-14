<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('XGP_ROOT',	'./');

include(XGP_ROOT . 'global.php');

include(XGP_ROOT . 'includes/functions/CheckPlanetBuildingQueue.php');
include(XGP_ROOT . 'includes/functions/GetBuildingPrice.php');
include(XGP_ROOT . 'includes/functions/IsElementBuyable.php');
include(XGP_ROOT . 'includes/functions/SetNextQueueElementOnTop.php');
include(XGP_ROOT . 'includes/functions/SortUserPlanets.php');
include(XGP_ROOT . 'includes/functions/UpdatePlanetBatimentQueueList.php');

/*OFFICIERS CHECK*/
$lisql = "rpg_commandant,rpg_geologue,rpg_amiral,rpg_ingenieur,rpg_technocrate";
$ex = explode(",",$lisql);
foreach($ex as $in => $va)
{
	if($user[$va] > 0)
	{
	   $user[$va] = 1;
	}
}
/*Fin OFFICIERS CHECK*/

switch($_GET['page'])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'changelog':
		include_once(XGP_ROOT . GAME_PATH . 'ChangelogPage.php');
		new ChangelogPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once(XGP_ROOT . GAME_PATH . 'OverviewPage.php');
		new OverviewPage ( $user , $planetrow );
	break;
	/*case'tutorial':
        include_once(XGP_ROOT . GAME_PATH . 'TutorialPage.php');
		new TutorialPage ( $user , $planetrow );
    break;*/
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'galaxy':
		include_once(XGP_ROOT . GAME_PATH . 'GalaxyPage.php');
		new GalaxyPage ( $user , $planetrow );
	break;
	case'phalanx':
		include_once(XGP_ROOT . GAME_PATH . 'PhalanxPage.php');
		new PhalanxPage ( $user , $planetrow );
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'imperium':
		if($user['rpg_commandant'] > 0){
			include_once(XGP_ROOT . GAME_PATH . 'ImperiumPage.php');
			new ImperiumPage ( $user );
		}	
		else{
			die(message($lang['page_doesnt_exist']));
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'fleet':
		include_once(XGP_ROOT . GAME_PATH . 'FleetPage.php');
		new FleetPage ( $user , $planetrow );
	break;
	case'fleet1':
		include_once(XGP_ROOT . GAME_PATH . 'Fleet1Page.php');
		new Fleet1Page ( $user , $planetrow );
	break;
	case'fleet2':
		include_once(XGP_ROOT . GAME_PATH . 'Fleet2Page.php');
		new Fleet2Page ( $user , $planetrow );
	break;
	case'fleet3':
		include_once(XGP_ROOT . GAME_PATH . 'Fleet3Page.php');
		new Fleet3Page ( $user , $planetrow );
	break;
	case'fleetACS':
		include_once(XGP_ROOT . GAME_PATH . 'FleetACSPage.php');
		new FleetACSPage ( $user , $planetrow );
	break;
	case'shortcuts':
		include_once(XGP_ROOT . GAME_PATH . 'FleetShortcuts.php');
		new FleetShortcuts ( $user );
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buildings':
		UpdatePlanetBatimentQueueList ($planetrow, $user);
		switch ($_GET['mode'])
		{
			case 'research':
				include_once(XGP_ROOT . GAME_PATH . 'ResearchPage.php');
				new ResearchPage($planetrow, $user);
			break;
			case 'fleet':
				include_once(XGP_ROOT . GAME_PATH . 'ShipyardPage.php');
				$FleetBuildingPage = new ShipyardPage();
				$FleetBuildingPage->FleetBuildingPage ($planetrow, $user);
			break;
			case 'defense':
				include_once(XGP_ROOT . GAME_PATH . 'ShipyardPage.php');
				$DefensesBuildingPage = new ShipyardPage();
				$DefensesBuildingPage->DefensesBuildingPage ($planetrow, $user);
			break;
			default:
				include_once(XGP_ROOT . GAME_PATH . 'BuildingsPage.php');
				new BuildingsPage($planetrow, $user);
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'resources':
		include_once(XGP_ROOT . GAME_PATH . 'ResourcesPage.php');
		new ResourcesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'micropayment':
		include_once(XGP_ROOT . GAME_PATH . 'MicroPaymentPage.php');
		new MicroPaymentPage($user);
	break;
	case'payment':
		include_once(XGP_ROOT . GAME_PATH . 'PaymentPage.php');
		new PaymentPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'traderOverview':
		switch ($_GET['mode'])
		{
			case 'traderResources':
				include_once(XGP_ROOT . GAME_PATH . 'TraderPage.php');
				new TraderPage ( $user , $planetrow );
			break;
			case 'traderScrap':
				include_once(XGP_ROOT . GAME_PATH . 'TraderScrapPage.php');
				new TraderScrap ( $user , $planetrow );
			break;
			case 'traderAuctioneer':
				include_once(XGP_ROOT . GAME_PATH . 'TraderAuctioneerPage.php');
				new TraderAuctioneer ( $user , $planetrow );
			break;
			case 'traderImportExport':
				include_once(XGP_ROOT . GAME_PATH . 'TraderImportExportPage.php');
				new TraderImportExport ( $user , $planetrow );
			break;
			default:
				include_once(XGP_ROOT . GAME_PATH . 'TraderOverviewPage.php');
				new TraderOverview ( );
			break;
		}	
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'techtree':
		include_once(XGP_ROOT . GAME_PATH . 'TechTreePage.php');
		new TechTreePage($user, $planetrow);
	break;
	case'techtreedetails':
		include_once(XGP_ROOT . GAME_PATH . 'TechDetailsPage.php');
		new TechDetailsPage($user, $planetrow, $_GET['techid']);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'infos':
		include_once(XGP_ROOT . GAME_PATH . 'InfosPage.php');
		new InfosPage($user, $planetrow, $_GET['gid']);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'messages':
		include_once(XGP_ROOT . GAME_PATH . 'MessagesPage.php');
		new MessagesPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'alliance':
		include_once(XGP_ROOT . GAME_PATH . 'AlliancePage.php');
		new AlliancePage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buddy':
		include_once(XGP_ROOT . GAME_PATH . 'BuddyPage.php');
		new BuddyPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'notes':
		include_once(XGP_ROOT . GAME_PATH . 'NotesPage.php');
		new NotesPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'statistics':
		include_once(XGP_ROOT . GAME_PATH . 'StatisticsPage.php');
		new StatisticsPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'search':
		include_once(XGP_ROOT . GAME_PATH . 'SearchPage.php');
		new SearchPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'options':
		include_once(XGP_ROOT . GAME_PATH . 'OptionsPage.php');
		new OptionsPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'banned':
		include_once(XGP_ROOT . GAME_PATH . 'BannedPage.php');
		new BannedPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'logout':
		setcookie(read_config ( 'cookie_name' ), "", time()-100000, "/", "", 0);
		message($lang['see_you_soon'], XGP_ROOT, 1, FALSE, FALSE);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		die(message($lang['page_doesnt_exist']));
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>