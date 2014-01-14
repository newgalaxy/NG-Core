<!DOCTYPE html>

<html>
<head>
<meta charset=utf-8>

<body  onload="cuentaRegresiva();">
<h1>PayPal test</h1>
<p>Se cancelo refinamiento de materia oscura.</p><br>


<script>
var time = 4;
   function cuentaRegresiva() {
	   
	time--
	document.getElementById('time').innerHTML = "Esta ventana se cerrara en "+ time + " segundos.";
		if(time != 0)
		setTimeout("cuentaRegresiva();",1000)
		else
		document.getElementById('time').innerHTML = "Cerrar Ventana";	
		
    }
</script>

  <div id="time"></div>

<script language="javascript">setTimeout("self.close();",3500)</script>
