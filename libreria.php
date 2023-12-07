<?php
    require "funciones/conecta.php";
    $con = conecta();

    session_start();
    if(!isset($_SESSION['id'])){
        session_destroy();
        header("Location: index.php");
    }

    $idUser = $_SESSION['id'];
    $nombreU = $_SESSION['nombreU'];
    $sql = "SELECT * FROM librerias WHERE id_usuarios = $idUser AND status = 1";
    $res = $con->query($sql);
    $num = $res->num_rows;
?>

<html>
    <head>
    <link rel="stylesheet" href="http://localhost/Mendeley2/assets/css/stylesI.css">
    <script src="jquery-3.3.1.min.js"></script>
    <script>
        function regis(num){
            if(num==0){
                location.href = 'login.php';
            }else if(num==1){
                location.href = 'registrarse.php';
            }else if(num==3){
                location.href = 'funciones/cerrar.php';
            }else if(num==4){
                location.href = 'libreria.php';
            }else if(num==5){
                location.href = 'index.php';
            }else{
                alert('Se Requiere Inicio de Sesion');
            }
                
        }
        function buscar_manual(){
                var urle = $('#urle').val();
                $.ajax({
                    url: "recibe_url.php",
                    type: 'post',
                    dataType: 'text',
                    data: 'urle='+urle,
                    success: function(res){
                        console.log(res);
                        alert(res);
                        
                    },error: function() {
                        alert('Error archivo no encontrado...');
                    }
                })

            }
    </script>
    </head>
    <body>
        <header>
            <div class="menu">
                <?php
                    if(!isset($_SESSION['id'])){
                        echo "<button class='left' onclick='regis(0);'>Inicio de Sesion</button>";
                        echo "<button class='right' onclick='regis(1);'>Registrate</button>";
                        echo "<button class='right' onclick='regis(100);'>Mis Librerias</button>";
                        echo "<button class='right' onclick='regis(100);'>Mis Notas</button>";
                    }else{
                        echo "<button class='left' onclick='regis(3);'>Cerrar Sesion</button>";
                        echo "<button class='right' onclick='regis(1);'>Registrate</button>";
                        echo "<button class='right' onclick='regis(4);'>Mis Librerias</button>";
                        echo "<button class='right' onclick='regis(5);'>Mis Notas</button>";
                    }
                ?>

            </div>
        </header>
        <div class="tabla">
            <div class="hea">
                    Articulos Obtenidos
            </div>
            <div class="col">
                <div class="row" style='width: 85px'>Id</div>
                <div class="row" style='width: 325px'>Nombre del Sitio</div>
                <div class="row" style='width: 350px'>Url</div>
                <div class="row" style='width: 100px'></div>
            </div>
            <?php
                if($num != 0){
                    while($row = $res->fetch_array()){
                        $url    = $row['urle'];
                        $cita   = $row['nombre_cita'];
                        $idL    = $row['id'];

                        echo "<div class='col'><div class='row' style='width: 85px'>$idL</div><div class='row' style='width: 325px'>$cita</div><div class='row' style='width: 350px'><a href='$url'>$url</a></div><div class='row' style='width: 100px'>ELIMINAR</div></div>";
                    }
                }
                
            ?>
            <form class="tit" id="Forma02" name="Forma02">
                    <input class="inp" style='width: 90%;' id="urle" name="urle" type="text" placeholder="Pega una URL para citarla..." >
                    <input class="btn" type="button" value="Citar" onclick="buscar_manual();">
            </form>
        </div>
        
    </body>
</html>