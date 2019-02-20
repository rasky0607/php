<?php
include ("dao.php");
class App{
private $dao;

function __construct()
{
  $this->dao=new Dao(); 
}



    //$title ="Página SEGEMP" es el valor por defecto indicado a este parametro si n o sele pasa nada
function print_head($title="Página SEGEMP"){
  //Cambiamos el enlace de <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>    
    echo "<!DOCTYPE html>
    <html lang=\"es\">  
      <head>    
        <title>$title</title>    
        <meta charset=\"UTF-8\">
        <meta name=\"title\" content=\"$title\">
        <meta name=\"description\" content=\"Descripción de la WEB\">    
        <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>  
        <link href=\"../css/aula.css\" rel=\"stylesheet\"/>
        <script src=\"../js/jquery-3.3.1.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.min.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.bundle.js\"></script>
        
      </head>  
      <body style=\"background-color:#66ffa6\">    
        <header>
       
       
        </header> ";
        /*  <header>       
            <h1 class=\"text-center\">$title</h1>
            </header>  */ 
    }

    function print_head_login($title="Página SEGEMP"){
      //Cambiamos el enlace de <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>    
        echo "<!DOCTYPE html>
        <html lang=\"es\">  
          <head>    
            <title>$title</title>    
            <meta charset=\"UTF-8\">
            <meta name=\"title\" content=\"$title\">
            <meta name=\"description\" content=\"Descripción de la WEB\">    
            <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>  
            <link href=\"../css/aula.css\" rel=\"stylesheet\"/>
            <script src=\"../js/jquery-3.3.1.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.min.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.bundle.js\"></script>
            
          </head>  
          <body style=\"background-color:#bbdefb\">       
            <header>         
            </header>
            <br/> ";
  
        }
       
    
         //Funcion que imprime el menú del sitio web
      function print_nav_listaulas($nickUsuario){ 
          echo"       
          <div class=\"p-1 mb-2 bg-success text-white\"/>
          <nav class=\"navbar navbar-expand-lg navbar-dark\">              
          <span class=\"navbar-brand mb-0 h1\"><u>Usuario: ".$nickUsuario."</u></span>
          <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
              <ul class=\"navbar-nav mr-auto\">
              <li class=\"nav-item dropdown\">
              <span class=\"nav-item active\"> <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\"
                   data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                  Gestión de Aulas
                  </a></sapn>
                  <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">   
                      <a class=\"dropdown-item\" href=\"listAulas.php\">Listar Aulas</a>                  
                      <a class=\"dropdown-item\" href=\"reservaAula.php\">Reservar aula</a>
                      <a class=\"dropdown-item\" href=\"buscarAula.php\">Buscar Aula</a>
                      <a class=\"dropdown-item\" href=\"BuscarResrUnAula.php\">Consultar reservas de un aula</a>
                      <a class=\"dropdown-item\" href=\"misReservas.php\">Consultar mis reservas</a>
                  </div> 
                  </li>                                 
                </li>
                <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"listaTodasReservas.php\">Listado de aulas reservadas <span class=\"sr-only\">(current)</span></a>
            </li>            
              </ul>
             <span class=\"navbar-brand mb-0 h1\"><a class=\"nav-link\" href=\"logout.php\">Cerrar sesión</a></span>
            </nav> 
            </div>";   
          }
    
        //Funcion que imprime el pié de página del sitio Web
      function print_footer(){
       echo "<footer>     
          <h4 class=\"text-center\">Pablo López</h4>
          <a href='http://dominio.com/aviso-legal'>Política de cookies</a> 
          <h4 class=\"text-center\">Reservas de aulas comunes.</h4>        
        </footer>";
        }   
      

        //Funcion que devuelve la unica conexion a la BD
      function getDao(){
          return $this->dao;
        }

      function validateSession(){
          session_start();
          if (!$this->isLogged())
              $this->showLogin();
      }

      function Registrarse($nick,$password,$nombre,$fnac,$email)
      {
        return $this->dao->InsertNuevoUsuario($nick,$password,$nombre,$fnac,$email);
      }
      function RegistrarseReserva($nickUsuario,$nombreCortoAula,$fReserva,$horaIniresr,$horaFinreser)
      {
        return $this->dao->InsertReserva($nickUsuario,$nombreCortoAula,$fReserva,$horaIniresr,$horaFinreser);
      }

      function getSelectUsuario($usuario,$email)
      {
        return $this->dao-> SelectUsuario($usuario,$email);       
      }
      function getAulas()
      {
        return $this->dao->SelectAulas();
      }

      function getBusquedaAula($nombreCorto)
      {
        return $this->dao->SelectAulaNombre($nombreCorto);
      }

      function getUsuarios()
      {
        return $this->dao->SelectUsuarios();
      }

      function getAulasReservas()
      {
        return $this->dao->SelectReservas();
      }

      function getReservasExistente($nombreCortoAula,$fReserva,$horaIniresr,$horaFinreser)
      {
        return $this->dao->SelectReservasExistente($nombreCortoAula,$fReserva,$horaIniresr,$horaFinreser);
      }

      function getMisReservas($nickUsuario)
      {
        return $this->dao->SelectMisReservas($nickUsuario);
      }

      function getAnularReserva($nickUsuario,$nombeCortoAula,$fReserva,$horaIniresr,$horaFinreser)
      {
        return $this->dao->DeleteReserva($nickUsuario,$nombeCortoAula,$fReserva,$horaIniresr,$horaFinreser);
      }

      function getBusquedaReservaAula($nombreCortoAula)
      {
        return $this->dao->SelectReservasUnAula($nombreCortoAula);
      }
          //Función que comprueba si existe el usuario
      function isLogged(){
          return isset ($_SESSION['usuario']);

      }
      //Función que redirige a a Login
      function showLogin(){
          //Petición a una cabecera.
          header ('Location: login.php'); //Solo se puede utilizar cuando no se ha escrito nada ni se ha mandado una petición al cliente.
      }
      
        function saveSession($usuario){
          $_SESSION['usuario']=$usuario;

        }   

        function invalidateSession(){
          session_start();
          if ($this->isLogged())
              unset($_SESSION['usuario']);
          session_destroy();
          $this->showLogin();
      }
     


   
    
}
?>