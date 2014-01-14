<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class TraderOverview
{
	public function __construct()
	{
		global $lang;

		$parse 			= $lang;
		$parse['dpath'] = DPATH;

		display ( parsetemplate ( gettemplate ( 'trader/trader_body' ) , $parse ) );
	}
}
?>