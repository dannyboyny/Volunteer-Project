<?php
$title = 'Crear Eventos';
$miseventos = 'class="active"';

require_once('header.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Error al intentar conexion con el servidor MySQL!');
?>

<section id="error" class="container text-center">
    <h1>Página de Crear Eventos</h1>
    <p>Esta es la página de crear eventos de voluntarios.</p>
    <a class="btn btn-primary" href="miseventos.php">Regresar a Mis Eventos</a><br />
        
<?php  

$output_form = true;
if (isset($_POST['submit'])) {
    $nombre_evento = $_POST['nombreevento'];
    $nombre_lugar = $_POST['nombrelugar'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $id_provincia = $_POST['provincia1'];
    $id_tipo_evento = $_POST['tipo_evento1'];
    $cant_voluntarios_solicitado = $_POST['cant_voluntarios_solicitado'];
    $descripcion = $_POST['descripcion'];
    
    $output_form = false;

    if (empty($nombre_evento)) {
            echo '<font color="red">*Debes digitar el nombre del evento!</font><br />';
            $output_form = true;
    }
    if (empty($nombre_lugar)) {
            echo '<font color="red">*Debes digitar el lugar del evento!</font><br />';
            $output_form = true;
    }        
    if (empty($id_tipo_evento)) {
            echo '<font color="red">*Debes seleccionar el tipo de evento!</font><br />';
            $output_form = true;
    }
}

if (!empty($nombre_evento) && !empty($nombre_lugar) && !empty($id_tipo_evento)) {

    echo $id_provincia;
    echo $direccion;
    
    $query = "INSERT INTO Evento (nombre_evento, id_organizacion, nombre_lugar, ciudad, direccion, id_provincia, id_tipo_evento, cant_voluntarios_solicitado, descripcion, fecha_evento_creado) " .
        "VALUES('$nombre_evento', $_SESSION[id_organizacion],'$nombre_lugar', '$ciudad', '$direccion', $id_provincia, $id_tipo_evento, '$cant_voluntarios_solicitado', '$descripcion', NOW())";
    $result = mysqli_query($dbc, $query)
        or die('Error al hacer query en la base de datos!');

    echo 'El evento ' . $nombre_evento . ' ha sido creado';

}

if ($output_form) {
?>      
<div> 
    <div style="display: none"></div>        
    <form name="contact-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <div>
                <label style="width:180px;display:inline-block;text-align: left;">Nombre del Evento *</label>
                <input type="text" name="nombreevento" value="<?php print $nombre_evento ?>">
            </div>
            <div>
                <label style="width:180px;display:inline-block;text-align: left;">Nombre Lugar *</label>
                <input type="text" name="nombrelugar" value="<?php print $nombre_lugar ?>">
            </div>
            <div>
                <label style="width:180px;display:inline-block;text-align: left;">Dirección</label>
                <input type="text" name="direccion" value="<?php print $direccion ?>">
            </div>
            <div>
                <label style="width:180px;display:inline-block;text-align: left;">Ciudad</label>
                <input type="text" name="ciudad" value="<?php print $ciudad ?>">
            </div>            
            <div>
         <?php   
	$query2 = "SELECT * FROM Provincia";
	$result2 = mysqli_query($dbc, $query2)
		or die('Error al hacer query2 en la base de datos!');

	if (mysqli_num_rows($result2) !=0) {
		echo '<label for="provincia1" style="width:180px;display:inline-block;text-align: left;">Provincia:</label>';
		echo '<select name="provincia1" id="provincia1">' .
			 '<option value="" selected="selected">provincia</option>';
			while ($provincia = mysqli_fetch_array($result2)) {
				echo '<option value="' . $id_provincia['id_provincia'] . ' ">' . $provincia['nombre_provincia'] . '</option>';
			}
			echo '</select> <br />';
	}            
        ?>  </div>
            <div>
            <?php
                $query3 = "SELECT * FROM Tipo_Evento";
                $result3 = mysqli_query($dbc, $query3)
                        or die('Error al hacer query3 en la base de datos!');

                if (mysqli_num_rows($result3) !=0) {
                        echo '<label for="tipo_evento1" style="width:180px;display:inline-block;text-align: left;">Tipo de Evento: *</label>';
                        echo '<select name="tipo_evento1" id="tipo_evento1">' .
                                 '<option value="" selected="selected">tipo de evento</option>';
                                while ($tipo_evento = mysqli_fetch_array($result3)) {
                                        echo '<option value="' . $tipo_evento['id_tipo_evento'] . ' ">' . $tipo_evento['nombre_tipo_evento'] . '</option>';
                                }
                                echo '</select> <br />';
                }            
            ?>        
            </div>
            <div>
                <label style="width:180px;display:inline-block;text-align: left;">Cantidad de Voluntarios</label>
                <input type="text" name="cant_voluntarios_solicitado" value="<?php print $cant_voluntarios_solicitado ?>">
            </div>
            <div>
                <label style="width:180px;display:inline-block;text-align: left;">Descripcion</label>
                <textarea name="descripcion" rows="8"><?php print $descripcion ?></textarea>
            </div>            
             <div>
                <button type="submit" name="submit" class="btn btn-primary btn-lg">Crear Evento</button>
            </div>

        </div>
    </form> 
</div>
<?php	
	}
?>       
        
</section><!--/#error-->
    
<?php
mysqli_close($dbc); 
require_once('footer.php');