<?php
$title = 'Aprobacion';
$aprobacion = 'class="active"';

require_once('header.php');
?>

    <section id="error" class="container text-center">

    <div class="center"> <!-- Aprobación de Voluntarios --------------------------------> 
        <h2>Aprobación de Voluntarios</h2>
        <p class="lead">Aquí se pueden aprobar las solicitudes de los voluntarios.</p>
    </div>
        
        <?php
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error al intentar conexion con el servidor MySQL!');
        
        // Verificar a los voluntarios. (Solo si se hace click en submit.)
        // Aprobar un Voluntario.
        if (isset($_POST['aprobar'])) {
            $id_evento = $_POST['id_evento'];
            $id_voluntario = $_POST['id_voluntario'];
            
            echo $id_evento;
            echo $id_voluntario;
            $query = "INSERT INTO Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES('$id_voluntario', '$id_evento')";
            $result = mysqli_query($dbc, $query)
                        or die('Error al hacer query en la base de datos!');
            
            $query2 = "DELETE FROM Temp_Voluntario_Evento WHERE id_voluntario = $id_voluntario AND id_evento = $id_evento ";
            echo $query2;
            $result2 = mysqli_query($dbc, $query2)
                        or die('Error al hacer query2 en la base de datos!');
            
            echo 'Listo! El voluntario fue aprobado! <br />';
        }
        
        // Rechazar un Voluntario.
        if (isset($_POST['rechazar'])) {
            $id_evento = $_POST['id_evento'];
            $id_voluntario = $_POST['id_voluntario'];            
            $query3 = "DELETE FROM Temp_Voluntario_Evento WHERE id_voluntario = $id_voluntario AND id_evento = $id_evento ";
                $result3 = mysqli_query($dbc, $query3)
                        or die('Error al hacer query3 en la base de datos!');
            echo 'Listo! El voluntario fue rechazado! <br />';
        }
        
        if (isset($_POST['submit'])) {
            $id_evento = $_POST['id_evento'];
            $id_voluntario = $_POST['id_voluntario'];            
            // Recordar inicializar la variable post.
            foreach ($_POST['verificar'] as $id_voluntario) {
                $query4 = "INSERT INTO Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES($id_voluntario, $id_evento)";
                $result4 = mysqli_query($dbc, $query4)
                        or die('Error al hacer query4 en la base de datos!');
            } 
            echo 'Listo! Verificación fue exitosa! <br />';
        }
        ?>
        
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php


        //<!---------- Lista de Aprobación de Voluntarios ------------------------------------------->
        $query5 = "SELECT tve.*, vol.*, ev.nombre_evento, org.* "
                . "FROM Temp_Voluntario_Evento tve, Voluntario vol, Evento ev, Organizacion org "
                . "WHERE tve.id_voluntario = vol.id_voluntario AND tve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion AND ev.id_organizacion = $_SESSION[id_organizacion]";

        $result5 = mysqli_query($dbc, $query5)
        or die('Error al hacer query5 en la base de datos!');

        echo "<table width='100%' border='1' class='container text-center' >
        <tr>
            <th><li><input type='checkbox' id='selectall'/> Select All</li></th>
            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Primer Nombre</th>
            <th>Primer Apellido</th>
            <th>Opciones</th>
        </tr>";
        while ($row = mysqli_fetch_array($result5)) {
        echo "<tr>";
            echo "<td> <input class='checkbox1' type='checkbox' value='" . $row['id_voluntario'] . "'name='verificar[]' /></td>";
            $id_voluntario = $row['id_voluntario'];
            echo "<td>" . $row['id_voluntario'] . "</td>";
            $nombre_evento = $row['nombre_evento'];
            echo "<td>" . $row['nombre_evento'] . "</td>";
            $primer_nombre = $row['primer_nombre'];
            echo "<td>" . $row['primer_nombre'] . "</td>";
            $primer_apellido = $row['primer_apellido'];
            echo "<td>" . $row['primer_apellido'] . "</td>";
            echo "<td>";
            ?>
            <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
            <input  type="hidden" name="id_voluntario" value="<?php echo $row['id_voluntario']?>"/>
            <?php
            echo "<input class='btn-accept' type='submit' name='aprobar' value='' />";
            echo "<input class='btn-rechazar' type='submit' name='rechazar' value='' />";
            echo   "</td>";
            

        echo "</tr>";
        }
        echo "</table>";

        echo '<input class="btn btn-primary" type="submit" name="submit" value="Verificar" />';
        ?>

    </form>

    </section><!--/#aprobaciones-->

    
    <section id="error" class="container text-center">

    <div class="center"> <!-- Lista de Voluntarios Aprobados --------------------------------> 
        <h2>Voluntarios Aprobados</h2>
        <p class="lead">Esta es la lista de los voluntarios aprobados para este evento.</p>
    </div>
        
        <?php

        //<!---------- Lista de Aprobación de Voluntarios ------------------------------------------->
        /*
        $query6 = "SELECT ve.*, vol.*, ev.nombre_evento, org.* "
                . "FROM Voluntario_Evento ve, Voluntario vol, Evento ev, Organizacion org "
                . "WHERE ve.id_voluntario = vol.id_voluntario AND ve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion "
                . "AND ev.id_organizacion = $_SESSION[id_organizacion] AND ev.id_evento = $_POST[id_evento]";
         */
        $query6 = "SELECT ve.*, vol.*, ev.nombre_evento, org.* "
                . "FROM Voluntario_Evento ve, Voluntario vol, Evento ev, Organizacion org "
                . "WHERE ve.id_voluntario = vol.id_voluntario AND ve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion AND ev.id_organizacion = $_SESSION[id_organizacion]";
        
        $result6 = mysqli_query($dbc, $query6)
        or die('Error al hacer query6 en la base de datos!');

        echo "<table width='100%' border='1' class='container text-center' >
        <tr>
            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Primer Nombre</th>
            <th>Primer Apellido</th>
        </tr>";
        while ($row = mysqli_fetch_array($result6)) {
        echo "<tr>";
            $id_voluntario = $row['id_voluntario'];
            echo "<td>" . $row['id_voluntario'] . "</td>";
            $nombre_evento = $row['nombre_evento'];
            echo "<td>" . $row['nombre_evento'] . "</td>";
            $primer_nombre = $row['primer_nombre'];
            echo "<td>" . $row['primer_nombre'] . "</td>";
            $primer_apellido = $row['primer_apellido'];
            echo "<td>" . $row['primer_apellido'] . "</td>";
            
        echo "</tr>";
        }
        echo "</table>";

        ?>

    </section><!--/# Lista de Voluntarios Aprobados -->    
    
<?php
        mysqli_close($dbc);
require_once('footer.php');
?>
