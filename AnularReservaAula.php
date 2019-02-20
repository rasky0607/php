<?php
include_once("app.php");
App::print_head("Eliminación de reserva.");
echo"<br/> <h1 class=\"text-center\">Eliminación de reserva de aula:</h1>";
$app = new App();
$nickUsuario=$_GET['nickUsuario'];
$nombeCortoAula = $_GET['nombreCortoAula'];
$fReserva =$_GET['fReserva'];
$horaIniresr=$_GET['horaIniresr'];
$horaFinreser=$_GET['horaFinreser'];



//Eliminar reserva
if(!empty($nickUsuario)&&!empty($nombeCortoAula)&&!empty($fReserva)&&!empty($horaIniresr)&&!empty($horaFinreser))
{   
        if($fReserva>=date("Y-m-d"))
        {
            $app->getAnularReserva($nickUsuario,$nombeCortoAula,$fReserva,$horaIniresr,$horaFinreser);
            echo "<script languaje=\"javascript\">window.location.href=\"misReservas.php\"</script>"; 
        }
        else
        {
         
            echo "<table border=\"1\" class=\"table table-striped table-dark table-bordered\>
                    <tr <div class=\"p-3 mb-2 bg-success text-white\">
                    <th>NICKUSUARIO</th>
                    <th>NOMBRECORTOAULA</th>
                    <th>FRESERVA</th>
                    <th>HORAINIRESR</th>
                    <th>HORAFINRESER</th>
                    </tr>
                    <tr>
                    <td scope=\"row\">".$nickUsuario."</td>
                    <td scope=\"row\">".$nombeCortoAula."</td>
                    <td scope=\"row\">".$fReserva."</td>
                    <td scope=\"row\">".$horaIniresr."</td>
                    <td scope=\"row\">".$horaFinreser."</td>
                    </tr>
                </table>";
            echo"<br/><h3><p class=\"text-center\">No se puede eliminar una reserva con una fecha ya pasada.<p></h3>
            <hr/>
            <div class=\"text-center\">
                    <a class=\"btn btn-primary\" href=\"misReservas.php\">Volver</a>
                </div>
            ";
            
        }
}    
  
App::print_footer();
?>