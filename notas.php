<?php
    session_start();
    if(!isset($_SESSION['id'])){
        session_destroy();
        header("Location: index.php");
    }
    $idUser = $_SESSION['id'];
    require "funciones/conecta.php";
    $con = conecta();

    $sql = "SELECT * FROM notas WHERE id_usuarios = $idUser";
    $res = $con->query($sql);
?>