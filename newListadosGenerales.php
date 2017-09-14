<?php

	/**
	 * ////////////////////////////////////////////////
	 * ////////////////// FUNCIONES ///////////////////
	 * ////////////////////////////////////////////////
	 */

//Funcion listado de libros con sus respectivos datos relacionales
function listadoLibrosNew($titulo, $isbn, $codTopografico, $temas, $editorial, $autor){

	$result = array();
	$genericoCrud = new DbCrud();
	
	//Se seleccionan todos los datos del libro, ademas se asigna el alias "EST_LIBRO" al campo ESTADO de libro
	$sql = "SELECT LIB.*, LIB.ESTADO AS EST_LIBRO, ";
	$sql .= "AR.DESCRIPCION AS DES_AREA, ";
	$sql .= "EDI.DESCRIPCION AS DES_EDITORIAL, ";
	$sql .= "CIU.NOMBRE AS NOM_CIUDAD, ";
	$sql .= "PA.ID_PAIS, PA.NOMBRE AS NOM_PAIS, ";
	$sql .= "SD.DESCRIPCION AS DES_SEDE ";
	$sql .= "FROM LIBRO LIB ";
	$sql .= "LEFT JOIN AREA AR ON (LIB.ID_AREA = AR.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL EDI ON (LIB.ID_EDITORIAL = EDI.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD CIU ON (LIB.ID_CIUDAD = CIU.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS PA ON (CIU.ID_PAIS = PA.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE SD ON (LIB.ID_SEDE = SD.ID_SEDE) ";

	//Se agregan los parametros de busqueda a la sql
	$tituloBusqueda = trim($titulo);
	$isbnBusqueda = trim($isbn);
	$codTopograficoBusqueda = trim($codTopografico);
	$temasBusqueda = trim($temas);
	$editorialBusqueda = trim($editorial);
	$autorBusqueda = trim($autor);

	//Relacion con LIBRO_AUTOR
	if(!empty($autorBusqueda) && $autorBusqueda != 0){
		$sql .= "INNER JOIN LIBRO_AUTOR ON (LIB.ID_LIBRO = LIBRO_AUTOR.ID_LIBRO) ";
	}

	$sql .= "WHERE 1 ";
	
	//Relacion con LIBRO_AUTOR
	if(!empty($autorBusqueda) && $autorBusqueda != 0){
		$sql .= "AND LIBRO_AUTOR.ID_AUTOR = ".$autorBusqueda." ";
	}


	if(!empty($tituloBusqueda)){
		$sql .= "AND LIB.TITULO LIKE '%".$tituloBusqueda."%' ";
	}
	
	if(!empty($isbnBusqueda)){
		$sql .= "AND LIB.ISBN LIKE '%".$isbnBusqueda."%' ";
	}

	if(!empty($codTopograficoBusqueda)){
		$sql .= "AND LIB.COD_TOPOGRAFICO LIKE '%".$codTopograficoBusqueda."%' ";
	}

	if(!empty($temasBusqueda)){
		$sql .= "AND LIB.TEMAS LIKE '%".$temasBusqueda."%' ";
	}

	if(!empty($editorialBusqueda)){
		$sql .= "AND LIB.ID_EDITORIAL = ".$editorialBusqueda;
	}
	
	$result = $genericoCrud->selectGenerico($sql);
	return $result;
}	


