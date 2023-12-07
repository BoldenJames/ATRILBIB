<?php

    include('simple_html_dom.php');
    
    session_start();
    if(!isset($_SESSION['id'])){
        session_destroy();
        header("Location: index.php");
    }

    $idUser = $_SESSION['id'];

    $busqueda = $_REQUEST['search'];
    $arreglo = explode(" ", $busqueda);
    $len = count($arreglo);
    $varia = "https://scholar.google.es/scholar?hl=es&as_sdt=0%2C5&q=";

    $vari = 0;

    function contador(&$vari){
        $vari = $vari + 1;
    }

    $i;
    for($i=0;$i<$len;$i++){
        if($i==$len-1){
           $varia = $varia."$arreglo[$i]";
        }else{
            $varia = $varia."$arreglo[$i]+";
        }
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $varia);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $respuesta = curl_exec($curl);
    curl_close($curl);
?>
<html>
    <head>
    <link rel="stylesheet" href="http://localhost/Mendeley2/assets/css/stylesI.css">
        <title>
            <?php
                echo "Resultados de: $busqueda";
            ?>
        </title>
        <script src="jquery-3.3.1.min.js"></script>
        <script>
            function uRl(variable){
                var element = document.getElementById('art_'+variable).firstChild;
                var urle    = element.getAttribute('href');
                
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


            function buscar_manual(){
                var urle = $('#search').val();
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
                });

            }

            function real(variable,iduser){
                var element = document.getElementById('art_'+variable).firstChild;
                var urle    = element.getAttribute('href');
                var cita    = $('#ART_'+variable).val();

                $.ajax({
                    url: 'funciones/salva_Registro.php?url='+urle+'&citA='+cita+'&user='+iduser,
                    type: 'post',
                    dataType: 'text',
                    success: function(res){
                        console.log(res);
                        if(res==1){
                            alert('Se logro');
                        }else{
                            alert('NO');
                        }
                        
                    },error: function() {
                        alert('Error archivo no encontrado...');
                    }
                })


            }

            function dirL(){
                location.href = 'libreria.php';
            }

            function showNota(){
                $('#nota').css("visibility","visible");
                $('#lol').css("visibility","visible");
            }

            function guardarN(){
                var nota    = $('#nota').val();
                $.ajax({
                    url: 'funciones/guardarN.php',
                    type: 'post',
                    dataType: 'text',
                    data: 'nota='+nota,
                    success: function(res){
                        console.log(res);
                        if(res==1){
                            alert('Se logro');
                        }else{
                            alert('Ocurrio un Error...');
                        }
                        
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
                    location.href = 'notas.php';
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
        
        <div class="titulo"><input class="inp" style='width: 90%;' id="search" name="search" type="text" placeholder="No Encontraste lo que Buscabas? Pega una URL aqui..." ><input class="btn" type="button" value="Buscar" onclick="buscar_manual();"></div>
        <textarea name="nota" id="nota" cols="30" rows="10"></textarea><button id="lol" onclick='guardarN();'>Guardar</button>
        <?php
            $titArticulos = new simple_html_dom();
            $titArticulos->load($respuesta);

            foreach($titArticulos->find('a[href]') as $link){
                
                $cadena = strval($link->plaintext);
                $valido = strpos($cadena,$arreglo[0]);
                $valido1 = strpos($cadena,strtolower($arreglo[0]));
                
                if($valido === false && $valido1 === false){
                    //
                }else{
                    contador($vari);
                    echo "<div class='titulo'><div class='cos' id='art_$vari'>$link</div><div class='footer'><div class='menu'><button class='left' onclick='showNota();'>Notas</button><button class='right' onclick='real($vari,$idUser);'>Agregar a Libreria</button><button class='right' onclick='uRl($vari)'>Citar</button><input type='hidden' value='$cadena' id='ART_$vari'></div></div></div>";
                }   
            }
            
        ?> 
        
    </body>
</html>
       
    
    
    

<?php
    //QUE NO SE TE OLVIDE PENDEJO
    //CONCATENAS LO QUE OBTENGAS DEL INPUT DE BUSQUEDA Y LO SUMAS A LA URL DE BUSQUEDA PARA QUE JALE CON MADRES CON ESA URL SE BUSCA EN GOOGLE ACADEMICO
    //https://scholar.google.es/scholar?hl=es&as_sdt=0%2C5&q=ranas+de+cristal&btnG=&oq=ranas+
    //https://scholar.google.es/scholar?hl=es&as_sdt=0%2C5&q=ranas+de+cristal
    //https://scholar.google.es/scholar?hl=es&as_sdt=0%2C5&q=
?>

