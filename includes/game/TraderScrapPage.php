<?php

/*Trader Scrap*/
/*
*By JonaMiX
*Version 0.2
*/
class TraderScrap
{
	public function __construct($CurrentUser, $CurrentPlanet)
    {
		global $lang, $planetrow, $reslist, $resource, $pricelist;
		
		$parse 			= $lang;
		
		$TraderScrapTpl = gettemplate('trader/scrap_body');
		
		// verificamos que no estemos una luna
		if ($CurrentPlanet['planet_type'] == 3) {
            exit(message($lang['ch_luna_no']));
        }
		// Verificamos el tipo de nave por defecto y seleccionada por el usuario
		if (isset($_POST['ship_type_id'])) { 
            $res_id = intval($_POST['ship_type_id']);
        } 
		else { 
            $res_id = 202;
        }
		
		// obtenemos el costo de producción por unidad, segun la nave seleccionada a vender.
        if(isset($pricelist[$res_id]))
        {
            $price_metal     = $pricelist[$res_id]['metal'];
            $price_cristal   = $pricelist[$res_id]['crystal'];
            $price_deuterium = $pricelist[$res_id]['deuterium'];
        }
        else {
            exit(header("game.php?page=traderOverview&mode=traderScrap"));
        }
		
		// porcentaje de recuperación
        $scrap_rate_metal     = METAL_RECOV_RATE/100;
        $scrap_rate_cristal   = CRYSTAL_RECOV_RATE/100;
        $scrap_rate_deuterium = DEUTERIUM_RECOV_RATE/100;
		
		// importe real de recuperacion por unidad
        $scrap_metal     = $price_metal * $scrap_rate_metal;
        $scrap_cristal   = $price_cristal * $scrap_rate_cristal;
        $scrap_deuterium = $price_deuterium * $scrap_rate_deuterium;
        
		if (isset($_POST['number_ships_sell']) AND $_POST['number_ships_sell'] > 0) 
        {
            $number_ship_sell = intval($_POST['number_ships_sell']); // cantidad de naves a vender
            if ($CurrentPlanet[$resource[$res_id]] > 0) {
                // si el número a vender es mayor a que se tiene se cambia por el maximo que se tiene
                if ($number_ship_sell > $CurrentPlanet[$resource[$res_id]])
                    $number_ship_sell = $CurrentPlanet[$resource[$res_id]];
            
                // calculamos el nuevo saldo de materiales por la venta de naves
                $recuperar_metal     = $number_ship_sell * $scrap_metal;
                $recuperar_cristal   = $number_ship_sell * $scrap_cristal;
                $recuperar_deuterium = $number_ship_sell * $scrap_deuterium;

                // actualizamos el saldo de recursos y naves del planeta
                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                $QryUpdatePlanet .= "`metal` = `metal` + '".  $recuperar_metal ."', ";
                $QryUpdatePlanet .= "`crystal` = `crystal` + '". $recuperar_cristal ."', ";
                $QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $recuperar_deuterium ."', ";
                $QryUpdatePlanet .= "`". $resource[$res_id] ."` = `". $resource[$res_id] ."` - '". $number_ship_sell."' ";
                $QryUpdatePlanet .= "WHERE ";
                $QryUpdatePlanet .= "`id`='".$CurrentPlanet['id']."'";
                doquery($QryUpdatePlanet,"planets");
            }
            exit(message($lang['ch_fin_venta'],"game.php?page=traderOverview&mode=traderScrap",3));
        }
		
		$parse['shiplist'] = '';
        if(INCLUDE_FLEET)
        {
            foreach ($reslist['fleet'] as $value) {
                if ($value == 212)
                    continue;
                    
                $parse['shiplist'] .= "\n<option ";
                if ($res_id == $value) {
                    $parse['shiplist'] .= "selected=\"selected\" ";
                }
                
                $parse['shiplist'] .= "value=\"".$value."\">";
                $parse['shiplist'] .= $lang['tech'][$value];
                $parse['shiplist'] .= "</option>";
            }
        }
        
        if(INCLUDE_DEFENSE)
        {
            foreach ($reslist['defense'] as $value) {
                if($value > 500)
                    continue;
                    
                $parse['shiplist'] .= "\n<option ";
                if ($res_id == $value) {
                    $parse['shiplist'] .= "selected=\"selected\" ";
                }
                
                $parse['shiplist'] .= "value=\"".$value."\">";
                $parse['shiplist'] .= $lang['tech'][$value];
                $parse['shiplist'] .= "</option>";
            }
        }
		
		$commonNum = "<span id='scrap_%what' style='color:yellow;'>0</span>";
        $parse['image']             = $res_id;
        $parse['dpath']             = DPATH;
        $parse['scrap_metal']       = $scrap_metal;
        $parse['scrap_cristal']     = $scrap_cristal;
        $parse['scrap_deuterium']   = $scrap_deuterium;
        $parse['shiptype_id']       = $res_id;
        $parse['max_ships_to_sell'] = $CurrentPlanet[$resource[$res_id]];
        $parse['ch_merchant_give_metal'] = str_replace('%met',str_replace("%what","metal",$commonNum),$lang['ch_merchant_give_metal']);
        $parse['ch_merchant_give_crystal'] = str_replace('%crys',str_replace("%what","cristal",$commonNum),$lang['ch_merchant_give_crystal']);
        $parse['ch_merchant_give_deutetium'] = str_replace('%deut',str_replace("%what","deuterium",$commonNum),$lang['ch_merchant_give_deutetium']);   
        $page = parsetemplate( $TraderScrapTpl, $parse );
        
        display( $page );
	}
}
?>