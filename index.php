<?php
    session_start();
    
?>
<html>
    <head>
        <link rel="stylesheet" href="css/stylesI.css">
        <title>Atrilbib</title>
        <script src="jquery-3.3.1.min.js"></script>
        <script>
            function buscar(num){
                var search = document.Forma01.search.value;
                if(search != "" && num == 1){
                    document.Forma01.method = 'post';
                    document.Forma01.action = 'search.php';
                    document.Forma01.submit();
                }else if(search == ""){
                    alert('No se ha escrito nada en el Motor de Busqueda');
                }else if(num==0){
                    alert('Se Requiere Inicio de Sesion.');
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
        <div id="pres">
            <div class="cont">
                <div class="tit">
                    <h1>&iquest;Buscando Algo Nuevo?</h1>
                </div>

                <form class="tit" id="Forma01" name="Forma01">
                    <input class="inp" id="search" name="search" type="text" placeholder="Escribe algun Tema" >
                    <?php
                        if(!isset($_SESSION['id'])){
                            echo "<input class='btn' type='button' value='Buscar' onclick='buscar(0); return false;'>";
                        }else{
                            echo "<input class='btn' type='button' value='Buscar' onclick='buscar(1); return false;'>";
                        }
                    ?>
                    
                </form>
                <form class="tit" id="Forma02" name="Forma02">
                    <input class="inp" style='width: 90%;' id="urle" name="urle" type="text" placeholder="No Encontraste lo que Buscabas? Pega una URL aqui..." >
                    <input class="btn" type="button" value="Citar" onclick="buscar_manual();">
                </form>

            </div>
            
            
        </div>
        
    </body>
</html>