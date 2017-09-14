<?php

	require_once("lib/nusoap/lib/nusoap.php");
	$ns = "http://localhost/webServicePhp/";
	$server = new soap_server();

	//Se define la WSDL
	$server->configureWSDL('servicioTest',$ns);
	$server->wsdl->schemaTargetNamespace=$ns;


	//Se define el parametro que recibe la funcion y su tipo de dato
	//Se define el retorn de la funcion con su tipo de dato
	$server->register('funcionTest',array('parametro' => 'xsd:string'), array('return' => 'xsd:string'),$ns);

	//Se registra la funcion helloWorld
	$server->register(
		// Method name:
		'helloWorld',
		// parameter list:
		array('name'=>'xsd:string'),
		// return values
		array('return'=>'xsd:string'),
		// namespace
		$ns,
		// soapaction: (use default)	//metodos opcionales que no estan en el register de la primera funcion (funcionTest)
		false,
		// style: rpc or document
		'rpc',
		// use: encoded or literal
		'encoded',
		// description: documentacion para el metodo
		'Metodo simple helloWord');



	//Create a complex type (Para el tipo array de la funcion retornaArray)
	$server->wsdl->addComplexType('MyComplexType',
		'complexType','struct','all','',
		array('contacto' => array('name' => 'contacto', 'type' => 'xsd:string'),
			  'email' => array('name' => 'email', 'type' => 'xsd:string')));

	//Se registra la funcion retornaArray
	$server->register(
		// Method name:
		'retornaArray',
		// parameter list:
		array(),
		// return values
		array('return'=>'xsd:Array'),
		// namespace
		$ns,
		// soapaction: (use default)	//metodos opcionales que no estan en el register de la primera funcion (funcionTest)
		false,
		// style: rpc or document
		'rpc',
		// use: encoded or literal
		'encoded',
		// description: documentacion para el metodo
		'Metodo retorna array ');


	////////////////**************************////////////////////////////////////



	///////////////////////// funciones //////////////////////////////////////
	//Funcion test
	function funcionTest($parametro){

		$total = $parametro*0.15;

		//Se define el retorno y su tipo de dato.
		return new soapval('return','xsd:string',$total);
	}

	//Funcion metodo simple
	function helloWorld($nombre)
	{
		return "Hello World: ".$nombre;
	}

	//Funcion que retorna un array
	function retornaArray(){
		$result = array();

		$result[] = array('contacto' => 'contacto 1', 'email' => 'email1@gmail.com');
		$result[] = array('contacto' => 'contacto 2', 'email' => 'email2@gmail.com');

		return $result;
	}

	//$server->service($HTTP_RAW_POST_DATA);
	$server->service(file_get_contents("php://input"));
?>