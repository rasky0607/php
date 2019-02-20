<?php
    include_once("app.php");
    $app = new App();
    session_start();
    $app->invalidateSession();
?>