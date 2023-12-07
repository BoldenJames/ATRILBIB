<?php
    require "conecta.php";
    $con = conecta();

    $nombre     = $_REQUEST['name'];
    $correo     = $_REQUEST['correo'];
    $pass       = $_REQUEST['pass'];
    $passEnc    = md5($pass);

    $sql = "INSERT INTO usuarios (nombreu, correou, passu) VALUES ('$nombre', '$correo', '$passEnc')";
    $res = $con->query($sql);

    header('Location: ../index.php');
?>