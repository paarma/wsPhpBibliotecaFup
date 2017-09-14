<?php

	 /**
	 * ////////////////////////////////////////////////
	 * ////////////////// FUNCIONES ///////////////////
	 * ////////////////////////////////////////////////
	 */
	 
	 //Funcion encargada de listar las Editoriales
	 function listadoEditoriales($descripcion){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM EDITORIAL WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$descripcionBusqueda = trim($descripcion);
		
		if(!empty($descripcionBusqueda)){
			$sql .= "AND DESCRIPCION LIKE '%".$descripcionBusqueda."%' ";
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 
	 //Funcion encargada de listar los auatores
	 function listadoAutores($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipo){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM AUTOR WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$primerNombreBusqueda = trim($primerNombre);
		$segundoNombreBusqueda = trim($segundoNombre);
		$primerApellidoBusqueda = trim($primerApellido);
		$segundoApellidoBusqueda = trim($segundoApellido);
		$tipoAutorBusqueda = trim($tipo);
		
		if(!empty($primerNombreBusqueda)){
			$sql .= "AND PRIMER_NOMBRE LIKE '%".$primerNombreBusqueda."%' ";
		}
		
		if(!empty($segundoNombreBusqueda)){
			$sql .= "AND SEGUNDO_NOMBRE LIKE '%".$segundoNombreBusqueda."%' ";
		}
				
		if(!empty($primerApellidoBusqueda)){
			$sql .= "AND PRIMER_APELLIDO LIKE '%".$primerApellidoBusqueda."%' ";
		}
		
		if(!empty($segundoApellidoBusqueda)){
			$sql .= "AND SEGUNDO_APELLIDO LIKE '%".$segundoApellidoBusqueda."%' ";
		}
		
		if(!empty($tipoAutorBusqueda)){
			$sql .= "AND TIPO_AUTOR = '".$tipoAutorBusqueda."' ";
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 	 
	 
	 //Funcion encargada de obtener la cantidad de autores
	 function cantidadAutores($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipo){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT COUNT(ID_AUTOR) AS TOTAL FROM AUTOR WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$primerNombreBusqueda = trim($primerNombre);
		$segundoNombreBusqueda = trim($segundoNombre);
		$primerApellidoBusqueda = trim($primerApellido);
		$segundoApellidoBusqueda = trim($segundoApellido);
		$tipoAutorBusqueda = trim($tipo);
		
		if(!empty($primerNombreBusqueda)){
			$sql .= "AND PRIMER_NOMBRE LIKE '%".$primerNombreBusqueda."%' ";
		}
		
		if(!empty($segundoNombreBusqueda)){
			$sql .= "AND SEGUNDO_NOMBRE LIKE '%".$segundoNombreBusqueda."%' ";
		}
				
		if(!empty($primerApellidoBusqueda)){
			$sql .= "AND PRIMER_APELLIDO LIKE '%".$primerApellidoBusqueda."%' ";
		}
		
		if(!empty($segundoApellidoBusqueda)){
			$sql .= "AND SEGUNDO_APELLIDO LIKE '%".$segundoApellidoBusqueda."%' ";
		}
		
		if(!empty($tipoAutorBusqueda)){
			$sql .= "AND TIPO_AUTOR = '".$tipoAutorBusqueda."' ";
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result[0]['TOTAL'];
	 }
	 
	 //Funcion encargada de listar los auatores
	 function listadoAutoresPaginados($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipo, $offSet, $limit){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM AUTOR WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$primerNombreBusqueda = trim($primerNombre);
		$segundoNombreBusqueda = trim($segundoNombre);
		$primerApellidoBusqueda = trim($primerApellido);
		$segundoApellidoBusqueda = trim($segundoApellido);
		$tipoAutorBusqueda = trim($tipo);
		
		if(!empty($primerNombreBusqueda)){
			$sql .= "AND PRIMER_NOMBRE LIKE '%".$primerNombreBusqueda."%' ";
		}
		
		if(!empty($segundoNombreBusqueda)){
			$sql .= "AND SEGUNDO_NOMBRE LIKE '%".$segundoNombreBusqueda."%' ";
		}
				
		if(!empty($primerApellidoBusqueda)){
			$sql .= "AND PRIMER_APELLIDO LIKE '%".$primerApellidoBusqueda."%' ";
		}
		
		if(!empty($segundoApellidoBusqueda)){
			$sql .= "AND SEGUNDO_APELLIDO LIKE '%".$segundoApellidoBusqueda."%' ";
		}
		
		if(!empty($tipoAutorBusqueda)){
			$sql .= "AND TIPO_AUTOR = '".$tipoAutorBusqueda."' ";
		}
		
		//Paginacion
		$sql .= "LIMIT ".$offSet.",".$limit;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 //Funcion encargada de listar las Areas
	 function listadoAreas(){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM AREA";
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 //Funcion encargada de listar las Sedes
	 function listadoSedes(){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM SEDE";
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 //Funcion encargada de listar los paises
	 function listadoPaises(){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM PAIS";
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 //Funcion encargada de listar las ciudades
	 function listadoCiudades($idPais){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT CIUDAD.ID_CIUDAD, CIUDAD.NOMBRE AS NOM_CIUDAD, ";
		$sql .= "PAIS.ID_PAIS, PAIS.NOMBRE AS NOM_PAIS ";
		$sql .= "FROM CIUDAD ";
		$sql .= "INNER JOIN PAIS ON (CIUDAD.ID_PAIS = PAIS.ID_PAIS) ";
		
		$idPaisBusqueda = trim($idPais);
		if(!empty($idPaisBusqueda) && $idPaisBusqueda != 0){
			$sql .= "WHERE CIUDAD.ID_PAIS = ".$idPaisBusqueda;
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 //funcion encargada de listar los usuarios
	 function listadoUsuarios($cedula, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $codigo, $rol){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM USUARIO WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$cedulaBusqueda = trim($cedula);
		$primerNombreBusqueda = trim($primerNombre);
		$segundoNombreBusqueda = trim($segundoNombre);
		$primerApellidoBusqueda = trim($primerApellido);
		$segundoApellidoBusqueda = trim($segundoApellido);
		$codigoBusqueda = trim($codigo);
		$rolBusqueda = trim($rol);
		
		if(!empty($cedulaBusqueda)){
			$sql .= "AND USUARIO.CEDULA LIKE '%".$cedulaBusqueda."%' ";
		}
		
		if(!empty($primerNombreBusqueda)){
			$sql .= "AND USUARIO.PRIMER_NOMBRE LIKE '%".$primerNombreBusqueda."%' ";
		}
		
		if(!empty($segundoNombreBusqueda)){
			$sql .= "AND USUARIO.SEGUNDO_NOMBRE LIKE '%".$segundoNombreBusqueda."%' ";
		}
		
		if(!empty($primerApellidoBusqueda)){
			$sql .= "AND USUARIO.PRIMER_APELLIDO LIKE '%".$primerApellidoBusqueda."%' ";
		}
		
		if(!empty($segundoApellidoBusqueda)){
			$sql .= "AND USUARIO.SEGUNDO_APELLIDO LIKE '%".$segundoApellidoBusqueda."%' ";
		}
		
		if(!empty($codigoBusqueda)){
			$sql .= "AND USUARIO.CODIGO LIKE '%".$codigoBusqueda."%' ";
		}
		
		if(!empty($rolBusqueda)){
			$sql .= "AND USUARIO.ROL = '".$rolBusqueda."' ";
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }


	 //funcion encargada de obtener la cantidad de usuarios
	 function cantidadUsuarios($cedula, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $codigo, $rol){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT COUNT(ID_USUARIO) AS TOTAL FROM USUARIO WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$cedulaBusqueda = trim($cedula);
		$primerNombreBusqueda = trim($primerNombre);
		$segundoNombreBusqueda = trim($segundoNombre);
		$primerApellidoBusqueda = trim($primerApellido);
		$segundoApellidoBusqueda = trim($segundoApellido);
		$codigoBusqueda = trim($codigo);
		$rolBusqueda = trim($rol);
		
		if(!empty($cedulaBusqueda)){
			$sql .= "AND USUARIO.CEDULA LIKE '%".$cedulaBusqueda."%' ";
		}
		
		if(!empty($primerNombreBusqueda)){
			$sql .= "AND USUARIO.PRIMER_NOMBRE LIKE '%".$primerNombreBusqueda."%' ";
		}
		
		if(!empty($segundoNombreBusqueda)){
			$sql .= "AND USUARIO.SEGUNDO_NOMBRE LIKE '%".$segundoNombreBusqueda."%' ";
		}
		
		if(!empty($primerApellidoBusqueda)){
			$sql .= "AND USUARIO.PRIMER_APELLIDO LIKE '%".$primerApellidoBusqueda."%' ";
		}
		
		if(!empty($segundoApellidoBusqueda)){
			$sql .= "AND USUARIO.SEGUNDO_APELLIDO LIKE '%".$segundoApellidoBusqueda."%' ";
		}
		
		if(!empty($codigoBusqueda)){
			$sql .= "AND USUARIO.CODIGO LIKE '%".$codigoBusqueda."%' ";
		}
		
		if(!empty($rolBusqueda)){
			$sql .= "AND USUARIO.ROL = '".$rolBusqueda."' ";
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result[0]['TOTAL'];		
	 }


	 //funcion encargada de listar los usuarios paginados
	 function listadoUsuariosPaginados($cedula, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $codigo, $rol, $offSet, $limit){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM USUARIO WHERE 1 ";
		
		//Se agregan los parametros de busqueda a la sql
		$cedulaBusqueda = trim($cedula);
		$primerNombreBusqueda = trim($primerNombre);
		$segundoNombreBusqueda = trim($segundoNombre);
		$primerApellidoBusqueda = trim($primerApellido);
		$segundoApellidoBusqueda = trim($segundoApellido);
		$codigoBusqueda = trim($codigo);
		$rolBusqueda = trim($rol);
		
		if(!empty($cedulaBusqueda)){
			$sql .= "AND USUARIO.CEDULA LIKE '%".$cedulaBusqueda."%' ";
		}
		
		if(!empty($primerNombreBusqueda)){
			$sql .= "AND USUARIO.PRIMER_NOMBRE LIKE '%".$primerNombreBusqueda."%' ";
		}
		
		if(!empty($segundoNombreBusqueda)){
			$sql .= "AND USUARIO.SEGUNDO_NOMBRE LIKE '%".$segundoNombreBusqueda."%' ";
		}
		
		if(!empty($primerApellidoBusqueda)){
			$sql .= "AND USUARIO.PRIMER_APELLIDO LIKE '%".$primerApellidoBusqueda."%' ";
		}
		
		if(!empty($segundoApellidoBusqueda)){
			$sql .= "AND USUARIO.SEGUNDO_APELLIDO LIKE '%".$segundoApellidoBusqueda."%' ";
		}
		
		if(!empty($codigoBusqueda)){
			$sql .= "AND USUARIO.CODIGO LIKE '%".$codigoBusqueda."%' ";
		}
		
		if(!empty($rolBusqueda)){
			$sql .= "AND USUARIO.ROL = '".$rolBusqueda."' ";
		}
		
		//Paginacion
		$sql .= "LIMIT ".$offSet.",".$limit;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }


	//funcion encargada de buscar un libro segun su ID
	 function buscarLibroPorId($idLibro){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM LIBRO WHERE ID_LIBRO = ".$idLibro;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de buscar un usuario segun su ID
	 function buscarUsuarioPorId($idUsuario){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM USUARIO WHERE ID_USUARIO = ".$idUsuario;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 //funcion encargada de buscar una editorial segun su ID
	 function buscarEditorialPorId($idEditorial){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM EDITORIAL WHERE ID_EDITORIAL = ".$idEditorial;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de buscar un Area segun su ID
	 function buscarAreaPorId($idArea){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM AREA WHERE ID_AREA = ".$idArea;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de buscar una Sede segun su ID
	 function buscarSedePorId($idSede){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM SEDE WHERE ID_SEDE = ".$idSede;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de buscar una Ciudad segun su ID
	 function buscarCiudadPorId($idCiudad){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT CIUDAD.ID_CIUDAD, CIUDAD.NOMBRE AS NOM_CIUDAD, ";
		$sql .= "PAIS.ID_PAIS, PAIS.NOMBRE AS NOM_PAIS ";
		$sql .= "FROM CIUDAD ";
		$sql .= "INNER JOIN PAIS ON (CIUDAD.ID_PAIS = PAIS.ID_PAIS) ";
		$sql .= "WHERE CIUDAD.ID_CIUDAD = ".$idCiudad;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 //funcion encargada de listar los registros de la tabla LIBRO_AUTOR
	 function listadoLibroAutor($idLibro){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT LIBRO.ID_LIBRO, AUTOR.ID_AUTOR, AUTOR.PRIMER_NOMBRE, AUTOR.SEGUNDO_NOMBRE, ";
		$sql .= "AUTOR.PRIMER_APELLIDO, AUTOR.SEGUNDO_APELLIDO, AUTOR.TIPO_AUTOR ";
		$sql .= "FROM LIBRO_AUTOR ";
		$sql .= "INNER JOIN LIBRO ON (LIBRO_AUTOR.ID_LIBRO = LIBRO.ID_LIBRO) ";
		$sql .= "INNER JOIN AUTOR ON (LIBRO_AUTOR.ID_AUTOR = AUTOR.ID_AUTOR) ";
		
		$idLibroBusqueda = trim($idLibro);
		if(!empty($idLibroBusqueda) && $idLibroBusqueda != 0){
			$sql .= "WHERE LIBRO_AUTOR.ID_LIBRO = ".$idLibroBusqueda;
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de listar los registros de la tabla LIBRO_AUTOR
	 function listadoLibroAutorNew($idLibro){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT AUTOR.ID_AUTOR, AUTOR.PRIMER_NOMBRE, AUTOR.SEGUNDO_NOMBRE, ";
		$sql .= "AUTOR.PRIMER_APELLIDO, AUTOR.SEGUNDO_APELLIDO, AUTOR.TIPO_AUTOR, ";
		$sql .= "LIBRO.*, LIBRO.ESTADO as EST_LIBRO, ";
		$sql .= "LIBRO.ID_USUARIO as ID_USUARIO_LIB, ";
		$sql .= "SD.DESCRIPCION as DES_SEDE, ";
		$sql .= "EDI.DESCRIPCION AS DES_EDITORIAL, ";
		$sql .= "AR.DESCRIPCION AS DES_AREA, ";
		$sql .= "CIU.NOMBRE AS NOM_CIUDAD, ";
		$sql .= "PA.ID_PAIS, PA.NOMBRE AS NOM_PAIS ";
		$sql .= "FROM LIBRO_AUTOR ";
		$sql .= "INNER JOIN LIBRO ON (LIBRO_AUTOR.ID_LIBRO = LIBRO.ID_LIBRO) ";
		$sql .= "INNER JOIN AUTOR ON (LIBRO_AUTOR.ID_AUTOR = AUTOR.ID_AUTOR) ";
		$sql .= "LEFT JOIN AREA AR ON (LIBRO.ID_AREA = AR.ID_AREA) ";
		$sql .= "LEFT JOIN EDITORIAL EDI ON (LIBRO.ID_EDITORIAL = EDI.ID_EDITORIAL) ";
		$sql .= "LEFT JOIN CIUDAD CIU ON (LIBRO.ID_CIUDAD = CIU.ID_CIUDAD) ";
		$sql .= "LEFT JOIN PAIS PA ON (CIU.ID_PAIS = PA.ID_PAIS) ";
		$sql .= "LEFT JOIN SEDE SD ON (LIBRO.ID_SEDE = SD.ID_SEDE) ";	
		
		$idLibroBusqueda = trim($idLibro);
		if(!empty($idLibroBusqueda) && $idLibroBusqueda != 0){
			$sql .= "WHERE LIBRO_AUTOR.ID_LIBRO = ".$idLibroBusqueda;
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de verificar si ya existe un determinado dato en la BD
	 //Retorna 1 en caso de que el dato ya exista en la BD.
	 function verficarDatoEnBd($tabla, $campo, $valor){
	 	$genericoCrud = new DbCrud();		
	 	
		$respuesta = $genericoCrud->verificarValorEnBD($tabla, $campo, $valor);	
		if($respuesta){
			return 1;
		}else{
			return 0;
		}
		 
	 }


	 //funcion encargada de buscar un Autor segun su ID
	 function buscarAutorPorId($idAutor){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM AUTOR WHERE ID_AUTOR = ".$idAutor;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 /**
	 * ////////////////////////////////////////////////
	 * ////////////////// REGISTRO DE FUNCIONES ///////
	 * ////////////////////////////////////////////////
	 */
	 
	//Se registra la funcion listadoEditoriales
	$server->register(
		// Method name:
		'listadoEditoriales',
		// parameter list:
		array('descripcion'=>'xsd:string'),
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
		'Metodo retorna listadoEditoriales ');
		
		
	//Se registra la funcion listadoAutores
	$server->register(
		// Method name:
		'listadoAutores',
		// parameter list:
		array('primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string', 
			'tipo'=>'xsd:string'),
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
		'Metodo retorna listadoAutores ');
	 
	 
	//Se registra la funcion cantidadAutores
	$server->register(
		// Method name:
		'cantidadAutores',
		// parameter list:
		array('primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string', 
			'tipo'=>'xsd:string'),
		// return values
		array('return'=>'xsd:int'),
		// namespace
		$ns,
		// soapaction: (use default)	//metodos opcionales que no estan en el register de la primera funcion (funcionTest)
		false,
		// style: rpc or document
		'rpc',
		// use: encoded or literal
		'encoded',
		// description: documentacion para el metodo
		'Metodo retorna la cantidad de autores ');
	 

	//Se registra la funcion listadoAutores paginados
	$server->register(
		// Method name:
		'listadoAutoresPaginados',
		// parameter list:
		array('primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string', 
			'tipo'=>'xsd:string',
			'offset'=>'xsd:int',
			'limit'=>'xsd:int'),
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
		'Metodo retorna listadoAutores paginados');
	 
	 
	//Se registra la funcion listadoAreas
	$server->register(
		// Method name:
		'listadoAreas',
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
		'Metodo retorna listadoAreas ');
		
		
	//Se registra la funcion listadoSedes
	$server->register(
		// Method name:
		'listadoSedes',
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
		'Metodo retorna listadoSedes ');
		
	
	//Se registra la funcion listadoPaises
	$server->register(
		// Method name:
		'listadoPaises',
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
		'Metodo retorna listadoPaises ');
		
	
	//Se registra la funcion listadoCiudades
	$server->register(
		// Method name:
		'listadoCiudades',
		// parameter list:
		array('idPais'=>'xsd:int'),
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
		'Metodo retorna listadoCiudades ');
		
	
	//Se registra la funcion listadoUsuarios
	$server->register(
		// Method name:
		'listadoUsuarios',
		// parameter list:
		array('cedula'=>'xsd:int',
			'primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string',
			'codigo'=>'xsd:string',
			'rol'=>'xsd:string'),
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
		'Metodo retorna listado usuarios ');
	
	
	
	//Se registra la funcion cantidadUsuarios
	$server->register(
		// Method name:
		'cantidadUsuarios',
		// parameter list:
		array('cedula'=>'xsd:int',
			'primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string',
			'codigo'=>'xsd:string',
			'rol'=>'xsd:string'),
		// return values
		array('return'=>'xsd:int'),
		// namespace
		$ns,
		// soapaction: (use default)	//metodos opcionales que no estan en el register de la primera funcion (funcionTest)
		false,
		// style: rpc or document
		'rpc',
		// use: encoded or literal
		'encoded',
		// description: documentacion para el metodo
		'Metodo retorna la cantidad usuarios ');
	
	
	//Se registra la funcion listadoUsuariosPaginados
	$server->register(
		// Method name:
		'listadoUsuariosPaginados',
		// parameter list:
		array('cedula'=>'xsd:int',
			'primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string',
			'codigo'=>'xsd:string',
			'rol'=>'xsd:string',
			'offset'=>'xsd:int',
			'limit'=>'xsd:int'),
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
		'Metodo retorna listado usuarios paginados ');
	
	
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarLibroPorId
	$server->register(
		// Method name:
		'buscarLibroPorId',
		// parameter list:
		array('idLibro'=>'xsd:int'),
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
		'Metodo retorna array con el libro encontrado segun su ID ');
		
			
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarUsuarioPorId
	$server->register(
		// Method name:
		'buscarUsuarioPorId',
		// parameter list:
		array('idUsuario'=>'xsd:int'),
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
		'Metodo retorna usuario encontrado segun su ID ');
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarEditorialPorId
	$server->register(
		// Method name:
		'buscarEditorialPorId',
		// parameter list:
		array('idEditorial'=>'xsd:int'),
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
		'Metodo retorna editorial segun su ID ');
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarAreaPorId
	$server->register(
		// Method name:
		'buscarAreaPorId',
		// parameter list:
		array('idArea'=>'xsd:int'),
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
		'Metodo retorna un Area segun su ID ');
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarSedePorId
	$server->register(
		// Method name:
		'buscarSedePorId',
		// parameter list:
		array('idSede'=>'xsd:int'),
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
		'Metodo retorna una Sede segun su ID ');
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarCiudadPorId
	$server->register(
		// Method name:
		'buscarCiudadPorId',
		// parameter list:
		array('idCiudad'=>'xsd:int'),
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
		'Metodo retorna una Ciudad segun su ID ');
		
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion listadoLibroAutor
	$server->register(
		// Method name:
		'listadoLibroAutor',
		// parameter list:
		array('idLibro'=>'xsd:int'),
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
		'Metodo retorna listadoLibroAutor ');
		
		
	
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion listadoLibroAutor
	$server->register(
		// Method name:
		'listadoLibroAutorNew',
		// parameter list:
		array('idLibro'=>'xsd:int'),
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
		'Metodo retorna listadoLibroAutor ');	
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion verficarDatoEnBd
	$server->register(
		// Method name:
		'verficarDatoEnBd',
		// parameter list:
		array('tabla'=>'xsd:string',
			'campo'=>'xsd:string',
			'valor'=>'xsd:string'),
		// return values
		array('return'=>'xsd:int'),
		// namespace
		$ns,
		// soapaction: (use default)	//metodos opcionales que no estan en el register de la primera funcion (funcionTest)
		false,
		// style: rpc or document
		'rpc',
		// use: encoded or literal
		'encoded',
		// description: documentacion para el metodo
		'Metodo retorna si existe o no un determinado dato en la BD ');


	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarAutorPorId
	$server->register(
		// Method name:
		'buscarAutorPorId',
		// parameter list:
		array('idAutor'=>'xsd:int'),
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
		'Metodo retorna una Autor segun su ID ');

?>