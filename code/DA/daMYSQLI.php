<?php

  /********************************************************************************
   * Clase maestra de conexiones y funciones de ejecucion.
   *
   * @author LYNX
   * @version 1.0
   * @fecha 18/10/2017
   ********************************************************************************/

class ClsBd{

  private $_dbhost = "35.237.183.247";
  private $_dbuser = "root";
  private $_dbpass = "20603228325";
  private $_dbname = "lynxmobile";
  private $_conn = null;
  private $_codigoInsertado = null;

  public static $_instance = null; //The single instance

  //En el constructor de la clase establecemos los parámetros de conexión con la base de datos

  public function __construct()
  {
    if ($this->_conn===null){
      $this->_conn =new mysqli($this->_dbhost, $this->_dbuser, $this->_dbpass,$this->_dbname);
      if ($this->_conn->connect_errno) {
        die('Error al conectar con mysql '.$this->_dbname." ".$this->_conn->connect_errno);
        exit;
      }else{
        //mysqli_set_charset($conn,"utf8");
        return $this->_conn;
      }      
    }
  }

  public function __destruct()
  {
    //code
  }

/*Evitamos el clonaje del objeto. Patrón Singleton*/
  private function __clone()
  {
    //code
  }

/*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
  public static function getInstance(){
    if (self::$_instance === null) {
        self::$_instance = new self();
    }
    return self::$_instance;    
  }

  //El método abrir establece una conexión con la base de datos
  public function fcConectar(){
    /*$this->_conn = mysqli_connect($this->_dbhost, $this->_dbuser, $this->_dbpass,$this->_dbname);
    if (mysqli_connect_errno()) {
      die('Error al conectar con mysql');
      exit;
    }else{
      //mysqli_set_charset($conn,"utf8");
      return $this->_conn;
    }*/
    return $this->_conn;
  }

//La función sql nos permite ejecutar una senetencia sql en la base de datos, se suele utilizar para un procedimiento Insert y Update

  public function fcEjecutarUI($sql, $conn, 
                                $arrayParametros = array(),
                                $arrayTipoParametros = array())
  {
    $this->_codigoInsertado = 0;
    $_ejecutar = null;
    try{
      $_ejecutar  = $conn->prepare($sql);
      $tipos      = "";
      if (sizeof($arrayParametros)>0){
        
        for ($i=0; $i<sizeof($arrayParametros);$i++)
        {
          //$tipos.=(sizeof($arrayTipoParametros)>0)?"",$arrayTipoParametros[$i]:"s";
        }
        
        $referencias = array_merge( array($tipos), $arrayParametros);

        call_user_func_array(array($_ejecutar, 'bind_param'), $this->refValues($referencias) );
      }

      $_ejecutar->execute();
      $this->_codigoInsertado = $_ejecutar->insert_id;
      return $_ejecutar->affected_rows;

    }catch(Exception $e){
      echo "<br>" . $e->getMessage();
      echo "<br>" . $e->getCode();
      echo "<br>" . $e->getFile();
      echo "<br>" . $e->getLine();
      echo "<br>" . $e->getTrace();
      echo "<br>" . $e->getTraceAsString();
    }
  }


//La función sql nos permite ejecutar una senetencia sql en la base de datos, se suele utilizar para una consulta desde un procedimiento

  public function fcEjecutarSql($sql, $conn, 
                                $arrayParametros = array(),
                                $arrayTipoParametros = array())
  {
    $_ejecutar = null;
    $_resultado;
    try{
      $_ejecutar  = $conn->prepare($sql);
      $tipos      = "";
      if (sizeof($arrayParametros)>0){
        
        for ($i=0; $i<sizeof($arrayParametros);$i++)
        {
          //$tipos.=(sizeof($arrayTipoParametros)>0)?"",$arrayTipoParametros[$i]:"s";
        }
        
        $referencias = array_merge( array($tipos), $arrayParametros);

        call_user_func_array(array($_ejecutar, 'bind_param'), $this->refValues($referencias) );
      }

      $_ejecutar->execute();
      $_resultado->get_result();
      return $_resultado;

    }catch(Exception $e){
      echo "<br>" . $e->getMessage();
      echo "<br>" . $e->getCode();
      echo "<br>" . $e->getFile();
      echo "<br>" . $e->getLine();
      echo "<br>" . $e->getTrace();
      echo "<br>" . $e->getTraceAsString();
    }
  }

  public function fcExtraeFilaAsociada($_tabla){
    if ($_tabla!=null){
      return $_tabla->fetch_array(MYSQLI_ASSOC);
    }
  }
  
  public function fcEjecutarCRUD( $_sqlCall, $_cn){
    $res = $_cn->query($_sqlCall) or trigger_error($_cn->error."[$_sqlCall]");
    return $res;
  }
  public function fcEjecutarSP( $_sqlCall, $_cn, $_const){
    //$res = null;
    $res = $_cn->query($_sqlCall, $_const) or trigger_error($_cn->error."[$_sqlCall]");
    return $res;
  }
  
  public function fcEjecutaObtieneFila( $_sqlCall, $_cn)
  {   
      $res = $_cn->query($_sqlCall)->fetch_assoc()  or trigger_error($_cn->error."[$_sqlCall]");
      return $res;
  }
  
  public function fcEjecutarSP2( $_sqlCall, $_cn){
    $res = $_cn->multi_query($_sqlCall) or trigger_error($_cn->error."[$_sqlCall]");
    return $res;

  }

//La función "cerrar" finaliza la conexión con la base de datos.

  public function fcCerrar($conn){
    mysqli_close($conn);
  }

//La función 'escape' escapa los caracteres especiales de una cadena para usarla en una sentencia SQL

  public function fcEscape($value){
    return mysqli_real_escape_string($this->_conn,$value);
  }

  function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
      $refs = array();
      foreach($arr as $key => $value)
          $refs[$key] = &$arr[$key];
      return $refs;
    }
    return $arr;
  }

}

?>