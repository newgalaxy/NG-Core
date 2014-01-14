<?php

/**
 * @Project NewGalaxy
 * @version 0.2 build 0010
 * @copyright NewGalaxy (C) 2013
 */ 

if(!defined('INSIDE')){ die(header("location:../../"));}

class Colonize
{
	/**
	 * method build_new_fleet
	 * param $fleet_array
	 * return the new fleet, with a less colony ship
	*/
	public static function build_new_fleet ( $fleet_array )
	{
		$current_fleet	= explode ( ';' , $fleet_array );
		$new_fleet     	= '';

		foreach ( $current_fleet as $item => $group )
		{
			if ( $group != '' )
			{
				$ship	= explode ( ',' , $group );

				if ( $ship[0] == 208 )
				{
					if ( $ship[1] > 1 )
					{
						$new_fleet	.= $ship[0] . ',' . ( $ship[1] - 1 ) . ',';
					}
				}
				else
				{
					if ( $ship[1] <> 0 )
					{
						$new_fleet  .= $ship[0] . ',' . $ship[1] . ',';
					}
				}
			}
		}

		return $new_fleet;
	}

	/**
	 * method colonize_message
	 * param $owner
	 * param $message
	 * param $time
	 * return send a message with the colonization details
	*/
	public static function colonize_message ( $owner , $message , $time )
	{
		SendSimpleMessage ( $owner , '' , $time , 5 , $lang['sys_colo_mess_from'] , $lang['sys_colo_mess_report'] , $message );
	}
	
	/**
	 * method position_allowed
	 * param $position
	 * param $level
	 * return send a message with the colonization details
	 */
	public static function position_allowed ( $position , $level )
	{
		// CHECK IF THE POSITION IS NEAR THE SPACE LIMITS
		if ( $position <= 3 or $position >= 13 )
		{
			// POSITIONS 3 AND 13 CAN BE POPULATED FROM LEVEL 4 ONWARDS.
			if ( $level >= 4  && ( $position == 3 or $position == 13 ) )
			{
				return TRUE;
			}

			// POSITIONS 2 AND 14 CAN BE POPULATED FROM LEVEL 6 ONWARDS.
			if ( $level >= 6  && ( $position == 2 or $position == 14 ) )
			{
				return TRUE;
			}

			// POSITIONS 1 AND 15 CAN BE POPULATED FROM LEVEL 8 ONWARDS.
			if ( $level >= 8 )
			{
				return TRUE;
			}

			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
/* end of class.Colonize.php */