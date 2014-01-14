<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class Production 
{
	/**
	 * method max_resource
	 * param $storage_level
	 * return max storage capacity
	 */
	public static function max_storable ( $storage_level )    
	{                    
		return ( BASE_STORAGE_SIZE + 50000 * ( Format::round_up ( pow ( 1.6 , $storage_level ) ) -1 ) );
		//return (floor(2.5 * pow(1.8331954764, $storage_level)) * 0.5 * read_config('resource_multiplier') * BASE_STORAGE_SIZE);
	} 
	
	
	/**
	 * method max_production
	 * param1 $max_energy
	 * param2 $energy_used
	 * return validated production factor (0%-100%)
	 */
	public static function max_production ( $max_energy , $energy_used )
	{	
		if ( ( $max_energy == 0 ) && ( $energy_used > 0 ) )
		{
			$percentage	= 0;
		}
		elseif ( ( $max_energy > 0 ) && ( ( $energy_used + $max_energy ) < 0 ) )
		{
			$percentage	= floor ( ( $max_energy ) / ( $energy_used * -1 ) * 100 );
		}
		else
		{
			$percentage	= 100;
		}

		if ( $percentage > 100 )
		{
			$percentage	= 100;
		}
		
		return $percentage;
	}
	
	/**
	 * method production_amount
	 * param1 $production
	 * param2 $boost
	 * return production amount
	 */
	 public static function production_amount ( $production , $boost )
	 {
	 	return floor( $production * read_config ( 'resource_multiplier' ) * $boost );
	 }
	 
	/**
	 * method current_production
	 * param $resource
	 * return amount of resource production
	 */
	 public static function current_production ( $resource , $max_production )
	 {
	 	return ( $resource * 0.01 * $max_production );
	 } 
}

?>