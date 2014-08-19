<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Subir canciones</title>
    </head>
    <body>
        <form action="cargarArchivo.php" method="post" enctype="multipart/form-data">
            <label for="archivo">Archivo:</label>
            <input type="file" name="archivo" />
            <br />

            <input type="submit" value="Cargar Archivo" />
        </form>
    </body>
</html>
