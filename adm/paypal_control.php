<?

define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('IN_ADMIN', TRUE);
define('XGP_ROOT', './../');

include(XGP_ROOT . 'global.php');

if ($ConfigGame != 1) die(message ($lang['404_page']));

	$parse = $lang;
	$dia = date("d");

$UserWhileLogin		= doquery ( "SELECT `id`, `username` FROM {{table}}", "users" );

while ( $UserList 	= mysql_fetch_array ( $UserWhileLogin ) )
{
	$name[$UserList['id']]	= $UserList['username'];
}


	$row_sql = doquery("SELECT * FROM {{table}}", "pagos");

	while($row = mysql_fetch_array($row_sql) ){

			$parse['rows']  .= "<tr>
		<th>".$row[0]."</th>
		<th>".$name[$row[1]]." (ID: ".$row[1].")</th>
		<th>".date('d/m/y',$row[2])."</th>
		<th>".$row[3]."</th>
		<th>".$row[4]."</th>
			</tr>";
			
			$info_dia[date('d',$row[2])][date('m',$row[2])][0] = date('d',$row[2]);
			$info_dia[date('d',$row[2])][date('m',$row[2])][1] += 1;
			$info_dia[date('d',$row[2])][date('m',$row[2])][2] += $row[3];
		
			$info_dia[0][date('W',$row[2])][2] += $row[3];
			$info_dia[1][date('m',$row[2])][2] += $row[3];
	}

	display(parsetemplate(gettemplate('adm/paypal_control_tpl'), $parse), FALSE, '', TRUE, FALSE);

?>