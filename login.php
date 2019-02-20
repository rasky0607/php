<?php
include_once("app.php");
//Para iniciar una sesion
session_start();
//llamada a metodos para pintar la cabecera plantilla de la pagina
App::print_head_login("Inicio de sesión");
echo" <h1 class=\"text-center\">Inicio de sesión</h1>";
?>
<!--Crear el formulario LOGIN con Bootstrap-->
<div class="container">
    <div class="row">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-12 col-md-4 offset-md-4">            
            <form method="POST" action="login.php">
            <div class="col-4 col-md-0 offset-md-4">
                <br/> 
                <img src="../img/login.png" width="100" height="100"/>
            </div>    
                <div class="from-group">
                    <label for="user">Usuario:</label>
                    <input id="user" name="user" type="text" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <br/>
                <div class="text-center">
                    <input type="submit" value="Inicio de sesión" class="btn btn-primary">
                </div>
                <hr/>
                <div class="text-center">
                    <a class="btn btn-primary" href="register.php">Registrarse</a>                   

                </div>
            </form>
        </div>
    </div>
</div>
<br/>


<?php

//Comprobacion de que no este vacio (Instalamos phpMyadmin y mariadb u otro motor de BD)
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $usuario=$_POST["user"];//Cogemos el name del componente del formulario
    $password=$_POST["password"];
    if(empty($usuario))

    {
        echo "<p class=\"text-center\">Debes introducir el nombre de usuario</p>";
    }
    else if(empty($password))
    {
        echo "<p class=\"text-center\">Debes introducir una contraseña</p>";       
    }
    else{

        //Se realiza conecxion a la Base de datos y comprobar si el usuario existe
            $app = new App();

            if(!$app->getDao()-> Conectado()) //Iniciar sesion
            {
                //Mostrar el error
                echo "<p>".$app-> getDao()->$error."</p>";

            }elseif($app->getDao()->validarUsuario($usuario,$password)){
               
                //echo "<p> Usuario correcto.La conexion es correcta. </p>";
                //Se guarda la sesion
                
                $app->saveSession($usuario);//Se guarda la sesion de ese usuario
               

                 //Se redirecciona
                 echo "<script languaje=\"javascript\">window.location.href=\"listAulas.php\"</script>"; //Nuevo añadido
            }else
            {
                echo "<p  class=\"text-center\"> Usuario incorrecto. </p>";
            }

    }
}

//llamada a metodos para pintar la pie de pajina plantilla de la pagina
App::print_footer();
?>