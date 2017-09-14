<?php
//echo "cliente.php"; die();
	require_once("lib/nusoap/lib/nusoap.php");
	$wsdl = "http://localhost/wsPhpBibliotecaFup/server.php?wsdl";
	$client = new nusoap_client($wsdl, 'wsdl');

	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;

	//Respuesta (llamado funcion 'listadoLibros')
	$param = array('titulo' => '', 'isbn' => '' );
	$response = $client->call('listadoLibros',$param);
	echo "***********************************************************<br>";
	echo "Resultado funcion 'listadoLibros' *********************** ";
	echo "<pre>";
		print_r($response);
	echo "<pre>";
	
	//////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////
	
	//Respuesta (llamado funcion 'login')
	//Se definen los parametros ha pasar al servicio web login
	$param1 = array('codigo' => '111', 'clave' => '111');
	
	$response2 = $client->call('login',$param1);
	echo "***********************************************************<br>";
	echo "Resultado funcion 'login' *********************** ";
	echo "<pre>";
		print_r($response2);
	echo "<pre>";
	
	//////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////
	
	//Respuesta (llamado funcion 'listadoReservas')
	$param1 = array('isbn' => '','codTopografico' => '',
					'temas' => '', 'editorial' => 0,
					'idUsuarioReserva' => 2, 'estadoReserva' => '');
	
	$response2 = $client->call('listadoReservas',$param1);
	echo "***********************************************************<br>";
	echo "Resultado funcion 'listadoReservas' *********************** ";
	echo "<pre>";
		print_r($response2);
	echo "<pre>";
	
	//////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////
	//Respuesta llamado funcion buscarCiudadPorId
	$param = array('idCiudad'=>8);
	$response2 = $client->call('buscarCiudadPorId',$param);
	echo "***********************************************************<br>";
	echo "Resultado funcion 'buscarCiudadPorId' *********************** ";
	echo "<pre>";
		print_r($response2);
	echo "<pre>";
	echo "Solo id = ".$response2[0]['ID_CIUDAD'];

	//////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////

	/*//Llamado funcion 'guardarLibro')
		$param2 = array('titulo'=>'test', 
			'valor'=>'1',
			'adquisicion'=>'Compra',
			'estado'=>'Bueno',
			'isbn'=>'1212',
			'radicado'=>'23',
			'fechaIngreso'=>'',
			'codTopografico'=>'343',
			'serie'=>'uno',
			'idSede'=>1,
			'idEditorial'=>1,
			'idArea'=>1,
			'anio'=>2000,
			'temas'=>'Temas',
			'paginas'=>1,
			'disponibilidad'=>'SI',
			'idUsuario'=>1,
			'idCiudad'=>1);
	
	$response3 = $client->call('guardarLibro',$param2);
	echo "***********************************************************<br>";
	echo "Resultado funcion 'guardarLibro' *********************** ";
	echo $response3;*/
	
?>