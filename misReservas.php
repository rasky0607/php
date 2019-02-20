<?php
include_once("app.php");
App::print_head("Mis de Reservas.");
$app = new App();
$app->validateSession(); //Esta función inicia sesión y comprueba si está logueado.
$nickUsuario;
foreach($_SESSION as $elemento){
    $nickUsuario=$elemento;
}
App::print_nav_listaulas($nickUsuario);
$resultset=$app->getMisReservas($nickUsuario);

//1. Error con la BD
if (!$resultset)
    echo "<p>Error al conectar al servidor: ".$app->getDao()->error."</p>";
//2. La sentencia es correcta
else
{
    $list=$resultset->fetchAll();
    //print_r($list);
    //2.1 Si no hay elementos
    if (count($list)==0)
        echo" <p class=\"text-center\"><h3>No realizaste ninguna reserva.</h3> </p>";
    //2.2 Hay aulas
    else
    {
        echo "<table border=\"1\" class=\"table table-striped table-dark table-bordered\>";
        echo "<tr <div class=\"p-3 mb-2 bg-success text-white\">";
        for ($i=0; $i < $resultset->columnCount(); $i++)
        {
            $nameColumn=$resultset->getColumnMeta($i);
            echo "<th>".strtoupper($nameColumn['name'])."</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($list as $fila) {
            echo "<tr>";
            echo "<td scope=\"row\">".$fila['nickUsuario']."</td>".
            "<td scope=\"row\"> <a href='reservaAula.php?nombreCortoAula=".$fila['nombreCortoAula']."'/>".$fila['nombreCortoAula']."</td>".
            "<td scope=\"row\">".$fila['fReserva']."</td>".
            "<td scope=\"row\">".$fila['horaIniresr']."</td>".
            "<td scope=\"row\">".$fila['horaFinreser']."</td>".
            "<td scope=\"row\"> <a class=\"btn btn-primary\" href='AnularReservaAula.php?nombreCortoAula=".$fila['nombreCortoAula']."&fReserva=".$fila['fReserva']."&horaIniresr=".$fila['horaIniresr']."&horaFinreser=".$fila['horaFinreser']."&nickUsuario=".$nickUsuario."'/>ANULAR RESERVA</td>";//Anulacion de reserva
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }


}

App::print_footer()
//<input type="submit" value="Registrar" class="btn btn-primary">
//"<td scope=\"row\"> <a href='AnularReservaAula.php'/>ANULAR RESERVA</td>"
?>