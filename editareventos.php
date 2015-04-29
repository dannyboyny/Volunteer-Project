<?php
$title = 'Editar Eventos';
$miseventos = 'class="active"';

require_once('header.php');
?>

    <section id="error" class="container text-center">
        <h1>Página de Gestionar Eventos</h1>
        <p>Esta es la página de editar eventos de voluntarios.</p>
        <a class="btn btn-primary" href="miseventos.php">Regresar a Mis Eventos</a><br />

<?php
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');

if (isset($_POST['actualizar'])) {
    //$id_evento = $_POST['id_evento'];
    $id_organizacion = $_POST['id_organizacion'];
    $nombre_evento = $_POST['nombreevento'];
    $nombre_lugar = $_POST['nombrelugar'];
    $id_provincia = $_POST['provincia1'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $id_tipo_evento = $_POST['tipo_evento1'];
    $cant_voluntarios_solicitado = $_POST['cant_voluntarios_solicitado'];
    $descripcion = $_POST['descripcion'];
    
    $query1 = "UPDATE Evento SET nombre_evento = '$nombre_evento', nombre_lugar = '$nombre_lugar', id_provincia = $id_provincia, direccion = '$direccion', "
            . "ciudad = '$ciudad', id_tipo_evento = $id_tipo_evento, cant_voluntarios_solicitado = '$cant_voluntarios_solicitado', descripcion = '$descripcion' "
        . "WHERE id_evento = $_GET[id_evento]";
    $result1 = mysqli_query($dbc, $query1)
            or die('Error al hacer query1 en la base de datos!');

    echo 'Listo! El evento fue editado! <br />';
}
    
    $query2 = "SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org "
            . "WHERE ev.id_organizacion = org.id_organizacion AND org.id_organizacion = $_SESSION[id_organizacion] "
            . "AND ev.id_evento = $_GET[id_evento]";    
    $result2 = mysqli_query($dbc, $query2)
    or die('Error al hacer query2 en la base de datos!');
    
    $row = mysqli_fetch_array($result2);
    $nombre_evento = $row['nombre_evento'];
    $nombre_lugar = $row['nombre_lugar'];
    $id_provincia = $row['id_provincia'];
    $direccion = $row['direccion'];
    $id_tipo_evento = $row['id_tipo_evento'];
    $cant_voluntarios_solicitado = $row['cant_voluntarios_solicitado'];
    $descripcion = $row['descripcion'];
    
    echo $nombre_evento;
    $urlevento = "?id_evento=$_GET[id_evento]&x=19&y=11";
?>                   
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; echo $urlevento; ?>">
        <div>
            <div>
                <label style="width:150px;display:inline-block;">Nombre del Evento *</label>
                <input type="text" name="nombreevento" value="<?php print $nombre_evento ?>">
            </div>
            <div>
                <label style="width:150px;display:inline-block;">Nombre Lugar *</label>
                <input type="text" name="nombrelugar" value="<?php print $nombre_lugar ?>">
            </div>
            <div>
                <label style="width:150px;display:inline-block;">Dirección</label>
                <input type="text" name="direccion" value="<?php print $direccion ?>"/>
            </div>  
            <div>
                <label style="width:150px;display:inline-block;text-align: left;">Ciudad</label>
                <input type="text" name="ciudad" value="<?php print $ciudad ?>">
            </div>               
            <div>
            <?php
                $query2 = "SELECT * FROM Provincia";
                $result2 = mysqli_query($dbc, $query2)
                        or die('Error al hacer query2 en la base de datos!');

                if (mysqli_num_rows($result2) !=0) {

                    ?>  
                        <label for="provincia1" style="width:150px;display:inline-block;text-align: left;">Provincia:</label>
                        <select name="provincia1" id="provincia1">
                                 <option value="" >provincia</option>
                                 <?php 
                                while ($provincia = mysqli_fetch_array($result2)) {
                                    if(isset($row['id_provincia'])){
                                        ?>    
                                        <option value="<?php print $provincia[id_provincia] ?> " <?php if($provincia[id_provincia] == $row[id_provincia]){ print $selected; } ?> > <?php print $provincia['nombre_provincia'] ?> </option>
                                        <?php
                                    } else {
                                        echo '<option value="' . $provincia['id_provincia'] . ' ">' . $provincia['nombre_provincia'] . '</option>';
                                    }

                                }
                                ?>
                                </select> <br />
                                <?php 
                }            
            ?>
            </div> 

            <div>
            <?php
                $query4 = "SELECT * FROM Tipo_Evento";
                $result4 = mysqli_query($dbc, $query4)
                        or die('Error al hacer query4 en la base de datos!');

                if (mysqli_num_rows($result4) !=0) {

                    ?>  
                        <label for="tipo_evento1" style="width:150px;display:inline-block;text-align: left;">Tipo de Evento: *</label>
                        <select name="tipo_evento1" id="tipo_evento1">
                                 <option value="" >tipo de evento</option>
                                 <?php 
                                while ($tipo_evento = mysqli_fetch_array($result4)) {
                                    if(isset($row['id_tipo_evento'])){
                                        ?>    
                                        <option value="<?php print $tipo_evento[id_tipo_evento] ?> " <?php if($tipo_evento[id_tipo_evento] == $row[id_tipo_evento]){ print $selected; } ?> > <?php print $tipo_evento['nombre_tipo_evento'] ?> </option>
                                        <?php
                                    } else {
                                        echo '<option value="' . $tipo_evento[id_tipo_evento] . ' ">' . $tipo_evento['nombre_tipo_evento'] . '</option>';
                                    }

                                }
                                ?>
                                </select> <br />
                                <?php 
                }            
            ?>            

            </div>
            <div>
                <label style="width:150px;display:inline-block;">Cantidad de Voluntarios</label>
                <input type="text" name="cant_voluntarios_solicitado" value="<?php print $cant_voluntarios_solicitado ?>">
            </div>
            <div>
                <label style="width:150px;display:inline-block;">Descripcion</label>
                <textarea name="descripcion" rows="8"><?php print $descripcion ?></textarea>
            </div>
            
            <div>
                <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
                <input  type="hidden" name="id_organizacion" value="<?php echo $row['id_organizacion']?>"/>
                <button class="btn btn-primary" type="submit" name="actualizar">Actualizar Evento</button>
            </div>

        </div>
    </form>         
<?php    
        /*
	fecha_hora_inicio datetime,
	fecha_hora_fin datetime,
	tipo_evento varchar(20),
	cant_voluntarios_solicitado varchar(10),
	descripcion varchar(500),
	fecha_evento_creado datetime
         * 
         */

?>       
        
    </section><!--/#error-->
       
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
            //$id_evento = $_POST['id_evento'];
            $id_voluntario = $_POST['id_voluntario'];

            $query5 = "INSERT INTO Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES($id_voluntario, $_GET[id_evento])";
            $result5 = mysqli_query($dbc, $query5)
                        or die('Error al hacer query5 en la base de datos!');
            
            $query6 = "DELETE FROM Temp_Voluntario_Evento WHERE id_voluntario = $id_voluntario AND id_evento = $_GET[id_evento] ";
            $result6 = mysqli_query($dbc, $query6)
                        or die('Error al hacer query6 en la base de datos!');
            
            echo 'Listo! El voluntario fue aprobado! <br />';
        }
        
        // Rechazar un Voluntario.
        if (isset($_POST['rechazar'])) {
            $query7 = "DELETE FROM Temp_Voluntario_Evento WHERE id_voluntario = $id_voluntario AND id_evento = $_GET[id_evento] ";
                $result7 = mysqli_query($dbc, $query7)
                        or die('Error al hacer query7 en la base de datos!');
            echo 'Listo! El voluntario fue rechazado! <br />';
        }
        
        if (isset($_POST['submit'])) {
            // Recordar inicializar la variable post.
            foreach ($_POST['verificar'] as $id_voluntario) {
                $query8 = "INSERT INTO Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES($id_voluntario, $_GET[id_evento])";
                $result8 = mysqli_query($dbc, $query8)
                        or die('Error al hacer query8 en la base de datos!');
            } 
            foreach ($_POST['verificar'] as $id_voluntario) {
                $query9 = "DELETE FROM Temp_Voluntario_Evento WHERE id_voluntario = $id_voluntario AND id_evento = $_GET[id_evento] ";
                $result9 = mysqli_query($dbc, $query9)
                        or die('Error al hacer query9 en la base de datos!');
            } 
            echo 'Listo! Verificación fue exitosa! <br />';
        }
        ?>
        
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; echo $urlevento; ?>">
        <?php

        //<!---------- Lista de Aprobación de Voluntarios ------------------------------------------->
        $query10 = "SELECT tve.*, vol.*, ev.nombre_evento, org.* "
                . "FROM Temp_Voluntario_Evento tve, Voluntario vol, Evento ev, Organizacion org "
                . "WHERE tve.id_voluntario = vol.id_voluntario AND tve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion "
                . "AND ev.id_organizacion = $_SESSION[id_organizacion] AND ev.id_evento = $_GET[id_evento]";

        $result10 = mysqli_query($dbc, $query10)
        or die('Error al hacer query10 en la base de datos!');

        echo "<table width='100%' border='1' class='container text-center' >
        <tr>
            <th><li><input type='checkbox' id='selectall'/> Select All</li></th>
            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Primer Nombre</th>
            <th>Primer Apellido</th>
            <th>Opciones</th>
        </tr>";
        while ($row = mysqli_fetch_array($result10)) {
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
        <br/>
    </form>

    <div class="center"> <!-- Voluntarios Aprobados --------------------------------> 
        <h2>Voluntarios Aprobados</h2>
        <p class="lead">Esta es la lista de los voluntarios aprobados para este evento.</p>
    </div>   
    <?php
        //<!---------- Lista de Voluntarios Aprobados ------------------------------------------->
        $query11 = "SELECT ve.*, vol.*, ev.nombre_evento, org.* "
                . "FROM Voluntario_Evento ve, Voluntario vol, Evento ev, Organizacion org "
                . "WHERE ve.id_voluntario = vol.id_voluntario AND ve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion "
                . "AND ev.id_organizacion = $_SESSION[id_organizacion] AND ev.id_evento = $_GET[id_evento]";

        $result11 = mysqli_query($dbc, $query11)
        or die('Error al hacer query11 en la base de datos!');

        echo "<table width='100%' border='1' class='container text-center' >
        <tr>
            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Primer Nombre</th>
            <th>Primer Apellido</th>
        </tr>";
        while ($row = mysqli_fetch_array($result11)) {
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
        
        
        $query12 = "SELECT Count(id_voluntario) AS total FROM Voluntario_Evento WHERE id_evento = $_GET[id_evento]";
        $result12 = mysqli_query($dbc, $query12)
        or die('Error al hacer query12 en la base de datos!');

        echo "<table border='1' class='container text-center'>
        <tr>

            <th style='text-align:center'>Total de Voluntarios</th>
        </tr>";
        while ($row = mysqli_fetch_array($result12)) {
        echo "<tr>";

            echo "<td>" . $row['total'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";           
        
        ?>
    </section><!--/#aprobaciones-->    
    
    
    
    <section id="error" class="container text-center">
    <h1>Mapa del Evento</h1>
        <div class="gmap-area">
            <div class="container">
                <div class="row">
                     <div class="col-sm-5 text-center">
                        <div class="gmap">
                            <!--
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=JoomShaper,+Dhaka,+Dhaka+Division,+Bangladesh&amp;aq=0&amp;oq=joomshaper&amp;sll=37.0625,-95.677068&amp;sspn=42.766543,80.332031&amp;ie=UTF8&amp;hq=JoomShaper,&amp;hnear=Dhaka,+Dhaka+Division,+Bangladesh&amp;ll=23.73854,90.385504&amp;spn=0.001515,0.002452&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=1073661719450182870&amp;output=embed"></iframe>
                            -->
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/@19.451729, -70.693638,19z?hl=en"></iframe>
                            
                        </div>
                        <div class="col-sm-7 map-content">
                            <ul class="row">
                                <li class="col-sm-6">
                                    <address>
                                        <h5>Monumento Santiago</h5>
                                        <p>Calle del Sol<br>
                                        Santiago, RD</p>
                                        <p>Teléfono:809-898-2847 <br>
                                        Email : <?php print $_SESSION['email'] ?></p>
                                    </address>
                                </li>
                            </ul>
                        </div>
                    </div>   
               </div>
            </div>
        </div>    
    </section><!--/mapa-->
    
<?php
mysqli_close($dbc);
require_once('footer.php');