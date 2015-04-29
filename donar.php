<?php
$title = 'Donaciones';
$donaciones = 'class="active"';

require_once('header.php');
?>

<section id="contact-page">
    <div class="container">
        <div class="center">        
            <h2>Página de Donaciones</h2>
            <p class="lead">Esta es la página de donaciones a organizaciones sin fines de lucro.</p>
        </div> 
        
<?php  
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
if (isset($_POST['submit'])) {
    $id_organizacion = $_POST['organizacion'];
    $email = $_POST['email'];
    $nombre_completo = $_POST['nombrecompleto'];
    $tipo_tarjeta = $_POST['tipo_tarjeta'];
    $num_tarjeta = $_POST['num_tarjeta'];
    $fecha_expiracion = $_POST['fecha_expiracion'];
    $monto = $_POST['monto'];
    
    $output_form = false;

    if (empty($id_organizacion)) {
            echo '<font color="red">*Debes elegir el nombre de la organización en la lista!</font><br />';
            $output_form = true;
    }
    if (empty($email)) {
            echo '<font color="red">*Debes digitar su email!</font><br />';
            $output_form = true;
    }        
    if (empty($nombre_completo)) {
            echo '<font color="red">*Debes digitar su nombre completo!</font><br />';
            $output_form = true;
    }
    if (empty($tipo_tarjeta)) {
            echo '<font color="red">*Debes elegir el tipo de tarjeta!</font><br />';
            $output_form = true;
    }    
    if (empty($num_tarjeta)) {
            echo '<font color="red">*Debes digitar el número de la tarjeta!</font><br />';
            $output_form = true;
    } 
    if (empty($fecha_expiracion)) {
            echo '<font color="red">*Debes digitar la fecha de expiración!</font><br />';
            $output_form = true;
    }  
    if (empty($monto)) {
            echo '<font color="red">*Debes digitar el monto a donar!</font><br />';
            $output_form = true;
    } 
    if (!empty($id_organizacion) && !empty($email) && !empty($nombre_completo) && !empty($tipo_tarjeta) && !empty($num_tarjeta) && !empty($fecha_expiracion) && !empty($monto) ) {

        $query = "INSERT INTO Donacion (id_organizacion, email, nombre_completo, tipo_tarjeta, num_tarjeta, fecha_expiracion, monto) " .
            "VALUES($id_organizacion, '$email','$nombre_completo', '$tipo_tarjeta', '$num_tarjeta', '$fecha_expiracion', '$monto')";
        $result = mysqli_query($dbc, $query)
            or die('Error al hacer query en la base de datos!');

        echo 'La donación ha sido realizada';
 
    }
}
else {
    $output_form = true;
}

if ($output_form) {
?>
        
        <div> 
            <div class="status alert alert-success" style="display: none"></div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="col-sm-5 col-sm-offset-1">
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Nombre de la Organización *</label>
                        <?php
                        
                        $query1 = "SELECT * FROM Organizacion WHERE requiere_donacion = 'si'";
                        $result1 = mysqli_query($dbc, $query1)
                                or die('Error al hacer query1 en la base de datos!');
                        if (mysqli_num_rows($result1) !=0) {
                                echo '<select name="organizacion" id="organizacion">' .
                                         '<option value=" " selected="selected">Elegir Organización</option>';
                                        while ($organizacion = mysqli_fetch_array($result1)) {
                                                echo '<option value="' . $organizacion[id_organizacion] . ' ">' . $organizacion[nombre_organizacion] . '</option>';
                                        }
                                        echo '</select>';
                        }

                        ?>
                    </div>
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Email *</label>
                        <input type="email" name="email">
                    </div>
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Nombre del Donante *</label>
                        <input type="text" name="nombrecompleto">
                    </div>
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Tipo de Tarjeta *</label>
                        <select name="tipo_tarjeta">
			<option value="">Elegir Tipo de Tarjeta</option>
			<option value="Visa">Visa</option>
			<option value="Mastercard">Mastercard</option>
			<option value="American Express">American Express</option>
                        </select><br />
                    </div>                    
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Número de Tarjeta *</label>
                        <input type="text" name="num_tarjeta">
                    </div>
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Fecha de Expiración *</label>
                        <input type="text" name="fecha_expiracion">
                    </div> 
                    <div>
                        <label style="width:200px;display:inline-block;text-align: left;">Monto *</label>
                        <input type="text" name="monto" >
                    </div>                    
                     <div>
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Donar</button>
                    </div>

                </div>
            </form> 
        </div><!--/.row-->
    </div><!--/.container-->
    
<?php	
	}
?>     
    
</section><!--/#contact-page-->    

<?php
mysqli_close($dbc);
require_once('footer.php');