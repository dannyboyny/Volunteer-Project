<?php
$title = 'Login';
$login = 'class="active"';

require_once('header.php');
?>
<!-- Container Principal -->
<section class="container text-center">

<?php
// Borrar el mensaje de error.
$error_msg = "";

// Si el usuario no esta autenticado intentar de hacer la autenticación.
if (!isset($_SESSION['id_usuario'])) {
    if (isset($_POST['submit'])) {
        // Conectarse a la base de datos.
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Guardar el email y la contraseña.
        $email_user = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $clave_user = mysqli_real_escape_string($dbc, trim($_POST['clave']));

        if (!empty($email_user) && !empty($clave_user)) {
            // Verificar el email y la contraseña en la base de datos.
            $query = "SELECT id_usuario, email, id_tipo_usuario FROM Usuario WHERE email = '$email_user' AND clave = SHA('$clave_user')";
            //$query = "SELECT id_usuario, email, id_tipo_usuario FROM Usuario WHERE email = '$email_user' AND clave = '$clave_user'";
            $result = mysqli_query($dbc, $query);

            if (mysqli_num_rows($result) == 1) {
                // El email y la contraseña estan verificados.
                $row = mysqli_fetch_array($result);
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['id_tipo_usuario'] = $row['id_tipo_usuario'];
                
                setcookie('id_usuario', $row['id_usuario'], time() + (60 * 60 * 24 * 30));    // Se expira en 30 días.
                setcookie('email', $row['email'], time() + (60 * 60 * 24 * 30));  // Se expira en 30 días.
                setcookie('id_tipo_usuario', $row['id_tipo_usuario'], time() + (60 * 60 * 24 * 30));  // Se expira en 30 días.

                if ($_SESSION['id_tipo_usuario'] == 2) {
                    $query2 = "SELECT id_organizacion from Organizacion WHERE id_usuario = $_SESSION[id_usuario]";
                    $result2 = mysqli_query($dbc, $query2);
                    $row2 = mysqli_fetch_array($result2);
                    $_SESSION['id_organizacion'] = $row2['id_organizacion'];
                }
                
                $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                header('Location: ' . $home_url);                
            }
            else {
              $error_msg = 'El email o la contraseña no es valido!';
            }
        }
        else {
            $error_msg = 'Debes digitar su email y contraseña!';
        }
    }
}

// Si la sesión esta vacía entonces mostar un error y el form de Log in.
if (empty($_SESSION['id_usuario'])) {
    echo '<p class="error">' . $error_msg . '</p>';

?>
    <div class="center"> 
        <h1>Página de Login</h1>
        <h2>Iniciar la Sesión</h2>
        <p class="lead">Por favor ingrese su email y contraseña para iniciar su sesión.</p>
    </div> 
    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type='hidden' name='submitted' id='1'/>
        <div >
            <label style="width:100px;display:inline-block;text-align: right;">Email *</label>
            <input type="email" name="email" >
        </div>
        <div>
            <label style="width:100px;display:inline-block;text-align: right;">Contraseña *</label>
            <input  type="password" name="clave" >
        </div>
        <div>
            <button class="btn btn-primary" type="submit" name="submit" >Iniciar Sesión</button>
        </div>
    </form>
<?php
}
else {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $home_url);
    // Confirmar que está autenticado.
    ?>
    <div class="center"> 
        <h1>Página de Login</h1>
        <h2>Sesión iniciada correctamente!</h2>
        <p class="lead">Estas logeado!</p>
        <a class="btn btn-primary" href="index.php">Ir a la página de Inicio</a>
    </div> 
    <?php
    //echo 'Estas logeado!';
    echo('<div id="login"><p class="login"><a href="perfil.php">Ver perfil de </a> ' . $_SESSION['email'] . '.</p>');
    echo ('<a href="logout.php">Logout</a></div>');
    /*
    echo ($_SESSION['id_tipo_usuario'] . ' ' . '<a href="logout.php">Logout</a></div>');
    echo ($_SESSION['id_usuario'] . ' ' . 'id de usuario<br />');     
    if ($_SESSION['id_tipo_usuario'] == 2) {
        echo $_SESSION['id_organizacion'];
    }
     */
}
?>
    
</section>

<?php
require_once('footer.php');