//Funcion totalLibros
function cantidadLibros($titulo, $isbn, $codTopografico, $temas, $editorial, $autor){

	$result = array();
	$genericoCrud = new DbCrud();
	
	//Se seleccionan todos los datos del libro, ademas se asigna el alias "EST_LIBRO" al campo ESTADO de libro
	$sql = "SELECT COUNT(LIB.ID_LIBRO) AS TOTAL ";
	$sql .= "FROM LIBRO LIB ";
	$sql .= "LEFT JOIN AREA AR ON (LIB.ID_AREA = AR.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL EDI ON (LIB.ID_EDITORIAL = EDI.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD CIU ON (LIB.ID_CIUDAD = CIU.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS PA ON (CIU.ID_PAIS = PA.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE SD ON (LIB.ID_SEDE = SD.ID_SEDE) ";

	//Se agregan los parametros de busqueda a la sql
	$tituloBusqueda = trim($titulo);
	$isbnBusqueda = trim($isbn);
	$codTopograficoBusqueda = trim($codTopografico);
	$temasBusqueda = trim($temas);
	$editorialBusqueda = trim($editorial);
	$autorBusqueda = trim($autor);

	//Relacion con LIBRO_AUTOR
	if(!empty($autorBusqueda) && $autorBusqueda != 0){
		$sql .= "INNER JOIN LIBRO_AUTOR ON (LIB.ID_LIBRO = LIBRO_AUTOR.ID_LIBRO) ";
	}

	$sql .= "WHERE 1 ";
	
	//Relacion con LIBRO_AUTOR
	if(!empty($autorBusqueda) && $autorBusqueda != 0){
		$sql .= "AND LIBRO_AUTOR.ID_AUTOR = ".$autorBusqueda." ";
	}


	if(!empty($tituloBusqueda)){
		$sql .= "AND LIB.TITULO LIKE '%".$tituloBusqueda."%' ";
	}
	
	if(!empty($isbnBusqueda)){
		$sql .= "AND LIB.ISBN LIKE '%".$isbnBusqueda."%' ";
	}

	if(!empty($codTopograficoBusqueda)){
		$sql .= "AND LIB.COD_TOPOGRAFICO LIKE '%".$codTopograficoBusqueda."%' ";
	}

	if(!empty($temasBusqueda)){
		$sql .= "AND LIB.TEMAS LIKE '%".$temasBusqueda."%' ";
	}

	if(!empty($editorialBusqueda)){
		$sql .= "AND LIB.ID_EDITORIAL = ".$editorialBusqueda;
	}
	
	$result = $genericoCrud->selectGenerico($sql);
	return $result[0]['TOTAL'];
} 


