<?php
$title = 'Eventos';
$eventos = 'class="active"';

require_once('header.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
if ($_SESSION['id_tipo_usuario'] == 3) { 
?>
<section id="error" class="container text-center">
        <h1>Eventos Recomendados</h1>
        <p>Esta es la sección de eventos recomendados.</p>

    <?php
    // Registrar el voluntario.
        $query = "SELECT * FROM Voluntario WHERE id_usuario = $_SESSION[id_usuario]";
        $result = mysqli_query($dbc, $query)
                or die('Error al hacer query en la base de datos!');
        $row = mysqli_fetch_array($result);
        $id_voluntario = $row['id_voluntario']; 
        
    if (isset($_POST['registrar2'])) {
        
        $id_evento=$_POST['id_evento'];
        
        $query4 = "SELECT * from Temp_Voluntario_Evento where id_voluntario = $id_voluntario AND id_evento = $id_evento;";
        $result4 = mysqli_query($dbc, $query4)
                or die('Error al hacer query4 en la base de datos!');
        
        if (mysqli_fetch_array($result4)) {
            echo '<p class="errormessage">Ya estas registrado en este evento!<p><br/>';
        }
        else {
            $query1 = "INSERT INTO Temp_Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES($id_voluntario, $id_evento)";
            $result1 = mysqli_query($dbc, $query1)
                    or die('Error al hacer query1 en la base de datos!');

            echo '<p class="okmessage" >Listo! Estas registrado en el evento! </p><br />'; 
        }
    }    

    $query2 = "SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND 
(ev.id_organizacion, ev.id_tipo_evento, ev.nombre_lugar, ev.id_provincia) IN 
	(Select ev.id_organizacion, ev.id_tipo_evento, ev.nombre_lugar, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento) 
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_organizacion, ev.id_tipo_evento, ev.nombre_lugar) IN 
	(Select ev.id_organizacion, ev.id_tipo_evento, ev.nombre_lugar FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_organizacion, ev.id_tipo_evento, ev.id_provincia) IN 
	(Select ev.id_organizacion, ev.id_tipo_evento, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_organizacion, ev.nombre_lugar, ev.id_provincia) IN 
	(Select ev.id_organizacion, ev.nombre_lugar, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_tipo_evento, ev.nombre_lugar, ev.id_provincia) IN 
	(Select ev.id_tipo_evento, ev.nombre_lugar, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_organizacion, ev.id_tipo_evento) IN 
	(Select ev.id_organizacion, ev.id_tipo_evento FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_organizacion, ev.nombre_lugar) IN 
	(Select ev.id_organizacion, ev.nombre_lugar FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_organizacion, ev.id_provincia) IN 
	(Select ev.id_organizacion, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_tipo_evento, ev.nombre_lugar) IN 
	(Select ev.id_tipo_evento, ev.nombre_lugar FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.id_tipo_evento, ev.id_provincia) IN 
	(Select ev.id_tipo_evento, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND  
(ev.nombre_lugar, ev.id_provincia) IN 
	(Select ev.nombre_lugar, ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND 
ev.id_organizacion IN (Select ev.id_organizacion from Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento) 
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND 
ev.id_tipo_evento IN (Select ev.id_tipo_evento from Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento) 
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND
ev.nombre_lugar IN (Select ev.nombre_lugar FROM Voluntario_Evento ve, Evento ev WHERE ve.id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento) 
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
UNION
SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org WHERE ev.id_organizacion = org.id_organizacion AND
ev.id_provincia IN (Select ev.id_provincia FROM Voluntario_Evento ve, Evento ev WHERE id_voluntario = $id_voluntario AND ve.id_evento = ev.id_evento)
AND ev.id_evento NOT IN (SELECT id_evento FROM Voluntario_Evento WHERE id_voluntario = $id_voluntario)
LIMIT 3";
    $result2 = mysqli_query($dbc, $query2)
    or die('Error al hacer query2 en la base de datos!');

    echo "<table border='1' class='container text-center'>
    <tr>
        <th>Nombre Evento</th>
        <th>Organización</th>
        <th>Nombre Lugar</th>
        <th>Opciones</th>";
    if ($_SESSION['id_tipo_usuario'] == 3) {
    echo "
        
    </tr>";
    }
    while ($row = mysqli_fetch_array($result2)) {
    echo "<tr>";
        $id_evento = $row['id_evento'];
        $nombre_evento = $row['nombre_evento'];
        echo "<td>" . $row['nombre_evento'] . "</td>";
        $nombre_organizacion = $row['nombre_organizacion'];
        echo "<td>" . $row['nombre_organizacion'] . "</td>";
        $nombre_lugar = $row['nombre_lugar'];
        echo "<td>" . $row['nombre_lugar'] . "</td>";
        echo "<td>";
        ?>

        <form id="formularioevento" name="formularioevento" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
            <a href="http://localhost:8888/ProyectoVoluntariado/verevento.php?id_evento=<?php echo $row['id_evento'] ?>&x=19&y=11">
                <img src="images/eye.png" title="Ver Más" width="36" height="36">
            </a>
            <?php             

            if ($_SESSION['id_tipo_usuario'] == 3) {
                ?>
                <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
                <button class="btn-registrar" type="submit" title="Registrarse" name="registrar2"></button>
                <?php
            }
            ?>
        </form>
        <?php             
       
        echo "</td>";
    echo "</tr>";
    }
    echo "</table>";
    ?>
        <a class="btn btn-primary" href="eventosrecomendados.php">Ver Más</a>
     
</section>
    <?php
}
    ?>
    <section id="error" class="container text-center">
        <h1>Todos los Eventos</h1>
        <p>Esta es la sección de todos los eventos de voluntarios.</p>
        <div class="blog">
            <div class="row">
    <?php

         
    
    // Registrar el voluntario.
    if (isset($_POST['registrar'])) {
        
        $id_evento=$_POST['id_evento'];
        $query = "SELECT * FROM Voluntario WHERE id_usuario = $_SESSION[id_usuario]";
        $result = mysqli_query($dbc, $query)
                or die('Error al hacer query en la base de datos!');
        $row = mysqli_fetch_array($result);
        $id_voluntario = $row['id_voluntario'];
        
        $query4 = "SELECT * from Temp_Voluntario_Evento where id_voluntario = $id_voluntario AND id_evento = $id_evento;";
        $result4 = mysqli_query($dbc, $query4)
                or die('Error al hacer query4 en la base de datos!');
        
        if (mysqli_fetch_array($result4)) {
            echo '<p class="errormessage">Ya estas registrado en este evento!<p><br/>';
        }
        else {
            $query1 = "INSERT INTO Temp_Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES($id_voluntario, $id_evento)";
            $result1 = mysqli_query($dbc, $query1)
                    or die('Error al hacer query1 en la base de datos!');

            echo '<p class="okmessage" >Listo! Estas registrado en el evento! </p><br />'; 
        }
    }    

    $query2 = "SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org "
            . "WHERE ev.id_organizacion = org.id_organizacion";
    $result2 = mysqli_query($dbc, $query2)
    or die('Error al hacer query2 en la base de datos!');

    echo "<table border='1' class='container text-center'>
    <tr>
        <th>Nombre Evento</th>
        <th>Organización</th>
        <th>Nombre Lugar</th>
        <th>Opciones</th>";
    if ($_SESSION['id_tipo_usuario'] == 3) {
    echo "
        
    </tr>";
    }
    while ($row = mysqli_fetch_array($result2)) {
    echo "<tr>";
        $id_evento = $row['id_evento'];
        $nombre_evento = $row['nombre_evento'];
        echo "<td>" . $row['nombre_evento'] . "</td>";
        $nombre_organizacion = $row['nombre_organizacion'];
        echo "<td>" . $row['nombre_organizacion'] . "</td>";
        $nombre_lugar = $row['nombre_lugar'];
        echo "<td>" . $row['nombre_lugar'] . "</td>";
        echo "<td>";
        ?>
        <form id="formularioevento" name="formularioevento" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
            <a href="http://localhost:8888/ProyectoVoluntariado/verevento.php?id_evento=<?php echo $row['id_evento'] ?>&x=19&y=11">
                <img src="images/eye.png" title="Ver Más" width="36" height="36">
            </a>
            <?php             

            if ($_SESSION['id_tipo_usuario'] == 3) {
                ?>
                <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
                <button class="btn-registrar" type="submit" title="Registrarse" name="registrar"></button>
                <?php
            }
            ?>
        </form>
        <?php             
       
        echo "</td>";
    echo "</tr>";
    }
    echo "</table>";
    
    ?>
        
    </div>
    </div>
</section><!--/#evento-->
    
<?php
mysqli_close($dbc);
require_once('footer.php');

