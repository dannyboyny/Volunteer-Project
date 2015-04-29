<?php

// Asignar los valores de la sesión si no tienen valores asignado usando un cookie.
if (!isset($_SESSION['id_usuario'])) {
 if (isset($_COOKIE['id_usuario']) && isset($_COOKIE['email']) && isset($_COOKIE['tipo_usuario'])) {
   $_SESSION['id_usuario'] = $_COOKIE['id_usuario'];
   $_SESSION['email'] = $_COOKIE['email'];
   $_SESSION['tipo_usuario'] = $_COOKIE['tipo_usuario'];
 }
}
  
$title = 'Perfil';
$perfil = 'class="active"';

require_once('header.php');

?>

<section class='container text-center'>
    
    <div class="center">        
        <h2>Página de Perfil</h2>
        <p class="lead">Este es su perfil.</p>
    </div>

<?php
switch ($_SESSION['id_tipo_usuario']) {
    case 1: /*------------- Perfil del Admninistrador --------------------------*/
        echo 'Datos del Administrador!';
        ?>
        <div class="center">        
            <h2>Datos del Administrador</h2>
            <p class="lead">Aquí se pueden actualizar los datos.</p>
        </div>
        <?php
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error al intentar conexion con el servidor MySQL!');

        $query10 = "SELECT * FROM Administrador WHERE id_usuario = $_SESSION[id_usuario]";
        $result10 = mysqli_query($dbc, $query10)
            or die('Error al hacer query10 en la base de datos!');  
        $row = mysqli_fetch_array($result10);
        $nombre_administrador = $row['nombre_administrador'];  
        $apellido_administrador = $row['apellido_administrador'];
        $direccion = $row['direccion'];
        $ciudad = $row['ciudad'];
        $id_provincia = $row['id_provincia'];        
        if (isset($_POST['actualizaradministrador'])) {
            $nombre_administrador = $_POST['nombreadministrador'];
            $apellido_administrador = $_POST['apellidoadministrador'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $id_provincia = $_POST['provincia1']; 
            
            $query1 = "UPDATE Administrador "
                    . "SET nombre_administrador = '$nombre_administrador', apellido_administrador = '$apellido_administrador', direccion = '$direccion', "
                    . "ciudad = '$ciudad', id_provincia = $id_provincia  "
                    . "WHERE id_usuario = $_SESSION[id_usuario]";
            $result1 = mysqli_query($dbc, $query1)
            or die('Error al hacer query1 en la base de datos!');
            echo 'La cuenta fue actualizada exitosamente!';            
            
        }
    
        ?>
    
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div>
                <div>
                    <label style="width:80px;display:inline-block;text-align: left;">Nombre *</label>
                    <input type="text" name="nombreadministrador" value="<?php print $nombre_administrador ?>">
                </div>
                <div>
                    <label style="width:80px;display:inline-block;text-align: left;">Apellido *</label>
                    <input type="text" name="apellidoadministrador" value="<?php print $apellido_administrador ?>">
                </div>
                <div>
                    <label style="width:80px;display:inline-block;text-align: left;">Dirección</label>
                    <input type="text" name="direccion" value="<?php print $direccion ?>">
                </div> 
                <div>
                    <label style="width:80px;display:inline-block;text-align: left;">Ciudad</label>
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
                    <label style="width:80px;display:inline-block;text-align: left;"></label>
                    <button type="submit" name="actualizaradministrador" class="btn btn-primary btn-lg">Actualizar Cuenta</button><br/>
                </div>

            </div>
        </form> 
        <?php
    break;
    case 2: /*------------- Perfil de la Organización --------------------------*/
        echo 'Datos de la Organizacion!';?>
        <div class="center">        
            <h2>Datos de la Organización</h2>
            <p class="lead">Aquí se pueden actualizar los datos.</p>
        </div>
        <?php
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error al intentar conexión con el servidor MySQL!');
        
        $query5 = "SELECT * FROM Organizacion WHERE id_usuario = $_SESSION[id_usuario]";
        $result5 = mysqli_query($dbc, $query5)
            or die('Error al hacer query5 en la base de datos!');
        $row = mysqli_fetch_array($result5);
        $nombre_organizacion = $row['nombre_organizacion'];  
        $rnc = $row['rnc'];
        $direccion = $row['direccion'];
        $ciudad = $row['ciudad'];
        $id_provincia = $row['id_provincia'];
        $donacion = $row['requiere_donacion'];
        
        if (isset($_POST['actualizarorganizacion'])) {
            $nombre_organizacion = $_POST['nombreorganizacion'];
            $rnc = $_POST['rnc'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $id_provincia = $_POST['provincia1'];
            $donacion = $_POST['donacion'];
            
            $query1 = "UPDATE Organizacion "
                    . "SET nombre_organizacion = '$nombre_organizacion', rnc = '$rnc', direccion = '$direccion', "
                    . "ciudad = '$ciudad', id_provincia = $id_provincia, requiere_donacion = '$donacion'  "
                    . "WHERE id_usuario = $_SESSION[id_usuario]";
            $result1 = mysqli_query($dbc, $query1)
            or die('Error al hacer query1 en la base de datos!');
            echo 'La cuenta fue actualizada exitosamente!';
        }
        ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <label style="width:200px;display:inline-block;text-align: left;">Nombre de la Organización *</label>
            <input type="text" name="nombreorganizacion" value="<?php print $nombre_organizacion ?>">
        </div>
        <div>
            <label style="width:200px;display:inline-block;text-align: left;">RNC *</label>
           <input type="text" name="rnc" value="<?php print $rnc ?>">
        </div>
        <div>
            <label style="width:200px;display:inline-block;text-align: left;">Dirección</label>
            <input type="text" name="direccion" value="<?php print $direccion ?>">
        </div>
        <div>
            <label style="width:200px;display:inline-block;text-align: left;">Ciudad</label>
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
        <?php
        if ($donacion == 'si') {
            ?>
            <div>
                <label style="width:200px;display:inline-block;text-align: left;" for="donacion">Requerir Donación: </label>
                Sí <input name="donacion" type="radio" value="si" checked/>
                No <input name="donacion" type="radio" value="no" /><br />
            </div>
            <?php
        } else {
            ?>
            <div>
                <label style="width:200px;display:inline-block;text-align: left;" for="donacion">Requerir Donación: </label>
                Sí <input name="donacion" type="radio" value="si" />
                No <input name="donacion" type="radio" value="no" checked/><br />
            </div>
            <?php
        }
        ?>
        <div>
            <label style="width:80px;display:inline-block;text-align: left;"></label>
            <button type="submit" name="actualizarorganizacion" class="btn btn-primary btn-lg">Actualizar Cuenta</button><br/>
        </div>   
    </form>
   
    <div class="center">   
        <br/>
        <h2>Donaciones Recibidas</h2>
        <p class="lead">Aquí se muestra la lista de las donaciones.</p>
    </div>
    
    
    
        <?php 
        $dbc3 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Error al intentar conexion con el servidor MySQL!');

        $query3 = "SELECT * FROM Donacion WHERE id_organizacion = $_SESSION[id_organizacion]";
        $result3 = mysqli_query($dbc3, $query3)
        or die('Error al hacer query3 en la base de datos!');

        echo "<table border='1' class='container text-center'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>monto</th>
        </tr>";
        while ($row = mysqli_fetch_array($result3)) {
        echo "<tr>";
            echo "<td>" . $row['id_donacion'] . "</td>";
            echo "<td>" . $row['nombre_completo'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['monto'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";

        $query3 = "SELECT SUM(monto) as total FROM Donacion WHERE id_organizacion = $_SESSION[id_organizacion]";
        $result3 = mysqli_query($dbc3, $query3)
        or die('Error al hacer query3 en la base de datos!');

        echo "<table border='1' class='container text-center'>
        <tr>

            <th style='text-align:center'>Total de Donaciones</th>
        </tr>";
        while ($row = mysqli_fetch_array($result3)) {
        echo "<tr>";

            echo "<td>" . $row['total'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";        
        
        
        mysqli_close($dbc3);        
        
        break;
    case 3: /*---------------- Perfil del Voluntario ---------------------------*/
        echo 'Datos del Voluntario!';
        ?>
        <div class="center">        
            <h2>Datos del Voluntario</h2>
            <p class="lead">Aquí se pueden actualizar los datos.</p>
        </div>  
    
        <?php 
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error al intentar conexión con el servidor MySQL!');
        
        $query = "SELECT * FROM Voluntario WHERE id_usuario = $_SESSION[id_usuario]";
        $result = mysqli_query($dbc, $query)
            or die('Error al hacer query en la base de datos!');
        $row = mysqli_fetch_array($result);
        $primer_nombre = $row['primer_nombre'];
        $primer_apellido = $row['primer_apellido'];
        $direccion = $row['direccion'];
        $ciudad = $row['ciudad'];
        $id_provincia = $row['id_provincia'];
      
        
        if (isset($_POST['actualizarvoluntario'])) {
            $primernombre = $_POST['primernombre'];
            $primerapellido = $_POST['primerapellido'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $id_provincia = $_POST['provincia1'];   
            
            $query1 = "UPDATE Voluntario "
                    . "SET primer_nombre = '$primernombre', primer_apellido = '$primerapellido', direccion = '$direccion', "
                    . "ciudad = '$ciudad', id_provincia = '$id_provincia'  "
                    . "WHERE id_usuario = $_SESSION[id_usuario]";
            $result1 = mysqli_query($dbc, $query1)
            or die('Error al hacer query1 en la base de datos!');
            echo 'La cuenta fue actualizada exitosamente!';
            
        }
        ?>    
    
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div>
                <div>
                    <label style="width:130px;display:inline-block;text-align: left;">Nombre *</label>
                    <input type="text" name="primernombre" value="<?php print $primer_nombre ?>">

                </div>
                <div>
                    <label  style="width:130px;display:inline-block;text-align: left;">Segundo Nombre:</label>
                    <input type="text" name="segundonombre" value="<?php if (isset($segundo_nombre)) {echo $segundo_nombre;} ?>" />                   
                </div>
                <div>
                    <label style="width:130px;display:inline-block;text-align: left;">Apellido *</label>
                    <input type="text" name="primerapellido" value="<?php print $primer_apellido ?>"/>
                </div>
                <div>
                    <label style="width:130px;display:inline-block;text-align: left;">Dirección</label>
                    <input type="text" name="direccion" value="<?php print $direccion ?>"/>
                </div> 
                <div>
                    <label style="width:130px;display:inline-block;text-align: left;">Ciudad</label>
                    <input type="text" name="ciudad" value="<?php print $ciudad ?>"/>
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
                    <label style="width:80px;display:inline-block;text-align: left;"></label>
                    <button class="btn btn-primary" type="submit" name="actualizarvoluntario">Actualizar Cuenta</button><br/>
                </div>

            </div>
        </form> 

        <div class="center">        
            <h2>Eventos en Proceso de Aprobación</h2>
            <p class="lead">Aquí se pueden ver los eventos en proceso de aprobación.</p>
        </div>    
    
        <?php 
        $query2 = "SELECT vol.*, tve.*, ev.*, org.nombre_organizacion FROM Voluntario vol, Temp_Voluntario_Evento tve, Evento ev, Organizacion org "
                . "WHERE vol.id_voluntario = tve.id_voluntario AND tve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion";
        $result2 = mysqli_query($dbc, $query2)
        or die('Error al hacer query2 en la base de datos!');

        echo "<table border='1' class='container text-center'>
        <tr>

            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Organizacion</th>
            <th>Nombre Lugar</th>
            <th>Provincia</th>
        </tr>";
        while ($row = mysqli_fetch_array($result2)) {
        echo "<tr>";

            $id_evento = $row['id_evento'];
            echo "<td>" . $row['id_evento'] . "</td>";
            $nombre_evento = $row['nombre_evento'];
            echo "<td>" . $row['nombre_evento'] . "</td>";
            $nombre_organizacion = $row['nombre_organizacion'];
            echo "<td>" . $row['nombre_organizacion'] . "</td>";
            $nombre_lugar = $row['nombre_lugar'];
            echo "<td>" . $row['nombre_lugar'] . "</td>";
            
        echo "</tr>";
        }
        echo "</table>";        
        
        ?>
    
        <div class="center">        
            <h2>Historial de Voluntarios</h2>
            <p class="lead">Aquí se puede ver el historial de los voluntarios.</p>
        </div>

        <?php
        

        $query2 = "SELECT vol.*, ve.*, ev.*, org.nombre_organizacion FROM Voluntario vol, Voluntario_Evento ve, Evento ev, Organizacion org "
                . "WHERE vol.id_voluntario = ve.id_voluntario AND ve.id_evento = ev.id_evento AND ev.id_organizacion = org.id_organizacion";
        $result2 = mysqli_query($dbc, $query2)
        or die('Error al hacer query2 en la base de datos!');

        echo "<table border='1' class='container text-center'>
        <tr>
            <th>ID</th>
            <th>Nombre Evento</th>
            <th>Organizacion</th>
            <th>Nombre Lugar</th>
            <th>Provincia</th>
        </tr>";
        while ($row = mysqli_fetch_array($result2)) {
        echo "<tr>";
            $id_evento = $row['id_evento'];
            echo "<td>" . $row['id_evento'] . "</td>";
            $nombre_evento = $row['nombre_evento'];
            echo "<td>" . $row['nombre_evento'] . "</td>";
            $nombre_organizacion = $row['nombre_organizacion'];
            echo "<td>" . $row['nombre_organizacion'] . "</td>";
            $nombre_lugar = $row['nombre_lugar'];
            echo "<td>" . $row['nombre_lugar'] . "</td>";
            
        echo "</tr>";
        }
        echo "</table>";

	
	?>
   
        <?php
        break;
    default:
        echo 'No estas logeado!';
        include 'perfil_organizacion.php';
        break;
}

?>
</section><!--/#error-->

<?php
mysqli_close($dbc);
require_once('footer.php');
