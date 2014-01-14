<?php

/**
 * @project XG Proyect
 * @version 2.10.x build 0000
 * @copyright Copyright (C) 2008 - 2012
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class PaymentPage
{
	public function __construct()
	{
		global $lang;

		$parse 			= $lang;
		
		$css_payment 	= "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/css/payment_global.css\" />";
		$parse['css']	= $css_payment;
		
		
		switch($_GET['mode'])
		{
			case 'paypal':
				$parse 			= $lang;
				$parse['dpath'] = DPATH;
				$parse['css']	= $css_payment;
				
				display ( parsetemplate ( gettemplate ( 'payment/payment_paypal' ) , $parse ) );
			break;
			
			case 'paygol':
				$parse 			= $lang;
				$parse['dpath'] = DPATH;
				$parse['css']	= $css_payment;
				
				display ( parsetemplate ( gettemplate ( 'payment/payment_paygol' ) , $parse ) );
			break;
			
			case 'paypal_buy':
				$parse 			= $lang;
				$parse['dpath'] = DPATH;
				$parse['css']	= $css_payment;
				$parse['user']	= $user['id'];
				$parse['miktar'] = intval($_GET['miktar']);
				
				display ( parsetemplate ( gettemplate ( 'payment/payment_paypal_buy' ) , $parse ), false,false,false,false );
			break;
		}
		
		display ( parsetemplate ( gettemplate ( 'payment/payment_body' ) , $parse ) );
	}
}
?>