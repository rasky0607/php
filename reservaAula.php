<?php
include_once("app.php");
App::print_head("Reserva Aula");
$app=new App();
$app->validateSession();
$nickUsuario;
foreach($_SESSION as $elemento){
    $nickUsuario=$elemento;
}
App::print_nav_listaulas($nickUsuario);
echo"<br/> <h1 class=\"text-center\">Reserva Aula:</h1>";
$listAulas = $app->getAulas();
$listAulas=$listAulas->fetchAll();

//var_dump($nik);

?>
<br/>
<div class="container">
    <div class="row">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-12 col-md-4 offset-md-4">            
            <form method="POST" action="reservaAula.php">                       
                <div class="from-group">
                    <label for="nombreAula">Nombre Aula:</label>                    
                    <select class="form-control" name="nombreCorto" id="nombreCorto" autofocus="autofocus">
                    <?php
                    foreach ($listAulas as $item) {
                    echo "<option value=".$item['nombreCorto'].">".$item['nombreCorto']."</option>";
                    }
                    ?>
                </select>
                </div>
                <div class="from-group">
                    <label for="freserva">Fecha reserva:</label>
                    <input id="freserva" name="freserva" type="date" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="horaIniresr">Hora inicio de reserva:</label>
                    <select class="form-control" name="horaIniresr" id="horaIniresr" autofocus="autofocus">                  
                    <option value="8:15">8:15</option>
                    <option value="9:15">9:15</option>
                    <option value="10:15">10:15</option>
                    <option value="11:15">11:15</option>
                    <option value="11:45">11:45</option>
                    <option value="12:45">12:45</option>
                    <option value="13:45">13:45</option>
                    <option value="14:45">14:45</option>
                 </select>
                </div>
                <div class="from-group">
                    <label for="horaFinreser">Hora fin de reserva:</label>                  
                    <select class="form-control" name="horaFinreser" id="horaFinreser" autofocus="autofocus">               
                    <option value="8:15">8:15</option>
                    <option value="9:15">9:15</option>
                    <option value="10:15">10:15</option>
                    <option value="11:15">11:15</option>
                    <option value="11:45">11:45</option>
                    <option value="12:45">12:45</option>
                    <option value="13:45">13:45</option>
                    <option value="14:45">14:45</option>
                    </select>
                </div>  
                <br/>
                <div class="text-center">
                    <input type="submit" value="Reservar" class="btn btn-primary">
                </div>
                <hr/>                
            </form>
        </div>
    </div>
</div>
<?php
App::print_footer();

if($_SERVER["REQUEST_METHOD"]=="POST")
{  
    
    $nickUsuario;
    foreach($_SESSION as $elemento){
        $nickUsuario=$elemento;
    }

    $nombreCortoAula=$_POST["nombreCorto"];
    $fechaReserva = $_POST["freserva"];
    $horaIniResr=$_POST["horaIniresr"];
    $horaFinreser=$_POST["horaFinreser"];

    $yaExiste=$app->getReservasExistente($nombreCortoAula,$fechaReserva,$horaIniResr,$horaFinreser);
    //var_dump($yaExiste);
    if(date($fechaReserva)<date("Y-m-d"))
        echo"<p class=\"text-center\">Las fecha de reserva no puede ser inferior a la actual</p>";
    else if(!ComparacionHoras($horaIniResr,$horaFinreser))
        echo"<p class=\"text-center\">La hora de inicio de la reserva no puede ser superior o igual a la de fin de la reserva<p/>";    
    else if($yaExiste == true)
    {
        echo "<h4><p class=\"text-center\">Ya existe una reserva para esa aula en esa fecha y esas horas.
        </p></h4>
        <p class=\"text-center\">Datos:</p><p class=\"text-center\">-Nombre Aula: ".$nombreCortoAula."</p>
        <p class=\"text-center\">-Fecha: ".$fechaReserva."</p>
        <p class=\"text-center\">-Hora Inicio Reserva: ".$horaIniResr."</p>
        <p class=\"text-center\">-Hora Fin Reserva: ".$horaFinreser."</p>";
        
    }
    else
        $app->RegistrarseReserva($nickUsuario,$nombreCortoAula,$fechaReserva,$horaIniResr,$horaFinreser);
   
}

function ComparacionHoras($horaInicio,$horafin)
{
    if($horaInicio=="8:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="9:15"&&$horafin!="9:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="10:15"&&$horafin!="10:15"&&$horafin!="9:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="11:15"&&$horafin!="11:15"&&$horafin!="10:15"&&$horafin!="9:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="11:45"&&$horafin!="11:45"&&$horafin!="11:15"&&$horafin!="10:15"&&$horafin!="9:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="12:45"&&$horafin!="12:45"&&$horafin!="11:45"&&$horafin!="11:15"&&$horafin!="10:15"&&$horafin!="9:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="13:45"&&$horafin!="13:45"&&$horafin!="12:45"&&$horafin!="11:45"&&$horafin!="11:15"&&$horafin!="10:15"&&$horafin!="9:15"&&$horafin!="8:15")
    return true;
    if($horaInicio=="14:45")
    return false;


    return false;
}
//echo"Datos: ".$nick." ".$nombreCortoAula." ".$fechaReserva." ".$horaIniResr." ".$horaFinreser;
 /**
     * 

     * Consultar mis reservas cone l usuario que inicio sesion
     */
?>