//Funcion listado de libros PAGINADOS con sus respectivos datos relacionales
function listadoLibrosPagindosNew($titulo, $isbn, $codTopografico, $temas, $editorial, $autor, $offSet, $limit){

	$result = array();
	$genericoCrud = new DbCrud(); 
	
	//Se seleccionan todos los datos del libro, ademas se asigna el alias "EST_LIBRO" al campo ESTADO de libro
	$sql = "SELECT LIB.*, LIB.ESTADO AS EST_LIBRO, ";
	$sql .= "AR.DESCRIPCION AS DES_AREA, ";
	$sql .= "EDI.DESCRIPCION AS DES_EDITORIAL, ";
	$sql .= "CIU.NOMBRE AS NOM_CIUDAD, ";
	$sql .= "PA.ID_PAIS, PA.NOMBRE AS NOM_PAIS, ";
	$sql .= "SD.DESCRIPCION AS DES_SEDE ";
	$sql .= "FROM LIBRO LIB ";
	$sql .= "LEFT JOIN AREA AR ON (LIB.ID_AREA = AR.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL EDI ON (LIB.ID_EDITORIAL = EDI.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD CIU ON (LIB.ID_CIUDAD = CIU.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS PA ON (CIU.ID_PAIS = PA.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE SD ON (LIB.ID_SEDE = SD.ID_SEDE) ";
	

	//Se agregan los parametros de busqueda a la sql
	$tituloBusqueda = trim($titulo);
	$isbnBusqueda = trim($isbn);
	$codTopograficoBusqueda = trim($codTopografico);
	$temasBusqueda = trim($temas);
	$editorialBusqueda = trim($editorial);
	$autorBusqueda = trim($autor);

	//Relacion con LIBRO_AUTOR
	if(!empty($autorBusqueda) && $autorBusqueda != 0){
		$sql .= "INNER JOIN LIBRO_AUTOR ON (LIB.ID_LIBRO = LIBRO_AUTOR.ID_LIBRO) ";
	}

	$sql .= "WHERE 1 ";
	
	//Relacion con LIBRO_AUTOR
	if(!empty($autorBusqueda) && $autorBusqueda != 0){
		$sql .= "AND LIBRO_AUTOR.ID_AUTOR = ".$autorBusqueda." ";
	}


	if(!empty($tituloBusqueda)){
		$sql .= "AND LIB.TITULO LIKE '%".$tituloBusqueda."%' ";
	}
	
	if(!empty($isbnBusqueda)){
		$sql .= "AND LIB.ISBN LIKE '%".$isbnBusqueda."%' ";
	}

	if(!empty($codTopograficoBusqueda)){
		$sql .= "AND LIB.COD_TOPOGRAFICO LIKE '%".$codTopograficoBusqueda."%' ";
	}

	if(!empty($temasBusqueda)){
		$sql .= "AND LIB.TEMAS LIKE '%".$temasBusqueda."%' ";
	}

	if(!empty($editorialBusqueda)){
		$sql .= "AND LIB.ID_EDITORIAL = ".$editorialBusqueda." ";
	}
	
	//Paginacion
	$sql .= "LIMIT ".$offSet.",".$limit;
	
	$result = $genericoCrud->selectGenerico($sql);
	return $result;
}


 //Funcion encargada de listar las Reservas
 function listadoReservasNew($titulo, $isbn, $codTopografico, $temas, $editorial, 
 	$idUsuarioReserva, $estadoReserva, $codUsuario, $cedulaUsuario, $fechaSolicitud, $autor){
 		
 	$result = array();
	$genericoCrud = new DbCrud();
	
	$sql = "SELECT sol.ID_SOLICITUD, sol.FECHA_SOLICITUD, sol.FECHA_RESERVA, sol.FECHA_DEVOLUCION, "; 
	$sql .= "sol.FECHA_ENTREGA, sol.ID_USUARIO as ID_USUARIO_SOL, ";
	$sql .= "sol.ID_LIBRO as ID_LIBRO_SOL, sol.ESTADO as ESTADO_SOL, ";
	$sql .= "lib.*, lib.ESTADO as EST_LIBRO, ";
	$sql .= "lib.ID_USUARIO as ID_USUARIO_LIB, ";
	$sql .= "sd.DESCRIPCION as DES_SEDE, ";
	$sql .= "edi.DESCRIPCION AS DES_EDITORIAL, ";
	$sql .= "ar.DESCRIPCION AS DES_AREA, ";
	$sql .= "ciu.NOMBRE AS NOM_CIUDAD, ";
	$sql .= "pa.ID_PAIS, pa.NOMBRE AS NOM_PAIS, ";
	$sql .= "user.* ";
	$sql .= "FROM SOLICITUD sol ";
	$sql .= "INNER JOIN LIBRO lib ON (sol.ID_LIBRO = lib.ID_LIBRO) "; 
	$sql .= "INNER JOIN USUARIO user ON (sol.ID_USUARIO = user.ID_USUARIO) ";
	$sql .= "LEFT JOIN AREA ar ON (lib.ID_AREA = ar.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL edi ON (lib.ID_EDITORIAL = edi.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD ciu ON (lib.ID_CIUDAD = ciu.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS pa ON (ciu.ID_PAIS = pa.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE sd ON (lib.ID_SEDE = sd.ID_SEDE) ";
	
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


 //Funcion encargada de listar la cantidad Reservas
 function cantidadReservas($titulo, $isbn, $codTopografico, $temas, $editorial, 
 	$idUsuarioReserva, $estadoReserva, $codUsuario, $cedulaUsuario, $fechaSolicitud, $autor){
 		
 	$result = array();
	$genericoCrud = new DbCrud();
	
	$sql = "SELECT COUNT(sol.ID_SOLICITUD) AS TOTAL ";
	$sql .= "FROM SOLICITUD sol ";
	$sql .= "INNER JOIN LIBRO lib ON (sol.ID_LIBRO = lib.ID_LIBRO) "; 
	$sql .= "INNER JOIN USUARIO user ON (sol.ID_USUARIO = user.ID_USUARIO) ";
	$sql .= "LEFT JOIN AREA ar ON (lib.ID_AREA = ar.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL edi ON (lib.ID_EDITORIAL = edi.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD ciu ON (lib.ID_CIUDAD = ciu.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS pa ON (ciu.ID_PAIS = pa.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE sd ON (lib.ID_SEDE = sd.ID_SEDE) ";
	
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
	return $result[0]['TOTAL'];	
	
 }


 //Funcion encargada de listar las Reservas paginadas
 function listadoReservaPaginadas($titulo, $isbn, $codTopografico, $temas, $editorial, 
 	$idUsuarioReserva, $estadoReserva, $codUsuario, $cedulaUsuario, $fechaSolicitud, $autor, $offSet, $limit){
 		
 	$result = array();
	$genericoCrud = new DbCrud();
	
	$sql = "SELECT sol.ID_SOLICITUD, sol.FECHA_SOLICITUD, sol.FECHA_RESERVA, sol.FECHA_DEVOLUCION, "; 
	$sql .= "sol.FECHA_ENTREGA, sol.ID_USUARIO as ID_USUARIO_SOL, ";
	$sql .= "sol.ID_LIBRO as ID_LIBRO_SOL, sol.ESTADO as ESTADO_SOL, ";
	$sql .= "lib.*, lib.ESTADO as EST_LIBRO, ";
	$sql .= "lib.ID_USUARIO as ID_USUARIO_LIB, ";
	$sql .= "sd.DESCRIPCION as DES_SEDE, ";
	$sql .= "edi.DESCRIPCION AS DES_EDITORIAL, ";
	$sql .= "ar.DESCRIPCION AS DES_AREA, ";
	$sql .= "ciu.NOMBRE AS NOM_CIUDAD, ";
	$sql .= "pa.ID_PAIS, pa.NOMBRE AS NOM_PAIS, ";
	$sql .= "user.* ";
	$sql .= "FROM SOLICITUD sol ";
	$sql .= "INNER JOIN LIBRO lib ON (sol.ID_LIBRO = lib.ID_LIBRO) "; 
	$sql .= "INNER JOIN USUARIO user ON (sol.ID_USUARIO = user.ID_USUARIO) ";
	$sql .= "LEFT JOIN AREA ar ON (lib.ID_AREA = ar.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL edi ON (lib.ID_EDITORIAL = edi.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD ciu ON (lib.ID_CIUDAD = ciu.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS pa ON (ciu.ID_PAIS = pa.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE sd ON (lib.ID_SEDE = sd.ID_SEDE) ";
	
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
	
	//Paginacion
	$sql .= "LIMIT ".$offSet.",".$limit;
	
	$result = $genericoCrud->selectGenerico($sql);
	return $result;	
	
 }


 //Funcion encargada de buscar una solicitud segun su id
 function buscarSolicitudPorIdNew($idSolicitud){
 		
 	$result = array();
	$genericoCrud = new DbCrud();
	
	$sql = "SELECT sol.ID_SOLICITUD, sol.FECHA_SOLICITUD, sol.FECHA_RESERVA, sol.FECHA_DEVOLUCION, "; 
	$sql .= "sol.FECHA_ENTREGA, sol.ID_USUARIO as ID_USUARIO_SOL, ";
	$sql .= "sol.ID_LIBRO as ID_LIBRO_SOL, sol.ESTADO as ESTADO_SOL, ";
	$sql .= "lib.*, lib.ESTADO as EST_LIBRO, ";
	$sql .= "lib.ID_USUARIO as ID_USUARIO_LIB, ";
	$sql .= "sd.DESCRIPCION as DES_SEDE, ";
	$sql .= "edi.DESCRIPCION AS DES_EDITORIAL, ";
	$sql .= "ar.DESCRIPCION AS DES_AREA, ";
	$sql .= "ciu.NOMBRE AS NOM_CIUDAD, ";
	$sql .= "pa.ID_PAIS, pa.NOMBRE AS NOM_PAIS, ";
	$sql .= "user.* ";
	$sql .= "FROM SOLICITUD sol ";
	$sql .= "INNER JOIN LIBRO lib ON (sol.ID_LIBRO = lib.ID_LIBRO) "; 
	$sql .= "INNER JOIN USUARIO user ON (sol.ID_USUARIO = user.ID_USUARIO) ";
	$sql .= "LEFT JOIN AREA ar ON (lib.ID_AREA = ar.ID_AREA) ";
	$sql .= "LEFT JOIN EDITORIAL edi ON (lib.ID_EDITORIAL = edi.ID_EDITORIAL) ";
	$sql .= "LEFT JOIN CIUDAD ciu ON (lib.ID_CIUDAD = ciu.ID_CIUDAD) ";
	$sql .= "LEFT JOIN PAIS pa ON (ciu.ID_PAIS = pa.ID_PAIS) ";
	$sql .= "LEFT JOIN SEDE sd ON (lib.ID_SEDE = sd.ID_SEDE) ";
	$sql .= "WHERE sol.ID_SOLICITUD = ".$idSolicitud;
	
	
	$result = $genericoCrud->selectGenerico($sql);
	return $result;	
	
 }



	//funcion encargada de buscar un libro segun su ID
	 function buscarLibroPorIdNew($idLibro){
	 	$result = array();
		$genericoCrud = new DbCrud();
		
		$sql = "SELECT LIB.*, LIB.ESTADO AS EST_LIBRO, ";
		$sql .= "AR.DESCRIPCION AS DES_AREA, ";
		$sql .= "EDI.DESCRIPCION AS DES_EDITORIAL, ";
		$sql .= "CIU.NOMBRE AS NOM_CIUDAD, ";
		$sql .= "PA.ID_PAIS, PA.NOMBRE AS NOM_PAIS, ";
		$sql .= "SD.DESCRIPCION AS DES_SEDE ";
		$sql .= "FROM LIBRO LIB ";
		$sql .= "LEFT JOIN AREA AR ON (LIB.ID_AREA = AR.ID_AREA) ";
		$sql .= "LEFT JOIN EDITORIAL EDI ON (LIB.ID_EDITORIAL = EDI.ID_EDITORIAL) ";
		$sql .= "LEFT JOIN CIUDAD CIU ON (LIB.ID_CIUDAD = CIU.ID_CIUDAD) ";
		$sql .= "LEFT JOIN PAIS PA ON (CIU.ID_PAIS = PA.ID_PAIS) ";
		$sql .= "LEFT JOIN SEDE SD ON (LIB.ID_SEDE = SD.ID_SEDE) ";
		$sql .= "WHERE LIB.ID_LIBRO = ".$idLibro;
		
		$result = $genericoCrud->selectGenerico($sql);
		return $result;		
	 }


	 //Funcion encargada de guardar un libro
	 function guardarLibroNew($idLibro, $titulo, $valor, $adquisicion, $estado, $isbn, $radicado,
	 	$fechaIngreso, $codTopografico, $serie, $idSede, $idEditorial, $idArea, $anio,
	 	$temas, $paginas, $disponibilidad, $idUsuario, $idCiudad, $cantidad, $idAutoresConcatenados){
		
		/**
		 * Se verifica el valor de $idLibro, en caso de ser diferente de 0 indica que es actualizacion, 
		 * de lo contrario se almacena un libro
		 */	
		if($idLibro != 0){
			return actualizarLibroNew($idLibro, $titulo, $valor, $adquisicion, $estado, $isbn, $radicado, 
			$fechaIngreso, $codTopografico, $serie, $idSede, $idEditorial, $idArea, $anio, $temas, $paginas, 
			$disponibilidad, $idUsuario, $idCiudad, $cantidad, $idAutoresConcatenados);
		}else{
		
	 	$genericoCrud = new DbCrud();

	 	$campos = "(";
	 	$valores = "(";
	 	
	 	$valores2 = ""; 

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

		//El codigo topografico se concatena en el armado de la sql
		$codTopograficoLibro = trim($codTopografico);
	 	if(!empty($codTopograficoLibro)){
			$campos .= ",COD_TOPOGRAFICO ";
			//$valores .= ",'".$codTopograficoLibro."'";
		}

		$serieLibro = trim($serie);
	 	if(!empty($serieLibro)){
			$campos .= ",SERIE ";
			$valores2 .= ",'".$serieLibro."'";
		}

		$idSedeLibro = trim($idSede);
	 	if(!empty($idSedeLibro)){
			$campos .= ",ID_SEDE ";
			$valores2 .= ",".$idSedeLibro;
		}

		$idEditorialLibro = trim($idEditorial);
	 	if(!empty($idEditorialLibro)){
			$campos .= ",ID_EDITORIAL ";
			$valores2 .= ",".$idEditorialLibro;
		}

		$idArealLibro = trim($idArea);
	 	if(!empty($idArealLibro)){
			$campos .= ",ID_AREA ";
			$valores2 .= ",".$idArealLibro;
		}

		$anioLibro = trim($anio);
	 	if(!empty($anioLibro)){
			$campos .= ",ANIO ";
			$valores2 .= ",".$anioLibro;
		}

		$temasLibro = trim($temas);
	 	if(!empty($temasLibro)){
			$campos .= ",TEMAS ";
			$valores2 .= ",'".$temasLibro."'";
		}

		$paginasLibro = trim($paginas);
	 	if(!empty($paginasLibro)){
			$campos .= ",PAGINAS ";
			$valores2 .= ",".$paginasLibro;
		}

		$disponibilidadLibro = trim($disponibilidad);
	 	if(!empty($disponibilidadLibro)){
			$campos .= ",DISPONIBILIDAD ";
			$valores2 .= ",'".$disponibilidadLibro."'";
		}

		$idUsuarioLibro = trim($idUsuario);
	 	if(!empty($idUsuarioLibro)){
			$campos .= ",ID_USUARIO ";
			$valores2 .= ",".$idUsuarioLibro;
		}

		$idCiudadLibro = trim($idCiudad);
	 	if(!empty($idCiudadLibro)){
			$campos .= ",ID_CIUDAD ";
			$valores2 .= ",".$idCiudadLibro;
		}
		
		//El valor cantidad siempre será de 1 ya que cada libro es unico
		//Valor independiente del campos "cantidad", el cual verifica el numero de libros a guardar
		$campos .= ",CANTIDAD ";
		$valores2 .= ",1";

	 	$campos .= ")";
	 	//$valores .= ")";

		$result = 0;
		
		//Se guardan los libros segun la cantidad indicada
		$cantidadLibro = trim($cantidad);
	 	if(!empty($cantidadLibro) && $cantidadLibro > 0){
			
			for($i = 0; $i<$cantidadLibro; $i++){
				
				$codTopogra = $codTopograficoLibro;
				//Se concatena el numero de ejemplar en el codigo topografico
				if($i>0){
					$ejemplar = $i+1;
					$codTopogra = $codTopograficoLibro."-EJ".$ejemplar;
				}
					
				$sql = "INSERT INTO LIBRO ".$campos." VALUES ".$valores.",'".$codTopogra."'".$valores2.")";
	 			$result = $genericoCrud->sqlGenerico($sql);
				asociarAutorLibro(0, $idAutoresConcatenados);
			}
			
		}
		
		return $result;
		
		}

	 }


	 //Funcion encargada de actualizar un libro
	 function actualizarLibroNew($idLibro, $titulo, $valor, $adquisicion, $estado, $isbn, $radicado,
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
		//$sql .= "CANTIDAD = ".$cantidad.", "; no se modifica
		
		
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


	 /**
	 * ////////////////////////////////////////////////
	 * ////////////////// REGISTRO DE FUNCIONES ///////
	 * ////////////////////////////////////////////////
	 */

//Se registra la funcion listadoLibrosNew
$server->register(
	// Method name:
	'listadoLibrosNew',
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
	'Metodo retorna listado de libros y datos relacionales ');
	
	
	
//Se registra la funcion cantidadLibros
$server->register(
	// Method name:
	'cantidadLibros',
	// parameter list:
	array('titulo'=>'xsd:string',
		'isbn'=>'xsd:string',
		'codTopografico'=>'xsd:string',
		'temas'=>'xsd:string',
		'editorial'=>'xsd:int',
		'autor'=>'xsd:int'),
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
	'Metodo retorna la cantidad de libros');
	
	
	
//Se registra la funcion listadoLibrosPagindosNew
$server->register(
	// Method name:
	'listadoLibrosPagindosNew',
	// parameter list:
	array('titulo'=>'xsd:string',
		'isbn'=>'xsd:string',
		'codTopografico'=>'xsd:string',
		'temas'=>'xsd:string',
		'editorial'=>'xsd:int',
		'autor'=>'xsd:int',
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
	'Metodo retorna listado de libros PAGINADOS y datos relacionales ');
	
	
	
//Se registra la funcion listadoReservas
$server->register(
	// Method name:
	'listadoReservasNew',
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
	
	
//Se registra la funcion cantidadReservas
$server->register(
	// Method name:
	'cantidadReservas',
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
	'Metodo retorna la cantidad de reservas ');
	
	
//Se registra la funcion listadoReservas
$server->register(
	// Method name:
	'listadoReservaPaginadas',
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
		'autor'=>'xsd:int',
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
	'Metodo retorna listadoReservas paginadas');
	
	
	///////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////
	//Se registra la funcion buscarLibroPorId
	$server->register(
		// Method name:
		'buscarLibroPorIdNew',
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
	//Se registra la funcion buscarSolicitudPorId
	$server->register(
		// Method name:
		'buscarSolicitudPorIdNew',
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
	//Se registra la funcion guardarLibro
	$server->register(
		// Method name:
		'guardarLibroNew',
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
		

	 
?>