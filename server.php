<?php
	require_once("lib/DbCrud.php");
	require_once("lib/nusoap/lib/nusoap.php");

	$ns = "http://localhost/wsPhpBibliotecaFup/";
	$server = new soap_server();


	$server->soap_defencoding = 'UTF-8';
	$server->decode_utf8 = false;
	$server->encode_utf8 = true;

	//Se define la WSDL
	$server->configureWSDL('servicioTest',$ns);
	$server->wsdl->schemaTargetNamespace=$ns;
	
	// Utilidades reservas.
	include_once 'serverUtilReservas.php';
	include_once 'serverUtilListadosGenerales.php';
	include_once 'newListadosGenerales.php';
	
	/**
	 * ////////////////////////////////////////////////
	 * ////////////////// FUNCIONES ///////////////////
	 * ////////////////////////////////////////////////
	 */
	 
	 //funcion login. Encargada del loggin segun usuario y password
	 function login($codigo, $clave){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM USUARIO WHERE CODIGO = ".$codigo." AND CLAVE = ".$clave;
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
	 }
	 
	 //funcion encargada de listar los libros
	 function listadoLibros($titulo, $isbn, $codTopografico, $temas, $editorial, $autor){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM LIBRO ";
		
		//Se agregan los parametros de busqueda a la sql
		$tituloBusqueda = trim($titulo);
		$isbnBusqueda = trim($isbn);
		$codTopograficoBusqueda = trim($codTopografico);
		$temasBusqueda = trim($temas);
		$editorialBusqueda = trim($editorial);
		$autorBusqueda = trim($autor);
		
		//Relacion con LIBRO_AUTOR
		if(!empty($autorBusqueda) && $autorBusqueda != 0){
			$sql .= "INNER JOIN LIBRO_AUTOR ON (LIBRO.ID_LIBRO = LIBRO_AUTOR.ID_LIBRO) ";
		}
		
		$sql .= "WHERE 1 ";
		
		//Relacion con LIBRO_AUTOR
		if(!empty($autorBusqueda) && $autorBusqueda != 0){
			$sql .= "AND LIBRO_AUTOR.ID_AUTOR = ".$autorBusqueda." ";
		}
		
		if(!empty($tituloBusqueda)){
			$sql .= "AND LIBRO.TITULO LIKE '%".$tituloBusqueda."%' ";
		}
		
		if(!empty($isbnBusqueda)){
			$sql .= "AND LIBRO.ISBN LIKE '%".$isbnBusqueda."%' ";
		}

		if(!empty($codTopograficoBusqueda)){
			$sql .= "AND LIBRO.COD_TOPOGRAFICO LIKE '%".$codTopograficoBusqueda."%' ";
		}

		if(!empty($temasBusqueda)){
			$sql .= "AND LIBRO.TEMAS LIKE '%".$temasBusqueda."%' ";
		}

		if(!empty($editorialBusqueda)){
			$sql .= "AND LIBRO.ID_EDITORIAL = ".$editorialBusqueda;
		}
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }

	 //Funcion encargada de guardar un libro
	 function guardarLibro($idLibro, $titulo, $valor, $adquisicion, $estado, $isbn, $radicado,
	 	$fechaIngreso, $codTopografico, $serie, $idSede, $idEditorial, $idArea, $anio,
	 	$temas, $paginas, $disponibilidad, $idUsuario, $idCiudad, $cantidad, $idAutoresConcatenados){
		
		/**
		 * Se verifica el valor de $idLibro, en caso de ser diferente de 0 indica que es actualizacion, 
		 * de lo contrario se almacena un libro
		 */	
		if($idLibro != 0){
			return actualizarLibro($idLibro, $titulo, $valor, $adquisicion, $estado, $isbn, $radicado, 
			$fechaIngreso, $codTopografico, $serie, $idSede, $idEditorial, $idArea, $anio, $temas, $paginas, 
			$disponibilidad, $idUsuario, $idCiudad, $cantidad, $idAutoresConcatenados);
		}else{
		
	 	$genericoCrud = new DbCrud();

	 	$campos = "(";
	 	$valores = "(";

	 	$tituloLibro = trim($titulo);
	 	if(!empty($tituloLibro)){
	 		//Se omite la concatenacion de la coma inicial ya que este campo es obligatorio
			$campos .= "TITULO ";
			$valores .= "'".$tituloLibro."'";
		}

		$valorLibro = trim($valor);
	 	if(!empty($valorLibro)){
			$campos .= ",VALOR ";
			$valores .= ",'".$valorLibro."'";
		}

		$adquisicionLibro = trim($adquisicion);
	 	if(!empty($adquisicionLibro)){
			$campos .= ",ADQUISICION ";
			$valores .= ",'".$adquisicionLibro."'";
		}

		$estadoLibro = trim($estado);
	 	if(!empty($estadoLibro)){
			$campos .= ",ESTADO ";
			$valores .= ",'".$estadoLibro."'";
		}

		$isbnLibro = trim($isbn);
	 	if(!empty($isbnLibro)){
			$campos .= ",ISBN ";
			$valores .= ",'".$isbnLibro."'";
		}

		$radicadoLibro = trim($radicado);
	 	if(!empty($radicadoLibro)){
			$campos .= ",RADICADO ";
			$valores .= ",'".$radicadoLibro."'";
		}

		$fechaIngresoLibro = trim($fechaIngreso);
	 	if(!empty($fechaIngresoLibro)){
			$campos .= ",FECHA_INGRESO ";
			$valores .= ",'".$fechaIngresoLibro."'";
		}

		$codTopograficoLibro = trim($codTopografico);
	 	if(!empty($codTopograficoLibro)){
			$campos .= ",COD_TOPOGRAFICO ";
			$valores .= ",'".$codTopograficoLibro."'";
		}

		$serieLibro = trim($serie);
	 	if(!empty($serieLibro)){
			$campos .= ",SERIE ";
			$valores .= ",'".$serieLibro."'";
		}

		$idSedeLibro = trim($idSede);
	 	if(!empty($idSedeLibro)){
			$campos .= ",ID_SEDE ";
			$valores .= ",".$idSedeLibro;
		}

		$idEditorialLibro = trim($idEditorial);
	 	if(!empty($idEditorialLibro)){
			$campos .= ",ID_EDITORIAL ";
			$valores .= ",".$idEditorialLibro;
		}

		$idArealLibro = trim($idArea);
	 	if(!empty($idArealLibro)){
			$campos .= ",ID_AREA ";
			$valores .= ",".$idArealLibro;
		}

		$anioLibro = trim($anio);
	 	if(!empty($anioLibro)){
			$campos .= ",ANIO ";
			$valores .= ",".$anioLibro;
		}

		$temasLibro = trim($temas);
	 	if(!empty($temasLibro)){
			$campos .= ",TEMAS ";
			$valores .= ",'".$temasLibro."'";
		}

		$paginasLibro = trim($paginas);
	 	if(!empty($paginasLibro)){
			$campos .= ",PAGINAS ";
			$valores .= ",".$paginasLibro;
		}

		$disponibilidadLibro = trim($disponibilidad);
	 	if(!empty($disponibilidadLibro)){
			$campos .= ",DISPONIBILIDAD ";
			$valores .= ",'".$disponibilidadLibro."'";
		}

		$idUsuarioLibro = trim($idUsuario);
	 	if(!empty($idUsuarioLibro)){
			$campos .= ",ID_USUARIO ";
			$valores .= ",".$idUsuarioLibro;
		}

		$idCiudadLibro = trim($idCiudad);
	 	if(!empty($idCiudadLibro)){
			$campos .= ",ID_CIUDAD ";
			$valores .= ",".$idCiudadLibro;
		}
		
		$cantidadLibro = trim($cantidad);
	 	if(!empty($cantidadLibro)){
			$campos .= ",CANTIDAD ";
			$valores .= ",".$cantidadLibro;
		}

	 	$campos .= ")";
	 	$valores .= ")";

	 	$sql = "INSERT INTO LIBRO ".$campos." VALUES ".$valores;
	 	$result = $genericoCrud->sqlGenerico($sql);
		
		asociarAutorLibro(0, $idAutoresConcatenados);
		
		return $result;
		
		}

	 }


	 //Funcion encargada de actualizar un libro
	 function actualizarLibro($idLibro, $titulo, $valor, $adquisicion, $estado, $isbn, $radicado,
	 	$fechaIngreso, $codTopografico, $serie, $idSede, $idEditorial, $idArea, $anio,
	 	$temas, $paginas, $disponibilidad, $idUsuario, $idCiudad, $cantidad, $idAutoresConcatenados){

	 	$genericoCrud = new DbCrud();

	 	$sql = "UPDATE LIBRO SET TITULO = '".$titulo."', ";
		
		$sql .= "VALOR = '".$valor."', ";
		$sql .= "ADQUISICION = '".$adquisicion."', ";
		$sql .= "ESTADO = '".$estado."', ";
		$sql .= "ISBN = '".$isbn."', ";
		$sql .= "RADICADO = '".$radicado."', ";
		//$sql .= "FECHA_INGRESO = '".$valor."', "; no se modifa
		$sql .= "COD_TOPOGRAFICO = '".$codTopografico."', ";
		$sql .= "SERIE = '".$serie."', ";
		$sql .= "CANTIDAD = ".$cantidad.", ";
		
		
		$idSedeLibro = trim($idSede);
	 	if(!empty($idSedeLibro)){
			$sql .= "ID_SEDE = ".$idSedeLibro.", ";
		}
		
		$idEditorialLibro = trim($idEditorial);
	 	if(!empty($idEditorialLibro)){
			$sql .= "ID_EDITORIAL = ".$idEditorialLibro.", ";
		}

		$idArealLibro = trim($idArea);
	 	if(!empty($idArealLibro)){
			$sql .= "ID_AREA = ".$idArealLibro.", ";
		}
		
		$idCiudadLibro = trim($idCiudad);
	 	if(!empty($idCiudadLibro)){
			$sql .= "ID_CIUDAD = ".$idCiudadLibro.", ";
		}

		$sql .= "ANIO = ".$anio.", ";
		$sql .= "TEMAS = '".$temas."', ";
		$sql .= "PAGINAS = ".$paginas.", ";
		$sql .= "DISPONIBILIDAD = '".$disponibilidad."' ";
		//$sql .= "ID_USUARIO = '".$valor."', "; no se modifica
		
	 	
		$sql.= "WHERE ID_LIBRO = ".$idLibro;
		
	 	$result = $genericoCrud->sqlGenerico($sql);
		
		asociarAutorLibro($idLibro, $idAutoresConcatenados);
		
		return $result;

	 }

	//Funcion encargada de eliminar y almacenar los autores asociados a un libro
	//Si el idLibro  0; Se obtiene el ultimo registrado;
	function asociarAutorLibro($idLibro, $idAutoresConcatenados){
			
		$genericoCrud = new DbCrud();		
			
		//Obtenemos el ultimo libro registrado
		if($idLibro == 0){
			$sqlUltimoId = "SELECT MAX(ID_LIBRO) AS ID_LIBRO FROM LIBRO";
			$resultUltimo = $genericoCrud->selectGenerico($sqlUltimoId);
			
			$idLibro = $resultUltimo[0]['ID_LIBRO'];
		}
		
		//Se eliminan los registros previos
		$sqlDelete = "DELETE FROM LIBRO_AUTOR WHERE ID_LIBRO = ".$idLibro;
		$genericoCrud->sqlGenerico($sqlDelete);
		
		//Separamos la cadea de idAutores por comas
		$array = explode(",", $idAutoresConcatenados);
		
		//Se almacenan los nuevos registros
		for($i = 0; $i < count($array); $i++){
			$sql = "INSERT INTO LIBRO_AUTOR (ID_LIBRO, ID_AUTOR) VALUES (".$idLibro.",".$array[$i].")";
			$genericoCrud->sqlGenerico($sql);
		}
		
	}


	 //Funcion encargada de guardar un Autor
	 function guardarAutor($idAutor, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipo){
	 			
	 	/**
		 * Se verifica el valor de $idAutor, en caso de ser diferente de 0 indica que es actualizacion, 
		 * de lo contrario se almacena un autor
		 */	
		if($idAutor != 0){
			return actualizarAutor($idAutor, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipo);
		}else{

	 	$genericoCrud = new DbCrud();

	 	$campos = "(";
	 	$valores = "(";

	 	$primerNombreAutor = trim($primerNombre);
	 	if(!empty($primerNombreAutor)){
	 		//Se omite la concatenacion de la coma inicial ya que este campo es obligatorio
			$campos .= "PRIMER_NOMBRE ";
			$valores .= "'".$primerNombreAutor."'";
		}
		
		$segundoNombreAutor = trim($segundoNombre);
	 	if(!empty($segundoNombreAutor)){
			$campos .= ",SEGUNDO_NOMBRE ";
			$valores .= ",'".$segundoNombreAutor."'";
		}
		
		$primerApellidoAutor = trim($primerApellido);
	 	if(!empty($primerApellidoAutor)){
			$campos .= ",PRIMER_APELLIDO ";
			$valores .= ",'".$primerApellidoAutor."'";
		}
		
		$segundoApellidoAutor = trim($segundoApellido);
	 	if(!empty($segundoApellidoAutor)){
			$campos .= ",SEGUNDO_APELLIDO ";
			$valores .= ",'".$segundoApellidoAutor."'";
		}

		$tipoAutor = trim($tipo);
	 	if(!empty($tipoAutor)){
			$campos .= ",TIPO_AUTOR ";
			$valores .= ",'".$tipoAutor."'";
		}
		

	 	$campos .= ")";
	 	$valores .= ")";

	 	$sql = "INSERT INTO AUTOR ".$campos." VALUES ".$valores;
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result;
		
		}

	 }

	 //Funcion encargada de actualizar un autor
	 function actualizarAutor($idAutor, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipo){

	 	$genericoCrud = new DbCrud();

	 	$sql = "UPDATE AUTOR SET PRIMER_NOMBRE = '".$primerNombre."', ";
		
		$sql .= "SEGUNDO_NOMBRE = '".$segundoNombre."', ";
		$sql .= "PRIMER_APELLIDO = '".$primerApellido."', ";
		$sql .= "SEGUNDO_APELLIDO = '".$segundoApellido."', ";
		$sql .= "TIPO_AUTOR = '".$tipo."' ";
	 	
		$sql.= "WHERE ID_AUTOR = ".$idAutor;
		
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result;

	 }


	//Funcion encargada de guardar un Editorial
	 function guardarEditorial($idEditorial, $descripcion){

	 	$genericoCrud = new DbCrud();
	 	
	 	/**
		 * Se verifica el valor de $idEditorial, en caso de ser diferente de 0 indica que es actualizacion, 
		 * de lo contrario se almacena una editorial.
		 */	
		 if($idEditorial != 0){
			return actualizarEditorial($idEditorial, $descripcion);
		 }else{
		 	$sql = "INSERT INTO EDITORIAL (descripcion) VALUES ('".$descripcion."')";
		 	$result = $genericoCrud->sqlGenerico($sql);
			return $result;
		 }
		
	 }
	 
	 //Funcion encargada de actualizar una editorial
	 function actualizarEditorial($idEditorial, $descripcion){
	 							
	 	$genericoCrud = new DbCrud();

	 	$sql = "UPDATE EDITORIAL SET DESCRIPCION = '".$descripcion."' ";
		$sql.= "WHERE ID_EDITORIAL = ".$idEditorial;
		
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result; 	
	 }


	//Funcion encargada de guardar un Usuario
	 function guardarUsuario($idUsuario, $cedula, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, 
	 	$telefono, $direccion, $email, $codigo, $clave, $rol){

	 	$genericoCrud = new DbCrud();

	 	$campos = "(";
	 	$valores = "(";

		/**
		 * Se verifica el valor de $idUsuario, en caso de ser diferente de 0 indica que es actualizacion, 
		 * de lo contrario se almacena un usuario
		 */	
		if($idUsuario != 0){
			return actualizarUsuario($idUsuario, $cedula, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, 
	 		$telefono, $direccion, $email, $codigo, $clave, $rol);
		}else{

	 	$cedulaUsuario = trim($cedula);
	 	if(!empty($cedulaUsuario)){
	 		//Se omite la concatenacion de la coma inicial ya que este campo es obligatorio
			$campos .= "CEDULA ";
			$valores .= $cedulaUsuario; 
		}

		$primerNombreUsuario = trim($primerNombre);
	 	if(!empty($primerNombreUsuario)){
			$campos .= ",PRIMER_NOMBRE ";
			$valores .= ",'".$primerNombreUsuario."'";
		}

		$segundoNombreUsuario = trim($segundoNombre);
	 	if(!empty($segundoNombreUsuario)){
			$campos .= ",SEGUNDO_NOMBRE ";
			$valores .= ",'".$segundoNombreUsuario."'";
		}
		
		$primerApellidoUsuario = trim($primerApellido);
	 	if(!empty($primerApellidoUsuario)){
			$campos .= ",PRIMER_APELLIDO ";
			$valores .= ",'".$primerApellidoUsuario."'";
		}
		
		$segundoApellidoUsuario = trim($segundoApellido);
	 	if(!empty($segundoApellidoUsuario)){
			$campos .= ",SEGUNDO_APELLIDO ";
			$valores .= ",'".$segundoApellidoUsuario."'";
		}

		$telefonoUsuario = trim($telefono);
	 	if(!empty($telefonoUsuario)){
			$campos .= ",TELEFONO ";
			$valores .= ",".$telefonoUsuario;
		}

		$direccionUsuario = trim($direccion);
	 	if(!empty($direccionUsuario)){
			$campos .= ",DIRECCION ";
			$valores .= ",'".$direccionUsuario."'";
		}

		$emailUsuario = trim($email);
	 	if(!empty($emailUsuario)){
			$campos .= ",EMAIL ";
			$valores .= ",'".$emailUsuario."'";
		}

		$codigoUsuario = trim($codigo);
	 	if(!empty($codigoUsuario)){
			$campos .= ",CODIGO ";
			$valores .= ",'".$codigoUsuario."'";
		}

		$claveUsuario = trim($clave);
	 	if(!empty($claveUsuario)){
			$campos .= ",CLAVE ";
			$valores .= ",'".$claveUsuario."'";
		}

		$rolUsuario = trim($rol);
	 	if(!empty($rolUsuario)){
			$campos .= ",ROL ";
			$valores .= ",'".$rolUsuario."'";
		}

		

	 	$campos .= ")";
	 	$valores .= ")";

	 	$sql = "INSERT INTO USUARIO ".$campos." VALUES ".$valores;
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result;
		
		}
	 }
	 
	 
	 //Funcion encargada de actualizar un usuario
	 function actualizarUsuario($idUsuario, $cedula, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, 
	 		$telefono, $direccion, $email, $codigo, $clave, $rol){

	 	$genericoCrud = new DbCrud();

	 	$sql = "UPDATE USUARIO SET CEDULA = ".$cedula.", ";
		
		$sql .= "PRIMER_NOMBRE = '".$primerNombre."', ";
		$sql .= "SEGUNDO_NOMBRE = '".$segundoNombre."', ";
		$sql .= "PRIMER_APELLIDO = '".$primerApellido."', ";
		$sql .= "SEGUNDO_APELLIDO = '".$segundoApellido."', ";
		$sql .= "TELEFONO = ".$telefono.", ";
		$sql .= "DIRECCION = '".$direccion."', ";
		$sql .= "EMAIL = '".$email."', ";
		$sql .= "CODIGO = '".$codigo."', ";
		$sql .= "CLAVE = '".$clave."', ";
		$sql .= "ROL = '".$rol."' ";
		
		$sql.= "WHERE ID_USUARIO = ".$idUsuario;
		
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result;

	 }
	 
	 
	 
	
	/**
	 * ////////////////////////////////////////////////
	 * ////////////////// REGISTRO DE FUNCIONES ///////
	 * ////////////////////////////////////////////////
	 */
	
	//Create a complex type (Para el tipo array de la funcion retornaArray)
	/*$server->wsdl->addComplexType('MyComplexType',
		'complexType','struct','all','',
		array('contacto' => array('name' => 'contacto', 'type' => 'xsd:string'),
			  'email' => array('name' => 'email', 'type' => 'xsd:string')));*/
			  
	//Se registra la funcion retornaArray
	$server->register(
		// Method name:
		'listadoLibros',
		// parameter list:
		array('titulo'=>'xsd:string',
			'isbn'=>'xsd:string',
			'codTopografico'=>'xsd:string',
			'temas'=>'xsd:string',
			'editorial'=>'xsd:int',
			'autor'=>'xsd:int'),
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
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion login
	$server->register(
		// Method name:
		'login',
		// parameter list:
		array('codigo'=>'xsd:string', 'clave'=>'xsd:string'),
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
		'Metodo retorna array con el usuario encontrado segun login y password ');

	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion guardarLibro
	$server->register(
		// Method name:
		'guardarLibro',
		// parameter list:
		array('idLibro'=>'xsd:int',
			'titulo'=>'xsd:string', 
			'valor'=>'xsd:string',
			'adquisicion'=>'xsd:string',
			'estado'=>'xsd:string',
			'isbn'=>'xsd:string',
			'radicado'=>'xsd:string',
			'fechaIngreso'=>'xsd:string',
			'codTopografico'=>'xsd:string',
			'serie'=>'xsd:string',
			'idSede'=>'xsd:int',
			'idEditorial'=>'xsd:int',
			'idArea'=>'xsd:int',
			'anio'=>'xsd:int',
			'temas'=>'xsd:string',
			'paginas'=>'xsd:int',
			'disponibilidad'=>'xsd:string',
			'idUsuario'=>'xsd:int',
			'idCiudad'=>'xsd:int',
			'cantidad'=>'xsd:int',
			'idAutoresConcatenados'=>'xsd:string'
			),
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
		'Metodo que permite guardar/actualizar un Libro en la BD ');

//******************************//****************************//****************************++

	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion guardarAutor
	$server->register(
		// Method name:
		'guardarAutor',
		// parameter list:
		array('idAutor'=>'xsd:int',
			'primerNombre'=>'xsd:string',
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
		'Metodo permite Guardar un Autor en la BD');

//******************************//****************************//****************************++

	//******************************//****************************//****************************++

	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion guardarEditorial
	$server->register(
		// Method name:
		'guardarEditorial',
		// parameter list:
		array('idEditorial'=>'xsd:int',
			'descripcion'=>'xsd:string'),
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
		'Metodo permite Guardar una Editorial en la BD');

//******************************//****************************//****************************++
		///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion guardarUsuario
	$server->register(
		// Method name:
		'guardarUsuario',
		// parameter list:
		array('idUsuario'=>'xsd:int',
			'cedula'=>'xsd:int', 
			'primerNombre'=>'xsd:string',
			'segundoNombre'=>'xsd:string',
			'primerApellido'=>'xsd:string',
			'segundoApellido'=>'xsd:string',
			'telefono'=>'xsd:int',
			'direccion'=>'xsd:string',
			'email'=>'xsd:string',
			'codigo'=>'xsd:string',
			'clave'=>'xsd:string',
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
		'Metodo que permite guardar un usuario en la BD ');
		
		
//******************************//****************************//****************************++
	
	//$server->service($HTTP_RAW_POST_DATA);
	$server->service(file_get_contents("php://input"));
?>