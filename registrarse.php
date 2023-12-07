<?php

?>
<html>
    <head>
        <title>ALTA DE EMPLEADOS</title>
        <link rel="stylesheet" href="http://localhost/Mendeley2/assets/css/styleL.css">
        
        <script src="jquery-3.3.1.min.js"></script>
        <script>
            function validar(){
                var nombre = document.Forma01.name.value;
                var correo = document.Forma01.correo.value;
                var pass = document.Forma01.pass.value;

                
                if(correo == "" || pass == "" || correo == "@" || nombre == ""){
                    $('#mensaje').html('Faltan Campos por Llenar...');
                    setTimeout("$('#mensaje').html('');",5000);
                    
                }else{
                    document.Forma01.method = 'post';
                    document.Forma01.action = 'funciones/salvaU.php';
                    document.Forma01.submit();
                }
                

            }


            function saleC(){
                var correo = $('#correo').val();
                $.ajax({
                    url: "funciones/comfirmC.php",
                    type: 'post',
                    dataType: 'text',
                    data: 'correo='+correo,
                    success: function(res){
                        console.log(res);
                        $('#error').show();
                        if(res==1){
                            $('#correo').val('');
                            $('#error').html('Ya existe un usuario registrado con este correo');
                            setTimeout("$('#error').html('');",5000);
                        }
                        
                    },error: function() {
                            alert('Error archivo no encontrado...');
                    }

                    });
            }
        </script>
    </head>
    <body>
        <div class="cc">
            <header>
                
            </header>
            <div class="right">
                <header class="headerc">REGISTRO</header>
                <div class="campo">
                    <form name="Forma01" id="Forma01">
                        <div class="label"><label>Nombre de Usuario</label></div>
                        <div class="label"><input type="text" name="name" id="name"></div>
                        <div class="label"><label>Correo</label></div>
                        <div class="label"><input type="text" name="correo" id="correo" onblur='saleC(); return false;'></div>
                        <div class="label"><label>Contrase&ntilde;a</label></div>
                        <div class="label"><input type="text" name="pass" id="pass"></div>
                        <div class="label"><button id="login" onclick="validar(); return false;" >Crear</button></div>
                        <div class="label"><div id="error"></div></div>
                        
                    </form>
                    
                </div>
                
            </div>
                
        </div>
    </body>
</html>