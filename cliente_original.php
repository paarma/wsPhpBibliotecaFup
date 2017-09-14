<?php
//echo "cliente.php"; die();
	require_once("lib/nusoap/lib/nusoap.php");
	$wsdl = "http://localhost/webServicePhp/server.php?wsdl";
	$client = new nusoap_client($wsdl, 'wsdl');

	//Se definen los parametros ha pasar al servicio web
	$param = array('parametro' => '15');

	//Respuesta (Se llama a la funcion 'funcionTest')
	$response = $client->call('funcionTest',$param);
	echo "Resultado funcion 'funcionTest':::: ";
	echo "<pre>";
		print_r($response);
	echo "</pre>";

	echo "<br>";
	echo "////////////////////////////////////////";
	echo "<br>";
	echo "<br>";

	//Respuesta (llamado funcion 'helloWorld')
	$response2 = $client->call('helloWorld',array('name' => 'Test'));
	echo "Resultado funcion 'helloWorld':::: ".$response2;

	echo "<br>";
	echo "////////////////////////////////////////";
	echo "<br>";
	echo "<br>";

	//Respuesta (llamado funcion 'retornaArray')
	$response3 = $client->call('retornaArray',array());
	echo "Resultado funcion 'retornaArray':::: ";
	echo "<pre>";
		print_r($response3);
	echo "<pre>";

?>