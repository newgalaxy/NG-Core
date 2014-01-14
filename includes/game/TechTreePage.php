<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */
 /**
 * @Arbol de tecnologia en tabs
 * @version 0.0.5 build 0000
 * @copyright JonaMiX
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class TechTreePage
{
    function __construct ( $CurrentUser , $CurrentPlanet )
    {
        global $resource, $requeriments, $lang;

        $parse = $lang;

        $TechTreeHeadTPL    = gettemplate('techtree/techtree_head');
        $TechTreeRowTPL     = gettemplate('techtree/techtree_row');
        $page                = '';
        
        foreach($lang['tech'] as $Element => $ElementName)
        {
            if ( $Element < 39 OR $Element == 44)
            {
                $parse            = array();
                $parse['tt_name'] = $ElementName;
                $parse['dpath']   = DPATH;
                $parse['tt_img']  = $Element;
                
                if (!isset($resource[$Element]))
                {
                    $parse['Requirements']   = $lang['tt_requirements'];
                    $parse['level']          = $lang['tt_level'];
                    $parse['image']          = $lang['tt_image'];
                    $pageBuild              .= parsetemplate($TechTreeHeadTPL, $parse);
                }
                else
                {
                    if (isset($requeriments[$Element]))
                    {
                        $parse['required_list'] = "";
                        foreach($requeriments[$Element] as $ResClass => $Level)
                        {
                            if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            else
                                $parse['required_list'] .= "<font color=\"#ff0000\">";

                            $parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] . $CurrentUser[$resource[$ResClass]]."".$CurrentPlanet[$resource[$ResClass]]."/". $Level .")";
                            $parse['required_list'] .= "</font><br>";
							$parse['tt_detail']      = "<a href=\"game.php?page=techtreedetails&techid=".$Element."\">[i]</a>";
                        };
                    }
                    else
                    {
                        $parse['required_list'] = "";
                        $parse['tt_detail']     = "";
                    }
                    $parse['tt_info']   = $Element;
                    $pageBuild              .= parsetemplate($TechTreeRowTPL, $parse);
                }
            }
            
            /*CONDICIONAL EDIFICIOS LUNARES*/
            if ( $Element >= 40 && $Element <= 43 )
            {
                $parse            = array();
                $parse['tt_name'] = $ElementName;
                $parse['dpath']   = DPATH;
                $parse['tt_img']  = $Element;

                if (!isset($resource[$Element]))
                {
                    $parse['Requirements']  = $lang['tt_requirements'];
                    $parse['level']         = $lang['tt_level'];
                    $parse['image']         = $lang['tt_image'];
                    $pageMoon              .= parsetemplate($TechTreeHeadTPL, $parse);
                }
                else
                {
                    if (isset($requeriments[$Element]))
                    {
                        $parse['required_list'] = "";
                        foreach($requeriments[$Element] as $ResClass => $Level)
                        {
                            if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            else
                                $parse['required_list'] .= "<font color=\"#ff0000\">";

                            $parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] . $CurrentUser[$resource[$ResClass]]."".$CurrentPlanet[$resource[$ResClass]]."/". $Level .")";
                            $parse['required_list'] .= "</font><br>";
							$parse['tt_detail']      = "<a href=\"game.php?page=techtreedetails&techid=".$Element."\">[i]</a>";
                        };
                    }
                    else
                    {
                        $parse['required_list'] = "";
                        $parse['tt_detail']     = "";
                    }
                    $parse['tt_info']   = $Element;
                    $pageMoon          .= parsetemplate($TechTreeRowTPL, $parse);
                }
            }
            /*FIN CONDICIONAL EDIFICIOS LUNARES*/
            
            /*CONDICIONAL INVESTIGACIONES*/
            if ( $Element >= 100 && $Element <= 199 )
            {
                $parse            = array();
                $parse['tt_name'] = $ElementName;
                $parse['dpath']   = DPATH;
                $parse['tt_img']  = $Element;

                if (!isset($resource[$Element]))
                {
                    $parse['Requirements']  = $lang['tt_requirements'];
                    $parse['level']         = $lang['tt_level'];
                    $parse['image']         = $lang['tt_image'];
                    $pageTech              .= parsetemplate($TechTreeHeadTPL, $parse);
                }
                else
                {
                    if (isset($requeriments[$Element]))
                    {
                        $parse['required_list'] = "";
                        foreach($requeriments[$Element] as $ResClass => $Level)
                        {
                            if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            else
                                $parse['required_list'] .= "<font color=\"#ff0000\">";

                            $parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] . $CurrentUser[$resource[$ResClass]]."".$CurrentPlanet[$resource[$ResClass]]."/". $Level .")";
                            $parse['required_list'] .= "</font><br>";
							$parse['tt_detail']      = "<a href=\"game.php?page=techtreedetails&techid=".$Element."\">[i]</a>";
                        };
                    }
                    else
                    {
                        $parse['required_list'] = "";
                        $parse['tt_detail']     = "";
                    }
                    $parse['tt_info']   = $Element;
                    $pageTech          .= parsetemplate($TechTreeRowTPL, $parse);
                }
            }
            /*FIN CONDICIONAL EDIFICIOS LUNARES*/
            
            /*CONDICIONAL NAVES ESPACIALES*/
            if ( $Element >= 200 && $Element <= 220 )
            {
                $parse            = array();
                $parse['tt_name'] = $ElementName;
                $parse['dpath']   = DPATH;
                $parse['tt_img']  = $Element;

                if (!isset($resource[$Element]))
                {
                    $parse['Requirements']   = $lang['tt_requirements'];
                    $parse['level']          = $lang['tt_level'];
                    $parse['image']          = $lang['tt_image'];
                    $pageShips              .= parsetemplate($TechTreeHeadTPL, $parse);
                }
                else
                {
                    if (isset($requeriments[$Element]))
                    {
                        $parse['required_list'] = "";
                        foreach($requeriments[$Element] as $ResClass => $Level)
                        {
                            if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            else
                                $parse['required_list'] .= "<font color=\"#ff0000\">";

                            $parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] . $CurrentUser[$resource[$ResClass]]."".$CurrentPlanet[$resource[$ResClass]]."/". $Level .")";
                            $parse['required_list'] .= "</font><br>";
							$parse['tt_detail']      = "<a href=\"game.php?page=techtreedetails&techid=".$Element."\">[i]</a>";
                        };
                    }
                    else
                    {
                        $parse['required_list'] = "";
                        $parse['tt_detail']     = "";
                    }
                    $parse['tt_info']    = $Element;
                    $pageShips          .= parsetemplate($TechTreeRowTPL, $parse);
                }
            }
            /*FIN CONDICIONAL NAVES ESPACIAL*/
            
            /*CONDICIONAL DEFENSAS*/
            if ( $Element >= 400 && $Element <= 550 )
            {
                $parse            = array();
                $parse['tt_name'] = $ElementName;
                $parse['dpath']   = DPATH;
                $parse['tt_img']  = $Element;

                if (!isset($resource[$Element]))
                {
                    $parse['Requirements']    = $lang['tt_requirements'];
                    $parse['level']           = $lang['tt_level'];
                    $parse['image']           = $lang['tt_image'];
                    $pageDefence             .= parsetemplate($TechTreeHeadTPL, $parse);
                }
                else
                {
                    if (isset($requeriments[$Element]))
                    {
                        $parse['required_list'] = "";
                        foreach($requeriments[$Element] as $ResClass => $Level)
                        {
                            if( isset($CurrentUser[$resource[$ResClass]] ) && $CurrentUser[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            elseif ( isset($CurrentPlanet[$resource[$ResClass]] ) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
                                $parse['required_list'] .= "<font color=\"#00ff00\">";
                            else
                                $parse['required_list'] .= "<font color=\"#ff0000\">";

                            $parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['tt_lvl'] . $CurrentUser[$resource[$ResClass]]."".$CurrentPlanet[$resource[$ResClass]]."/". $Level .")";
                            $parse['required_list'] .= "</font><br>";
							$parse['tt_detail']      = "<a href=\"game.php?page=techtreedetails&techid=".$Element."\">[i]</a>";
                        };
                    }
                    else
                    {
                        $parse['required_list'] = "";
                        $parse['tt_detail']     = "";
                    }
                    $parse['tt_info']   = $Element;
                    $pageDefence          .= parsetemplate($TechTreeRowTPL, $parse);
                }
            }
            /*FIN CONDICIONAL DEFENSAS*/
        }
        $parse = $lang;
        /*NUEVAS VARIABLES*/
        $parse['buildings_block']    = $pageBuild;
        $parse['moons_block']        = $pageMoon;
        $parse['tech_block']         = $pageTech;
        $parse['ship_block']         = $pageShips;
        $parse['defenses_block']     = $pageDefence;
        /*FIN NUEVAS VARIABLES*/
        
        return display(parsetemplate(gettemplate('techtree/techtree_body'), $parse));
    }
}
?>