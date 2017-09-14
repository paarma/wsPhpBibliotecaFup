<?php

/**
 * Clase generia para manera el CRUD en la bd
 */
 
 require_once "DbPdo.php";
 
 Class DbCrud {
   
   //Conexion db PDO
   protected function _getDbh(){
     return DbPdo::getInstance()->getConn();
   }
   
  //Funcion encargada de realizar la insercion en la bd
     /* $sql = "INSERT INTO tabla (campo1, campo2, campo3) 
      *         VALUES (?, ?, ?)"
      *  $stm->prepare($sql);
      *  $stm->bindValue(1, valor1);
      *  $stm->bindValue(2, valor2);
      *  $stm->bindValue(3, valor3);
      *  $stm->execute();
      */ 
   public function save($table, $data){
    
    $result = null;
    $iterator = new ArrayIterator($data);
    
    $sql = "INSERT INTO $table (";
    
    //Mientras es valor del iterador es valido
    while($iterator->valid()){
      $sql .= $iterator->key().",";
      $iterator->next();
    }
    
    //Se elimina la ultima coma sobrante
    /**
     * $sql   = La cadena de caracteres a tratar
     * 0      = El indice de arranque para borrar caracteres 
     * -1     = El numer de caracteres a eliminar (de derecha a izqauierda)
     */
    $sql = substr($sql, 0, -1);
    
    $sql .= ") VALUES (";
    for ($i=0; $i < $iterator->count(); $i++) { 
          $sql .= " ?,";
    }
    
    $sql = substr($sql, 0, -1);
    $sql .= ")";
    
    //Sentencia preparada de sql
    $stm = $this->_getDbh()->prepare($sql);
    
    //Se setean los parametros de la sql
    $i=1;
    foreach($iterator as $param){
      $stm->bindValue($i, $param);
      $i++;
    }    
    $result = $stm->execute();
    return $result;
     
   }

  //Funcion encargada de realizar el update en la bd
  /**
    * Update = $sql = "UPDATE tabla SET campo1 = ?, campo2 = ?, campo3 = ?
    * WHERE idcampo = ?"
    * $stm->bindValue(4, idValor);  
   */
   public function update($table,$data,$where,$id){
     
    $result = null;
    $iterator = new ArrayIterator($data);
     
    $sql = "UPDATE $table SET ";
    
    while ($iterator->valid()) {
        $sql .= $iterator->key() . " = ?, ";
        $iterator->next();
    } 
    //Se elimina los dos ultimos caracteres (la coma y el espacio)
    $sql  = substr($sql, 0, -2); 
    $sql .= " WHERE $where = ?";
    
    $stm = $this->_getDbh()->prepare($sql);    
    $i = 1; 
    
    foreach ($iterator as $param) {
       $stm->bindValue($i, $param);
       $i++;
    }
    
    /**
     * Se asigna el bindValue para el parametro $id, como no esta contemplado en los ciclos del $data,
     * se asigna en la posicion ($iterator->count()+1) y se le asigna el tipo de dato: PDO::PARAM_INT 
     */
    $stm->bindValue($iterator->count() + 1, $id, PDO::PARAM_INT); 
    
    $result = $stm->execute();    
    return $result; 
   }
   
   /**
    * Funcion encargada de eliminar los registros de una determinada tabla, campo y un determinado id.
    */
    public function delete($tabla, $campo, $id){
   	
		$sql = "DELETE FROM ".$tabla." WHERE ".$campo. " = ".$id;
		$stm = $this->_getDbh()->prepare($sql);
   		$result = $stm->execute();
        return $result;
   }
   
   //Funcion generica
   public function sqlGenerico($sql){
      $stm = $this->_getDbh()->prepare($sql);
      $result = $stm->execute();
      return $result;
   }
   
   /**
    * Funcion encargada de retornar un listado de datos dependiendo de una sql generica
    */
    public function selectGenerico($sql){
       	
       $stm = $this->_getDbh()->prepare($sql);
       $stm->execute();
       //return $stm->fetchAll(PDO::FETCH_OBJ); //Array asociativo de objetos
       return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
   
   /**
    * Funcion encargada de retornar un listado de datos dependiendo de la estructura de una sql
    * parametrizada
    */
    public function selectEstructurado($table, $datas, $order, $where) {

    $found = new ArrayObject();

    if ($datas == null) {

        $sql = "SELECT * from `$table`";
    } else {
        $sql = "SELECT";

        foreach ($datas as $value) {

            $sql .= " $value,";
        }

        $sql = substr($sql, 0, -1); // Elimina la ultima coma

        if ($where == null && $order != null) {
            $sql .= " from `$table` ORDER BY $order";
        } elseif ($where != null && $order == null) {

            $sql .= " from `$table` WHERE $where ";
        } elseif ($where != null && $order != null) {
            $sql .= " from `$table`     
                      WHERE $where ORDER BY $order";
        }

        //echo $sql;
    }

    /* Recorremos y almacenamos los datos en un arrayObjetc */
    $stm = $this->_getDbh()->query($sql);

    while ($rows = $stm->fetch(PDO::FETCH_ASSOC)) {

        $found->append($rows);
    }

    return $found;
    }
   
   /**
    * Funcion encargada de retornar un determinado registro verificando de esta manera si dato
    * ya se encuentra en la BD o no (verificar valores repetidos)
    */
    public function verificarValorEnBD($tabla,$campo,$valor){
      $sql = "SELECT * FROM $tabla WHERE $campo = ?";
      $stm = $this->_getDbh()->prepare($sql);
      $stm->bindValue(1, $valor);
      $stm->execute();

      if($rows = $stm->fetch(PDO::FETCH_ASSOC)){  
          return true;
      }else{
        return false;
      }
    }
   
 }

?>