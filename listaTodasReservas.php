<?php
include_once("app.php");
App::print_head("Listado de Reservas.");
$app = new App();
$app->validateSession(); //Esta función inicia sesión y comprueba si está logueado.
$nickUsuario;
foreach($_SESSION as $elemento){
    $nickUsuario=$elemento;
}
App::print_nav_listaulas($nickUsuario);
$resultset=$app->getAulasReservas();

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
        echo "<p class=\"text-center\"><h3>No hay aulas reservadas.<h3></p>";
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
            "<td scope=\"row\">".$fila['horaFinreser']."</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }
}

App::print_footer()

?>