<?php
    
    require "conecta.php";
    $con = conecta();
    session_start();

    $idUser = $_SESSION['id'];
    $fecha  = date('Y-m-d h:i:s');
    $nota   = $_REQUEST['nota'];
    $titulo = "Nota. Comentario";

    $sql1 = "INSERT INTO notas (id_usuarios,nota,fecha,titulo) VALUES ($idUser, '$nota', '$fecha', '$titulo')";
    $res = $con->query($sql1);
    $ban = 1;
    echo $ban;
?>