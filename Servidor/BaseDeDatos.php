<?php
    
    /*
        CREATE TABLE `canciones` (
          `Id` int(10) NOT NULL AUTO_INCREMENT,
          `Archivo` varchar(255) NOT NULL,
          `Título` varchar(255) NOT NULL,
          `Intérprete` varchar(255) DEFAULT NULL,
          `Álbum` varchar(255) DEFAULT NULL,
          `Año` int(10) DEFAULT NULL,
          `Género` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`Id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
    */
    
    function conexiónBD () {
        $conn =	null;
        $srv  = 'localhost';
        $bd   = 'PrograIII';
        $usr  = 'root';
        $pwd  = 'root';
    
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
    
    function borrarCanciones()
    {
        try
        {        
            //Establecer conexión
            $conn = conexiónBD();
    
            //Ejecutar sentencia
            $cont = $conn->exec("DELETE FROM `canciones`; ALTER TABLE `canciones` AUTO_INCREMENT = 1;");        
        }
        catch (PDOException $e)
        {
            echo '<p>¡Error al borrar las canciones!</p>';
            echo '<p>' . $e . '</p>';
            exit;
        }
        //Retornar cantidad de registros modificados
        return $cont;
    }
    
    function insertarCanción($archivo, $título, $intérprete, $álbum, $año, $género)
    {
        try
        {
            //Establecer conexión
            $bd = conexiónBD();              
    
            //Preparar Sentencia SQL
            $sql = $bd->prepare("INSERT INTO `canciones` 
                                 (`Archivo`, `Título`, `Intérprete`, `Álbum`, `Año`, `Género`)
                                 VALUES
                                 (?, ?, ?, ?, ?, ?)");
    
            $sql->execute( array( $archivo, $título, $intérprete, $álbum, $año, $género) );
        }
        catch (PDOException $e)
        {
            echo '<p>¡Error insertar canción a la BD!</p>';
            echo '<p>' . $e . '</p>';
            exit;
        }
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
                                 Where  `Título` Like :criterio Or `Intérprete` Like :criterio Or
                                        `Álbum` Like :criterio Or `Año` Like :criterio Or `Género` Like :criterio");
    
            $sql->execute( array( ':criterio' => "%" . $criterio . "%") );
            $registros = $sql->fetchAll();

            if(empty($registros)) {
                echo "<tr>";
                echo "<td colspan='4'>There were not records</td>";
                echo "</tr>";
            }
            else {
                foreach ($registros as $reg) {
                    echo "<tr>";
                        echo "<td>".$reg['Título']."</td>";
                        echo "<td>".$reg['Intérprete']."</td>";
                        echo "<td>".$reg['Álbum']."</td>";
                        echo "<td>".$reg['telephone']."</td>";
                    echo "</tr>";
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