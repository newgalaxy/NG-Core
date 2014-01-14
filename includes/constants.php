<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if ( !defined('INSIDE') ) die(header("location:../"));

	// VERSION
	define('SYSTEM_VERSION' 			, '2.10.5');
	define('CSS_VERSION' 			    , '0.1.2');

	//TEMPLATES DEFAULT SETTINGS
	define('DEFAULT_SKINPATH' 		 , 'styles/themes/NGClasic/');
	define('TEMPLATE_DIR'     		 , 'styles/views/');
	define('SKIN_PATH'				 , 'styles/themes/');
	define('LOGIN_DIR'     		     , 'styles/images/login/');
	
	//PAGE CONTROLLERS
	define('CONTROLLERS_PATH'		 , 'includes/' );
	define('GAME_PATH'				 , CONTROLLERS_PATH . 'game/' );

	// UNIVERSE DATA, GALAXY, SYSTEMS AND PLANETS || DEFAULT 9-499-15 RESPECTIVELY
	define('MAX_GALAXY_IN_WORLD'      	,       9);
	define('MAX_SYSTEM_IN_GALAXY'     	,     499);
	define('MAX_PLANET_IN_SYSTEM'     	,      15);

	// NUMBER OF COLUMNS FOR SPY REPORTS
	define('SPY_REPORT_ROW'           	,       3);

	// FIELDS FOR EACH LEVEL OF THE LUNAR BASE
	define('FIELDS_BY_MOONBASIS_LEVEL'	,       3);

	// FIELDS FOR EACH LEVEL OF THE TERRAFORMER
	define('FIELDS_BY_TERRAFORMER'	  	,       5);

	// NUMBER OF PLANETS THAT MAY HAVE A PLAYER
	define('MAX_PLAYER_PLANETS'       	,       9);

	// NUMBER OF BUILDINGS THAT CAN GO IN THE CONSTRUCTION QUEUE
	define('MAX_BUILDING_QUEUE_SIZE'  	,       5);

	// NUMBER OF SHIPS THAT CAN BUILD FOR ONCE
	define('MAX_FLEET_OR_DEFS_PER_ROW'	, 1000000);

	//PLANET SIZE MULTIPLER
	define('PLANETSIZE_MULTIPLER'		,       1);

	// INITIAL RESOURCE OF NEW PLANETS
	//define('BASE_STORAGE_SIZE'        	,   10000);
	define('BASE_STORAGE_SIZE'        	,  100000);
	define('BUILD_METAL'              	,     500);
	define('BUILD_CRISTAL'            	,     500);
	define('BUILD_DEUTERIUM'          	, 	    0);

	// OFFICIERS DEFAULT VALUES
	define('AMIRAL'				  		,       2);
	define('ENGINEER_DEFENSE'			,       2);
	define('ENGINEER_ENERGY'			,     0.5);
	define('GEOLOGUE'				  	,     0.1);
	define('TECHNOCRATE_SPY'			,       2);
	define('TECHNOCRATE_SPEED'			,    0.25);

	// TRADER DARK MATTER DEFAULT VALUE
	define('TR_DARK_MATTER'			  	,    3500);
	// TRADER SCRAP
	define('TIMESTAMP'					,	time());
	define('INCLUDE_FLEETS'				,	TRUE); //Chatarrero de flotas habilitado.
	define('INCLUDE_DEFENSE'			,	TRUE); //Chatarrero de defensas habilitado.
	define('METAL_RECOV_RATE'			,	35); //Ratio de devolución de metal.
	define('CRYSTAL_RECOV_RATE'			,	35); //Ratio de devolución de cristal.
	define('DEUTERIUM_RECOV_RATE'		,	35); //Ratio de devolución de deuterio.  

	// INVISIBLES DEBRIS
	define('DEBRIS_LIFE_TIME'      		,  604800);
	define('DEBRIS_MIN_VISIBLE_SIZE'	, 	  300);
	
	// ADMINISTRATOR EMAIL AND GAME URL - THIS DATA IS REQUESTED BY REG.PHP
    define('GAMEURL'                      , "http://".$_SERVER['HTTP_HOST']."/");
    define('TIPE_MAILER'                  ,                       "smtp"); //NO TOCAR
    define('HOST_SMPT'                    ,      "mail.newgalaxy.com.ar"); //Servidor SMTP
    define('PORT_HOST'                    ,                         25); //Puerto SMTP
    define('ADMINEMAIL'                   ,   "dotreply@newgalaxy.com.ar"); //Email del servidor ej:confirmed@tudominio.com
    define('PASSWORD'                     ,            "jonamix35448368"); //Pasword de la cuenta del correo de arriva
    define('TIME_OUT'                     ,                           30); //NO TOCAR  
?>