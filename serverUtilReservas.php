<?php

	/**
	 * ////////////////////////////////////////////////
	 * ////////////////// FUNCIONES ///////////////////
	 * ////////////////////////////////////////////////
	 */
	 
	 //Funcion encargada de listar las Reservas
	 function listadoReservas($titulo, $isbn, $codTopografico, $temas, $editorial, 
	 	$idUsuarioReserva, $estadoReserva, $codUsuario, $cedulaUsuario, $fechaSolicitud, $autor){
	 		
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT sol.ID_SOLICITUD, sol.FECHA_SOLICITUD, sol.FECHA_RESERVA, sol.FECHA_DEVOLUCION, 
		sol.FECHA_ENTREGA, sol.ID_USUARIO as ID_USUARIO_SOL, sol.ID_LIBRO as ID_LIBRO_SOL, sol.ESTADO as ESTADO_SOL, 
		lib.ID_LIBRO as ID_LIBRO_LIB, lib.TITULO, lib.VALOR, lib.ADQUISICION, lib.ESTADO as ESTADO_LIB, lib.ISBN, 
		lib.RADICADO, lib.FECHA_INGRESO as FECHA_INGRESO_LIB, lib.COD_TOPOGRAFICO, lib.SERIE, 
		lib.ID_SEDE, lib.ID_EDITORIAL, lib.ID_AREA, lib.ANIO, lib.TEMAS, lib.PAGINAS, lib.DISPONIBILIDAD, 
		lib.ID_USUARIO as ID_USUARIO_LIB, lib.ID_CIUDAD as ID_CIUDAD_LIB, 
		user.ID_USUARIO as ID_USUARIO_USER, user.CEDULA, user.PRIMER_NOMBRE, user.SEGUNDO_NOMBRE, user.PRIMER_APELLIDO, 
		user.SEGUNDO_APELLIDO, user.TELEFONO, user.DIRECCION as DIRECCION_USER, user.EMAIL, user.CODIGO as CODIGO_USER, 
		user.CLAVE as CLAVE_USER, user.ROL 
		FROM SOLICITUD sol
		INNER JOIN LIBRO lib ON (sol.ID_LIBRO = lib.ID_LIBRO) 
		INNER JOIN USUARIO user ON (sol.ID_USUARIO = user.ID_USUARIO) ";
		
		//Se agregan los parametros de busqueda a la sql
		$tituloBusqueda = trim($titulo);
		$isbnBusqueda = trim($isbn);
		$codTopograficoBusqueda = trim($codTopografico);
		$temasBusqueda = trim($temas);
		$editorialBusqueda = trim($editorial);
		$idUsuarioReservaBusqueda = trim($idUsuarioReserva);
		$estadoReservaBusqueda = trim($estadoReserva);
		$codUsuarioBusqueda = trim($codUsuario);
		$cedulaUsuarioBusqueda = trim($cedulaUsuario);
		$fechaSolicitudBusqueda = trim($fechaSolicitud);
		$autorBusqueda = trim($autor);
		
		//Relacion con LIBRO_AUTOR
		if(!empty($autorBusqueda) && $autorBusqueda != 0){
			$sql .= "INNER JOIN LIBRO_AUTOR ON (lib.ID_LIBRO = LIBRO_AUTOR.ID_LIBRO) ";
		}
		
		
		$sql .= "WHERE 1 ";
		
		//Relacion con LIBRO_AUTOR
		if(!empty($autorBusqueda) && $autorBusqueda != 0){
			$sql .= "AND LIBRO_AUTOR.ID_AUTOR = ".$autorBusqueda." ";
		}
		
		
		if(!empty($tituloBusqueda)){
			$sql .= "AND lib.TITULO LIKE '%".$tituloBusqueda."%' ";
		}
		
		if(!empty($isbnBusqueda)){
			$sql .= "AND lib.ISBN LIKE '%".$isbnBusqueda."%' ";
		}

		if(!empty($codTopograficoBusqueda)){
			$sql .= "AND lib.COD_TOPOGRAFICO LIKE '%".$codTopograficoBusqueda."%' ";
		}

		if(!empty($temasBusqueda)){
			$sql .= "AND lib.TEMAS LIKE '%".$temasBusqueda."%' ";
		}

		if(!empty($editorialBusqueda)){
			$sql .= "AND lib.ID_EDITORIAL = ".$editorialBusqueda." ";
		}
		
		//Se filtra por el usuarioReserva
		//En caso de 0, no se tiene en cuenta este filtro
		if(!empty($idUsuarioReservaBusqueda) && $idUsuarioReservaBusqueda != 0){
			$sql .= "AND sol.ID_USUARIO = ".$idUsuarioReservaBusqueda." ";
		}
		
		//Se filtra por el estadoReserva
		//En caso de vacio, no se tiene en cuenta este filtro
		if(!empty($estadoReservaBusqueda)){
			$sql .= "AND sol.ESTADO = '".$estadoReservaBusqueda."' ";
		}
		
		if(!empty($codUsuarioBusqueda)){
			$sql .= "AND user.CODIGO = '".$codUsuarioBusqueda."' ";
		}
		
		if(!empty($cedulaUsuarioBusqueda) && $cedulaUsuarioBusqueda != 0){
			$sql .= "AND user.CEDULA = ".$cedulaUsuarioBusqueda." ";
		}
		
		if(!empty($fechaSolicitudBusqueda)){
			$sql .= "AND sol.FECHA_SOLICITUD = '".$fechaSolicitudBusqueda."' ";
		}
		
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;	
		
	 }
	 
	 
	 //Funcion encargada de guardar una reserva
	 function reservar($fechaSolicitud, $fechaReserva, $fechaDevolucion,
	 	$idUsuario, $idLibro, $estado){

	 	$genericoCrud = new DbCrud();

	 	$campos = "(";
	 	$valores = "(";

	 	$fsolicitud = trim($fechaSolicitud);
	 	if(!empty($fsolicitud)){
	 		//Se omite la concatenacion de la coma inicial ya que este campo es obligatorio
			$campos .= "FECHA_SOLICITUD ";
			$valores .= "'".$fsolicitud."'"; 
		}

		$fReserva = trim($fechaReserva);
	 	if(!empty($fReserva)){
			$campos .= ",FECHA_RESERVA ";
			$valores .= ",'".$fReserva."'";
		}

		$fDevolucion = trim($fechaDevolucion);
	 	if(!empty($fDevolucion)){
			$campos .= ",FECHA_DEVOLUCION ";
			$valores .= ",'".$fDevolucion."'";
		}

		$usuario = trim($idUsuario);
	 	if(!empty($usuario)){
			$campos .= ",ID_USUARIO ";
			$valores .= ",".$usuario;
		}

		$libro = trim($idLibro);
	 	if(!empty($libro)){
			$campos .= ",ID_LIBRO ";
			$valores .= ",".$libro;
		}

		$estatus = trim($estado);
	 	if(!empty($estatus)){
			$campos .= ",ESTADO ";
			$valores .= ",'".$estatus."'";
		}

		$campos .= ")";
	 	$valores .= ")";

	 	$sql = "INSERT INTO SOLICITUD ".$campos." VALUES ".$valores;
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result;

	 }


	/**
	 * Funcion encargada de modificar el estado de una solicitud. 
	 * El llamado al WS recibe los parametros:
     *  - idSolicitud: En caso de ser = 0, se actualizaran todas las solicitudes, junto con el parametro "updateAll".
     *  - estado: Estado al cual se modificara la solicitud. 
	 * 		funcionalidad correspondiente a la actualizacion diara de las solicitudes segun fecha reserva.
	 *  - fechaEntrega: Indica la fecha en la cual se regresa el libro.
	 *  - updateAll: Indica si se actualizan todas las solicitudes o no,
	 */
	function actualizarSolicitud($idSolicitud, $estado, $fechaEntrega, $updateAll){
		
		$idSolicitudActualizar = trim($idSolicitud);
		$estadoActualizar  = trim($estado);
		$updateAll = trim($updateAll);
		$fechaEntregaLibro = trim($fechaEntrega);
		
		
		if($idSolicitudActualizar == 0 && $updateAll == "true"){ //Actualizar estados automaticamente
				
			//Se actualizan todos los estados segun la fecha de reserva y fecha actual.
			//pasar de estado  "EN PROCESO" a estado "CANCELADO"
			
			//Tambien se actualizan los estados dado el caso que el libro este en mora. luego 
			//de que el libro haya sido prestado al usuario pero este no se ha regresado luego 
			//de vencer la fecha de devolución.
			
		}
		else if($idSolicitudActualizar != 0 && $updateAll == "false"){ //Actualizar un estado (PRESTAR O REGRESAR LIBRO)
				
			//Se actualiza solo el estado de la solicitud señalada.
			$genericoCrud = new DbCrud();
	 		
	 		//Actualizar un estado (Prestar Libro)
	 		$sql = "UPDATE SOLICITUD SET ESTADO = '".$estadoActualizar."' ";
			
			//Se actaliza la fecha de entrega si se esta regresando el libro.
			if(!empty($fechaEntregaLibro)){
				$sql .= ", FECHA_ENTREGA = '".$fechaEntregaLibro."' ";	
			}
			
			$sql .= "WHERE ID_SOLICITUD = ".$idSolicitudActualizar;
			
			$result = $genericoCrud->sqlGenerico($sql);
			return $result;
		}
		
	}


	 //funcion encargada de buscar una el valor general de las multas
	 function buscarValorMulta(){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT VALOR FROM VALOR_MULTA";
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 //Funcion encargada de guardar una multa
	 function guardarMulta($idSolicitud, $valorSugerido, $valorCancelado, $diasMora, $nota){

	 	$genericoCrud = new DbCrud();

	 	$campos = "(";
	 	$valores = "(";

	 	$idSolicitudGuardar = trim($idSolicitud);
	 	if(!empty($idSolicitudGuardar)){
	 		//Se omite la concatenacion de la coma inicial ya que este campo es obligatorio
			$campos .= "ID_SOLICITUD ";
			$valores .= $idSolicitudGuardar;
		}

		$valorSugeridoGuardar = trim($valorSugerido);
	 	if(!empty($valorSugeridoGuardar)){
			$campos .= ",VALOR_SUGERIDO ";
			$valores .= ",".$valorSugeridoGuardar;
		}
		
		$valorCanceladoGuardar = trim($valorCancelado);
	 	if(!empty($valorCanceladoGuardar)){
			$campos .= ",VALOR_CANCELADO ";
			$valores .= ",".$valorCanceladoGuardar;
		}
		
		$diasMoraGuardar = trim($diasMora);
	 	if(!empty($diasMoraGuardar)){
			$campos .= ",DIAS_MORA ";
			$valores .= ",".$diasMoraGuardar;
		}
			
		$notaGuardar = trim($nota);
	 	if(!empty($notaGuardar)){
			$campos .= ",NOTA ";
			$valores .= ",'".$notaGuardar."'";
		}		

	 	$campos .= ")";
	 	$valores .= ")";

	 	$sql = "INSERT INTO MULTAS ".$campos." VALUES ".$valores;
	 	$result = $genericoCrud->sqlGenerico($sql);
		return $result;
		
	 }
	
	
	 //funcion encargada de buscar una Solicitud segun su ID
	 function buscarSolicitudPorId($idSolicitud){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT * FROM SOLICITUD WHERE ID_SOLICITUD = ".$idSolicitud;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }
	 
	 
	 //funcion encargada de verificar si un libro esta disponible segun su rango de fechas de reserva
	 function verificarDisponibilidadDate($idLibro, $rangoFechasReserva){
	 	$result = array();		
	 	$genericoCrud = new DbCrud();	
	 		
	 	//Separamos la cadea de idAutores por comas
		$array = explode(",", $rangoFechasReserva);
		
		for($i=0; $i < count($array); $i++){
		
			$sql = "SELECT * FROM SOLICITUD ";
			$sql .= "WHERE ('".$array[$i]."' BETWEEN FECHA_RESERVA AND FECHA_DEVOLUCION) ";
			$sql .= "AND (ESTADO = 'EN PROCESO' OR ESTADO = 'PRESTADO' OR ESTADO = 'EN MORA') ";
			$sql .= "AND ID_LIBRO = ".$idLibro;
			
			$result = $genericoCrud->selectGenerico($sql);
			
			if(count($result) > 0){
				break;
			}
		}
		
		return count($result);
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
			  
	//Se registra la funcion listadoReservas
	$server->register(
		// Method name:
		'listadoReservas',
		// parameter list:
		array('titulo'=>'xsd:string',
			'isbn'=>'xsd:string',
			'codTopografico'=>'xsd:string',
			'temas'=>'xsd:string',
			'editorial'=>'xsd:int',
			'idUsuarioReserva'=>'xsd:int',
			'estadoReserva'=>'xsd:string',
			'codUsuario'=>'xsd:string',
			'cedulaUsuario'=>'xsd:int',
			'fechaSolicitud'=>'xsd:string',
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
		'Metodo retorna listadoReservas ');
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion reservar
	$server->register(
		// Method name:
		'reservar',
		// parameter list:
		array('fechaSolicitud'=>'xsd:string', 
			'fechaReserva'=>'xsd:string',
			'fechaDevolucion'=>'xsd:string',
			'idUsuario'=>'xsd:int',
			'idLibro'=>'xsd:int',
			'estado'=>'xsd:string',		
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
		'Metodo que permite guardar la reserva de un libro ');
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion actualizarSolicitud
	$server->register(
		// Method name:
		'actualizarSolicitud',
		// parameter list:
		array('idSolicitud'=>'xsd:int', 
			'estado'=>'xsd:string',
			'fechaEntrega'=>'xsd:string',
			'updateAll'=>'xsd:string'),
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
		'Metodo que permite actualizar las solicitudes ');
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarValorMulta
	$server->register(
		// Method name:
		'buscarValorMulta',
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
		'Metodo que permite buscar el valor general de las multas ');
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion guardarMulta
	$server->register(
		// Method name:
		'guardarMulta',
		// parameter list:
		array('idSolicitud'=>'xsd:int',
			'valorSugerido'=>'xsd:int',
			'valorCancelado'=>'xsd:int',
			'diasMora'=>'xsd:int',
			'nota'=>'xsd:string'),
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
		'Metodo permite Guardar una MULTA en la BD');


	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarSolicitudPorId
	$server->register(
		// Method name:
		'buscarSolicitudPorId',
		// parameter list:
		array('idSolicitud'=>'xsd:int'),
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
		'Metodo retorna una Solicitud segun su ID ');
		
		
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion verificarDisponibilidadDate
	$server->register(
		// Method name:
		'verificarDisponibilidadDate',
		// parameter list:
		array('idLibro'=>'xsd:int',
			'rangoFechasReserva'=>'xsd:string'),
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
		'Metodo permite verificar la disponiblidad de un libro segun fechas de reserva');

?>