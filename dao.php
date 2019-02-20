<?php

//Clase que va gestionar la conexion a la base dedatos
define("DATABASE","reserva_aula");
define("DSN","mysql:host=localhost;dbname=".DATABASE);
define("USER","root");//usuario de mysql
define("PASSWORD","123");
//Definimos las tablas con sus columnas
define("TABLA_USUARIO","usuario");
define("USUARIO_COLUMN_NICK","nick");
define("USUARIO_COLUMN_CONTRASENIA","contrasenia");
define("USUARIO_COLUMN_NOMBRE","nombre");
define("USUARIO_COLUMN_FNAC","fnac");
define("USUARIO_COLUMN_EMAIL","email");

define ("TABLA_AULA", "aula");
define ("AULA_COLUMN_NOMBRE_AULA", "nombreCorto");
define ("AULA_COLUMN_DESCRIPCION", "nombreDescripcion");
define ("AULA_COLUMN_UBICACION", "ubicacion");
define ("AULA_COLUMN_TIC", "tic");//Pertenece o no el aula al tipo de aula de tecnologia o las TIC
define ("AULA_COLUMN_NORDENADORES", "nOrdenadores");


define ("TABLA_RESERVA", "reserva");
define ("RESERVA_COLUMN_NICK_USUARIO", "nickUsuario");
define ("RESERVA_COLUMN_NOMBRE_AULA", "nombreCortoAula");
define ("RESERVA_COLUMN_FECHA","fReserva");
define ("RESERVA_COLUMN_HORAINIRESER","horaIniresr");
define ("RESERVA_COLUMN_HORAFINRESER","horaFinreser");


class Dao{
    private $conecxion;
    public $error;
    function __construct()
    {
        try
        {
           $this->conecxion=new PDO(DSN,USER,PASSWORD);//devuelve un objet conexcion
        }
        catch(PDOEXception $e)
        {
            $this->error="Error en la conecxion: ".$e->getMessage();//deveulve el error
        }
    }

    //Metodo que comprueba si hay una conexion con la BD
    function Conectado()
    {
        return isset($this->conecxion);
    }

    //Funcion que compruebasi existe el usuario en la tabla Usuario

    function validarUsuario($usuario,$password){
        //$sql="SELECT * FROM ".TABLE_USER." WHERE ".COLUMN_USER_NAME."='".$user."' AND ".COLUMN_USER_PASSWORD." =sha1('".$password."')";
    try{
        $sql="SELECT * FROM ".TABLA_USUARIO." WHERE ".USUARIO_COLUMN_NICK."='".$usuario."' AND ".USUARIO_COLUMN_CONTRASENIA." ='".$password."'";
        //echo $sql;     
        $resultset=$this->conecxion->query($sql);
        if($resultset->rowCount()==1)      
            return true;
        else
        return false;
        }
        catch(PDOException $e){
        $this->error=$e->getMessage();
        }

    }

    //Revisa si ya existe ese usuario o el correo a la hora de crear uno nuevo
    function SelectUsuario($usuario,$email){
        //$sql="SELECT * FROM ".TABLE_USER." WHERE ".COLUMN_USER_NAME."='".$user."' AND ".COLUMN_USER_PASSWORD." =sha1('".$password."')";
    try{
        $sql="SELECT * FROM ".TABLA_USUARIO." WHERE ".USUARIO_COLUMN_NICK."='".$usuario."' OR ".USUARIO_COLUMN_EMAIL."='".$email."'";
        //echo $sql;     
        $resultset=$this->conecxion->query($sql);      
        if($resultset->rowCount()>=1)      
            return true;
        else
        return false;
        }
        catch(PDOException $e){
        $this->error=$e->getMessage();
        }

    }

//Da de alta nuevo usuario
    function InsertNuevoUsuario($nick,$password,$nombre,$fnac,$email)
    {
        try{
        $sql="INSERT INTO ".TABLA_USUARIO." (".USUARIO_COLUMN_NICK.", ".USUARIO_COLUMN_CONTRASENIA.", ".USUARIO_COLUMN_NOMBRE.", ".USUARIO_COLUMN_FNAC.", ".USUARIO_COLUMN_EMAIL.") VALUES ('".$nick."','".$password."','".$nombre."','".$fnac."','".$email."')";
        //echo $sql;     
        $resultset=$this->conecxion->prepare($sql);
        if($resultset->execute())
        {     
            echo"<h3><p class=\"text-center\">Creación de usuario exitosa</p></h3>";
        }

        }catch(PDOException $e)
        {
            echo"<h3><p class=\"text-center\">Creación de usuario fallida</p></h3> ".$e;
        }
        
    }
//Muestra todas las aulas
    function SelectAulas()
    {
        try{
        $sql="SELECT ".AULA_COLUMN_NOMBRE_AULA.", ".AULA_COLUMN_DESCRIPCION.", ".AULA_COLUMN_UBICACION.", ".AULA_COLUMN_TIC.", ".AULA_COLUMN_NORDENADORES." FROM ".TABLA_AULA;
        //echo $sql;           
        $resultset = $this->conecxion->query($sql);
        return $resultset;       
        }
        catch(PDOException $e){
        $this->error=$e->getMessage();
        }

    }

    //Buscar aulas por su nombre
    function SelectAulaNombre($nombreCorto)
    {
        try{
        $sql="SELECT ".AULA_COLUMN_NOMBRE_AULA.", ".AULA_COLUMN_DESCRIPCION.", ".AULA_COLUMN_UBICACION.", ".AULA_COLUMN_TIC.", ".AULA_COLUMN_NORDENADORES." FROM ".TABLA_AULA." WHERE ".AULA_COLUMN_NOMBRE_AULA."='".$nombreCorto."'";
        //echo $sql;           
        $resultset = $this->conecxion->query($sql);
        return $resultset;       
        }
        catch(PDOException $e){
        $this->error=$e->getMessage();
        }

    }

