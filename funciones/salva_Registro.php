<?php
    require "conecta.php";
    $con = conecta();

    $id_user        = $_REQUEST['user'];
    $nombre_cita    = $_REQUEST['citA']; 
    $url            = $_REQUEST['url'];

    $sql = "INSERT INTO librerias (id_usuarios, urle, nombre_cita) VALUES ($id_user, '$url', '$nombre_cita')";
    $res = $con->query($sql);

    $ban = 1;
    echo $ban;
?>