<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1); 
    ini_set('MAX_EXECUTION_TIME', -1);   
    set_time_limit(12000);
    
    $carpeta = 'musica/'; 
    require('getId3/getid3.php');
    require('BaseDeDatos.php');
    
    borrarCanciones();
    
?>


<html>
    <head>
        <meta charset="utf-8" />
        <title>Subir Canciones</title>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
            if($_FILES["archivo"]["error"] > 0)
                echo "Error al subir el archivo: " . $_FILES["archivo"]["error"] . "<br />";
            else 
            {
                echo "Nombre del archivo: " .  $_FILES["archivo"]["name"] . "<br />";
                echo "Tipo: "               .  $_FILES["archivo"]["type"] . "<br />";
                echo "Tamaño: "             . ($_FILES["archivo"]["size"] / 1024) . "Kb<br />";
                echo "Guardado en: "        .  $_FILES["archivo"]["tmp_name"] . "<br />";
            
                //Mover el archivo subido a la ubicación temporal a la carpeta destino que queramos
                move_uploaded_file($_FILES["archivo"]["tmp_name"], "musica/" . $_FILES["archivo"]["name"]);

                
            
            }
        ?>
        
            <?php
                $archivos = glob($carpeta . '*.mp3');       
                $getID3 = new getID3;               
                
                foreach($archivos as $archivo)
                {         
                    $id3 = $getID3->analyze($archivo);
                    getid3_lib::CopyTagsToComments($id3);
                
                    
                
                    //Devuelve el nombre del archivo sin su ruta
                    $nombreArch = basename($archivo);
                
                    list($intérprete, $título, $álbum) = split(" \- ", $nombreArch);
                
                    $título     = $id3['comments_html']['title'][0];
                    $álbum      = $id3['comments_html']['album'][0];
                    $intérprete = $id3['comments_html']['artist'][0];
                    $año        = $id3['comments_html']['year'][0];
                    $género     = $id3['comments_html']['genre'][0];
                
                   insertarCanción($nombreArch, $título, $intérprete, $álbum, $año, $género);
                
                    
                }
            ?>
       
    </body>
</html>