    //Muestra todas las reservas
    function SelectReservas()
    {
        try{
            $sql="SELECT ".RESERVA_COLUMN_NICK_USUARIO.", ".RESERVA_COLUMN_NOMBRE_AULA.", ".RESERVA_COLUMN_FECHA.", ".RESERVA_COLUMN_HORAINIRESER.", ".RESERVA_COLUMN_HORAFINRESER." FROM ".TABLA_RESERVA;
            //echo $sql;           
            $resultset = $this->conecxion->query($sql);
            return $resultset;       
            }
            catch(PDOException $e){
            $this->error=$e->getMessage();
            }
    }

  

//Comprueba que no haya reservas para esa aula en esas horas
    function SelectReservasExistente($nombreCortoAula,$fReserva,$horaIniresr,$horaFinreser)
    {
        try{
            $sql="SELECT ".RESERVA_COLUMN_NICK_USUARIO.", ".RESERVA_COLUMN_NOMBRE_AULA.", ".RESERVA_COLUMN_FECHA.", ".RESERVA_COLUMN_HORAINIRESER.", ".RESERVA_COLUMN_HORAFINRESER." FROM ".TABLA_RESERVA." WHERE ".RESERVA_COLUMN_NOMBRE_AULA."='".$nombreCortoAula."' AND ".RESERVA_COLUMN_FECHA."='".$fReserva."' AND ".RESERVA_COLUMN_HORAINIRESER."='".$horaIniresr."' AND ".RESERVA_COLUMN_HORAFINRESER."='".$horaFinreser."'";
            //echo $sql;           
            $resultset = $this->conecxion->query($sql);          
            if($resultset->rowCount()>=1)      
                return true;
            else
                return false;             
            }
            catch(PDOException $e){
            $this->error=$e->getMessage();
            }
    }

      

    function InsertReserva($nickUsuario,$nombreCortoAula,$fReserva,$horaIniresr,$horaFinreser)
    {
        try{
            $sql="INSERT INTO ".TABLA_RESERVA." (".RESERVA_COLUMN_NICK_USUARIO.", ".RESERVA_COLUMN_NOMBRE_AULA.", ".RESERVA_COLUMN_FECHA.", ".RESERVA_COLUMN_HORAINIRESER.", ".RESERVA_COLUMN_HORAFINRESER.") VALUES ('".$nickUsuario."', '".$nombreCortoAula."', '".$fReserva."', '".$horaIniresr."', '".$horaFinreser."')" ;
             //echo $sql;           
            $resultset=$this->conecxion->prepare($sql);
            if($resultset->execute())
            {     
                echo" <h3><p class=\"text-center\">Reserva realizada exitosamente.</p></h3>";
            }
    
            }catch(PDOException $e)
            {
                echo"<h3><p class=\"text-center\">Reserva fallida.<p></h3>".$e;
            }
    }

    function SelectMisReservas($nickUsuario)
    {
        try{
            $sql="SELECT ".RESERVA_COLUMN_NICK_USUARIO.", ".RESERVA_COLUMN_NOMBRE_AULA.", ".RESERVA_COLUMN_FECHA.", ".RESERVA_COLUMN_HORAINIRESER.", ".RESERVA_COLUMN_HORAFINRESER." FROM ".TABLA_RESERVA." WHERE ".RESERVA_COLUMN_NICK_USUARIO."='".$nickUsuario."'";
            //echo $sql;           
            $resultset = $this->conecxion->query($sql);                           
            
            return $resultset;
        }
            catch(PDOException $e){
            $this->error=$e->getMessage();
            }
    }

    function SelectReservasUnAula($nombreCortoAula)
    {
        try{
            $sql="SELECT ".RESERVA_COLUMN_NICK_USUARIO.", ".RESERVA_COLUMN_NOMBRE_AULA.", ".RESERVA_COLUMN_FECHA.", ".RESERVA_COLUMN_HORAINIRESER.", ".RESERVA_COLUMN_HORAFINRESER." FROM ".TABLA_RESERVA." WHERE ".RESERVA_COLUMN_NOMBRE_AULA."='".$nombreCortoAula."'";
            //echo $sql;           
            $resultset = $this->conecxion->query($sql);                           
            
            return $resultset;
        }
            catch(PDOException $e){
            $this->error=$e->getMessage();
            }
    }
    function DeleteReserva($nickUsuario,$nombeCortoAula,$fReserva,$horaIniresr,$horaFinreser)
    {  
        try{
          
            $sql="DELETE FROM ".TABLA_RESERVA." WHERE ".RESERVA_COLUMN_NICK_USUARIO."='".$nickUsuario."' AND ".RESERVA_COLUMN_NOMBRE_AULA."='".$nombeCortoAula."' AND ".RESERVA_COLUMN_FECHA."='".$fReserva."' AND ".RESERVA_COLUMN_HORAINIRESER."='".$horaIniresr."' AND ".RESERVA_COLUMN_HORAFINRESER."='".$horaFinreser."'";
             echo $sql;           
            $resultset=$this->conecxion->prepare($sql);
            if($resultset->execute())
            {     
                echo" <h3><p class=\"text-center\">Reserva eliminada exitosamente.</p></h3>";
            }
    
            }catch(PDOException $e)
            {
                echo"<h3><p class=\"text-center\">Eliminación de reserva fallida.<p></h3>".$e;
            }
        
        
    }

}
?>