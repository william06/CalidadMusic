<html>
    <head>
        <meta charset="utf-8" />
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
                //move_uploaded_file($_FILES["archivo"]["tmp_name"], "Musica/" . $_FILES["archivo"]["name"]);
            }
        ?>
    </body>
</html>
