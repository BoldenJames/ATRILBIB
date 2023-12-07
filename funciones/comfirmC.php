<?php
    require "conecta.php";
    $con = conecta();
    $Ccorreo = $_REQUEST['correo'];
    $ban = 0;

    $sql = "SELECT * FROM usuarios";
    $res = $con->query($sql);

    while($row = $res->fetch_array()){
        $correo = $row["correou"]; 
        if($Ccorreo == $correo){
            $ban = 1;
            break;
        }
    }

    echo $ban;

?>