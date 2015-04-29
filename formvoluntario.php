<?php
$title = 'Form Voluntario';
$formvoluntario = 'class="active"';
$dropdown = 'active';

require_once('header.php');
?>

<section class="container text-center">
    <div class="center">        
        <h2>Formulario de voluntario.</h2>
        <p class="lead">Esta es una página para crear una cuenta de voluntario.</p>
    </div>
<?php
if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $clave1 = $_POST['clave1'];
    $clave2 = $_POST['clave2'];

    $output_form = false;

    if (empty($nombre)) {
            echo '<font color="red">*Debes digitar el nombre!</font><br />';
            $output_form = true;
    }
    if (empty($apellido)) {
            echo '<font color="red">*Debes digitar el apellido!</font><br />';
            $output_form = true;
    }        
    if (empty($email)) {
            echo '<font color="red">*Debes digitar un email!</font><br />';
            $output_form = true;
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Email es valido!<br />';
    }else {
            echo '<font color="red">*Email no es valido!</font><br />';
            $output_form = true;
    }


    if (empty($clave1)) {
            echo '<font color="red">*Debes digitar una clave!</font><br />';
            $output_form = true;
    }

    if (empty($clave2)) {
            echo '<font color="red">*Debes repetir la clave!</font><br />';
            $output_form = true;
    }

    if ($clave1 != $clave2) {
            echo '<font color="red">*La claves deben ser iguales!</font><br />';
            $output_form = true;
    }

}
else {
        $output_form = true;
}

$tipo_usuario = 'Voluntario';


if ((!empty($email)) && (!empty($clave1)) && (!empty($clave2)) && ($clave1 == $clave2) && (!empty($nombre))) {
    $dbc1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Error al intentar conexion con el servidor MySQL!');

    //Verificar que el email es único!
    $query1 = "SELECT * FROM Usuario WHERE email = '$email'";
    $result1 = mysqli_query($dbc1, $query1);
    if (mysqli_num_rows($result1) == 0) {
        $query1 = "INSERT INTO Usuario (email, clave, fecha_usuario_creado, id_tipo_usuario) " .
            "VALUES('$email', SHA('$clave1'), NOW(), 3)";
            //"VALUES('$email', '$clave1', '$tipo_usuario')";

        $result1 = mysqli_query($dbc1, $query1)
            or die('Error al hacer query1 en la base de datos!');
        $id_usuario = mysqli_insert_id($dbc1);

        echo 'Usuario Creado! <br />';

        $query2 = "INSERT INTO Voluntario (id_usuario, primer_nombre, primer_apellido) " .
            "VALUES('$id_usuario', '$nombre', '$apellido')";

        $result2 = mysqli_query($dbc1, $query2)
            or die('Error al hacer query2 en la base de datos!');

        $id_voluntario = mysqli_insert_id($dbc1);

        echo 'Gracias ' . $nombre . ' por completar el formulario! <br />';

        mysqli_close($dbc1);
    }else{
        echo '<font color="red">Ya existe una cuenta con este email!</font>';
        $email = ""; //borrar este email del formulario.
    }
}

if ($output_form) {
?>       
    <div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div>
                <div>
                    <label style="width:150px;display:inline-block;text-align: left;">Nombre *</label>
                    <input type="text" name="nombre">
                </div>
                <div>
                    <label style="width:150px;display:inline-block;text-align: left;">Apellido *</label>
                    <input type="text" name="apellido">
                </div>
                <div>
                    <label style="width:150px;display:inline-block;text-align: left;">Email *</label>
                    <input type="email" name="email">
                </div>
                <div>
                    <label style="width:150px;display:inline-block;text-align: left;">Contraseña *</label>
                    <input type="password" name="clave1">
                </div>
                <div>
                    <label style="width:150px;display:inline-block;text-align: left;">Repetir Contraseña *</label>
                    <input type="password" name="clave2">
                </div>                         
                 <div>
                    <button class="btn btn-primary" type="submit" name="submit">Crear Cuenta</button>
                </div>

            </div>
        </form> 
    </div><!--/.row-->
<?php	
	}
?>
</section><!--/#form de voluntario-->

<?php

require_once('footer.php');
