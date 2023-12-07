<?php
    require "conecta.php";
    $con = conecta();

    $correo = $_REQUEST['name'];
    $pass = md5($_REQUEST['pass']);

    $sql = "SELECT * FROM usuarios WHERE correou = '$correo' AND passu = '$pass' AND status = 1";

    $res = $con->query($sql);
    $num = $res->num_rows;

    if($num == 1){
        $row = $res->fetch_array();
        $id = $row["id"];
        $nombre = $row["nombreu"];
        $correo = $row["correou"];

        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['nombreU'] = $nombre;
        $_SESSION['correo'] = $correo;
    }

    echo $num;

?>