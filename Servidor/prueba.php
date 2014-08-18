<?php
    //http://php.net/manual/es/intro.pdo.php    
	header('Content-Type: text/html; charset=UTF-8');
    error_reporting(E_ERROR);
    //error_reporting(E_ALL);
    ini_set('display_errors', 1); 
    
    function conexiónBD () {
        $conn =	null;
        $srv  = 'localhost';
        $bd   = 'u704093042_music';
        $usr  = 'u704093042_admin';
        $pwd  = '123456';
    
        try {
            $conn = new PDO('mysql:host=' . $srv . ';dbname=' . $bd, $usr, $pwd);
        }
        catch (PDOException $e) {
            echo '<p>¡No se pudo conectar a la base de datos!</p>';
            echo '<p>' . $e . '</p>';
            exit;
        }
        return $conn;
    }   
    
    function buscarCanciones($criterio)
    {
        try
        {        
            //Establecer conexión
            $bd = conexiónBD();
    
            //Preparar Sentencia SQL
            $sql = $bd->prepare("Select *
                                 From   `canciones` 
                                 Where  `Titulo` Like :criterio Or `Interprete` Like :criterio Or `Album` Like :criterio Or
                                        `Annio` Like :criterio Or `Genero` Like :criterio");
    
            $criterio = "%" . $criterio . "%";
            $sql->execute(array( ':criterio' => $criterio ));
            $registros = $sql->fetchAll();
    
            if(empty($registros)) {
                echo "<tr>";
                echo "<td colspan='3'>No hay registros que correspondan al criterio</td>";
                echo "</tr>";
            }
            else {
                foreach ($registros as $reg) {
					echo '<li>';
					echo '<input type="hidden" ';
					echo 'value="'.$reg['Archivo'].'"/>';
					echo '<img src="../Imagenes/imagenPorDefecto.png" />';
					echo '<span class="icon-indent-increase" ></span>';
                    echo '<span class="icon-play" ></span>';
                    echo '<span class="icon-remove" onclick="borrar()" ></span>';
                    echo '<h2>'.$reg['Titulo'].'</h2>';
					echo '<h3>'.$reg['Interprete'].' - '.$reg['Album'].'</h3>';
                    echo '</li>';
                }
            }
        }
        catch (PDOException $e)
        {
            echo '<p>¡Error al buscar canciones!</p>';
            echo '<p>' . $e . '</p>';
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<link href="../estilos.css" rel="stylesheet" />
        <link rel="stylesheet" href="../style.css">
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="../Scripts/app.js"></script>
    </head>
    <body>
		<div id="divResultados">
            <form>
                <input id="txtBusqueda" name="buscarPor" type="text" autofocus="true" placeholder="&#128269; Buscar por cancion, artista o genero" />
                <button id="btnBuscar">Buscar</button>
            </form>
			<div>
				<ul class="lista">
					<?php buscarCanciones(""); ?>
				</ul>
			</div>	
		</div>		
    </body>
</html>

