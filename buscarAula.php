<?php
include_once("app.php");
App::print_head("Buscar Aula:");
$app = new App();
$app->validateSession();
$nickUsuario;
foreach($_SESSION as $elemento){
    $nickUsuario=$elemento;
}
App::print_nav_listaulas($nickUsuario);
$listAulas = $app->getAulas();
$listAulas=$listAulas->fetchAll();
?>

<br/>

<div class="container">
    <div class="row">
<!--col-md- lo que ocupa los componentes de la pagina -->
<!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-30 col-md-20 offset-md-5">
            <form method="POST" action="buscarAula.php">
            <label for="nombreAula">Nombre Aula:</label>
            <select class="form-control" name="nombreAula" id="nombreAula" autofocus="autofocus">
            <option value="-1"></option>
            <?php
                foreach ($listAulas as $item) {
                    echo "<option value=".$item['nombreCorto'].">".$item['nombreCorto']."</option>";
                    }
            ?>
            </select>

        <div class="text-center">
            <br/>
            <hr/>
            <input type="submit" value="Consulta" class="btn btn-primary">
        </div>
        </div>
        </div>
        <br/>
        <hr/>
    </form>
</div>

<?php

App::print_footer();
$app = new App();
if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $nombreCorto=$_POST["nombreAula"];
      
        $resultset= $app->getBusquedaAula($nombreCorto);            
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
        echo "<p class=\"text-center\">Esa aula no esta registrada.</p>";
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
            echo "<td scope=\"row\"> <a href='reservaAula.php?nombreCorto=".$fila['nombreCorto']."'/>".$fila['nombreCorto']."</td>".
            "<td scope=\"row\">".$fila['nombreDescripcion']."</td>".
            "<td scope=\"row\">".$fila['ubicacion']."</td>".
            "<td scope=\"row\">".$fila['tic']."</td>".
            "<td scope=\"row\">".$fila['nOrdenadores']."</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }
}

     
}


?>