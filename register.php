<?php
include_once("app.php");
App::print_head_login("Registro.");
echo"<br/> <h1 class=\"text-center\">Registro:</h1>";

?>
<br/>
<div class="container">
    <div class="row">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-12 col-md-4 offset-md-4">            
            <form method="POST" action="register.php">         
                <div class="from-group">
                    <label for="usuario">Usuario:</label>
                    <input id="usuario" name="usuario" type="text" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="passwordconfir">Confirmar Password:</label>
                    <input id="passwordconfir" name="passwordconfir" type="password" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="nombre">Nombre:</label>
                    <input id="nombre" name="nombre" type="text" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="fnac">Fecha de nacimiento:</label>
                    <input id="fnac" name="fnac" type="date" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="correo">Correo:</label>
                    <input id="correo" name="correo" type="text" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>  

                <br/>
                <div class="text-center">
                    <input type="submit" value="Registrar" class="btn btn-primary">
                </div>
                <hr/>
                <div class="text-center">
                    <a class="btn btn-primary" href="login.php">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
App::print_footer();

if($_SERVER["REQUEST_METHOD"]=="POST")
{  
    $nick=$_POST["usuario"];
    $password=$_POST["password"];
    $passwordconfir=$_POST["passwordconfir"];
    $nombre=$_POST["nombre"];
    $fnac=$_POST["fnac"];
    $email=$_POST["correo"];

   // echo "Datos : ".$nick." ".$password." ".$passwordconfir." ".$fnac." ".$email;
    if(empty($nick))
    echo"<p class=\"text-center\">El nombre de usuario esta vacio.</p>";
    else if(empty($password))
    echo"<p class=\"text-center\">No ha introducido una contraseña.</p>";
    else if($password != $passwordconfir)
    echo"<p class=\"text-center\">Las contraseña no coincide.</p>";
    else if(empty($nombre))
    echo"<p class=\"text-center\">No ha introducido un nombre.</p>";
    else if(empty($fnac))
    echo"<p class=\"text-center\">No ha indicado la fecha de nacimiento.</p>";
    else if(date($fnac)>=date("Y-m-d"))
    echo"<p class=\"text-center\">Las fecha de nacimiento no puede ser superior a la actual</p>";
    else if(empty($email))
    echo"<p class=\"text-center\">Necesita introducir un correo</p>";
    else if(!empty($password) && !empty($nick) && !empty($passwordconfir)&& !empty($nombre)&& !empty($fnac)&& !empty($email))//Si todo esta lleno
    {
        $app = new App();
        $yaexisteusuario = $app->getSelectUsuario($nick,$email);    
        if(!$yaexisteusuario)
            $app->Registrarse($nick,$password,$nombre,$fnac,$email);
        else
            echo"<br/><h5><p class=\"text-center\">El nombre de usuario '".$nick ."' o el correo: '".$email."' ya esta registrado.</p></h5>";
        
   
        
      
        //echo"<p class=\"text-center\">TODO LLENO</p>";
    }


}

?>