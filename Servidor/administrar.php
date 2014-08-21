<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link href="estilos2.css" rel="stylesheet" />
        <title>Subir archivos al servidor utilizando PHP</title>
    </head>
    <body>
        <header class="fijo">
           <span id="titulo">Calidad Music</span>
        </header>
        <br/><br/><br/>
        <h1>Subir canciones</h1>
        <br/>
        <div>
        <form action="cargarArchivo.php" method="post" enctype="multipart/form-data">
            <label for="archivo">Archivo:</label>
            <input type="file" name="archivo" />
            <br/>
            <br />

            <input type="submit" value="Cargar Archivo" class="boton"/>
        </form>
            </div>
    </body>
</html>
