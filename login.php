<html>
    <head>
        <link rel="stylesheet" href="http://localhost/Mendeley2/assets/css/styleL.css">
    </head>
    <body>
        <header>
            <script src="jquery-3.3.1.min.js"></script>
            <script>
                function validaU(){
                    var name = $('#name').val();
                    var pass = $('#pass').val();

                    $.ajax({
                        url: 'funciones/validarUser.php?name='+name+'&pass='+pass,
                        type: 'post',
                        dataType: 'text',
                        success: function(res){
                            console.log(res);
                            $('#error').show();
                            if(res==0){
                                $('#error').html('Usuario no Valido');
                                setTimeout("$('#error').html('');",3000);  
                            }else{
                                location.href = 'index.php';
                            }
                                
                        },error: function() {
                            alert('Error archivo no encontrado...');
                        }

                        })
                }
                    function validar(){
                    var name = document.Forma01.name.value;
                    var pass = document.Forma01.pass.value;
                            
                    if(name ==="" || pass ===""){
                        $('#error').html('Faltan Campos Por Llenar');
                        setTimeout("$('#error').html('');",3000);  
                    }else{
                        validaU();
                    }
                }
            </script>
        </header>
        <body>
            <div class="left"></div>
            <div class="right">
                <header class="headerc">INICIO DE SESION</header>
                <div class="campo">
                    <form name="Forma01" id="Forma01">
                        <div class="label"><label>Nombre de Usuario</label></div>
                        <div class="label"><input type="text" name="name" id="name"></div>
                        <div class="label"><label>Contrase&ntilde;a</label></div>
                        <div class="label"><input type="text" name="pass" id="pass"></div>
                        <div class="label"><button id="login" onclick="validar(); return false;" >Log In</button></div>
                        <div class="label"><button id="login" onclick="validar(); return false;" >Crear C</button></div>
                        <div class="label"><div id="error"></div></div>
                        
                    </form>
                    
                </div>
                
            </div>
        </body>

        
    </body>
</html>