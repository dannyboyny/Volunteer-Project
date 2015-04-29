<?php
$title = 'Organizaciones';
$organizaciones = 'class="active"';

require_once('header.php');
if ($_SESSION['id_tipo_usuario'] == 1) {
    ?>
    <section id="error" class="container text-center">

    <h1>Verificación de Organizaciones</h1>
    <p class="lead">Aquí se puede verificar la cuenta de una organización.</p>
    
    <?php
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
    
    // Verificar la organización.
    if (isset($_POST['aprobar'])) {	
        $id_temp_organizacion = $_POST['id_temp_organizacion'];
        $query5 = "SELECT * FROM Temp_Organizacion WHERE id_temp_organizacion = $id_temp_organizacion";
        $result5 = mysqli_query($dbc, $query5)
        or die('Error al hacer query5 en la base de datos!');           
        $row =  mysqli_fetch_array($result5);
        $email = $row['email'];
        $clave = $row['clave'];
        $rnc = $row['rnc'];
        $nombre_organizacion = $row['nombre_organizacion'];

        $query = "INSERT INTO Usuario (email, clave, id_tipo_usuario, fecha_usuario_creado) " .
                        "VALUES('$email', '$clave', 2, NOW())";
        mysqli_query($dbc, $query)
                or die('Error al hacer query en la base de datos!');

        $id_usuario = mysqli_insert_id($dbc);

        $query1 = "INSERT INTO Organizacion (id_usuario, rnc, nombre_organizacion) " .
                    "VALUES('$id_usuario', '$rnc','$nombre_organizacion')";
        $result1 = mysqli_query($dbc, $query1)
                or die('Error al hacer query1 en la base de datos!');

        $query6 = "DELETE FROM Temp_Organizacion WHERE id_temp_organizacion = $id_temp_organizacion";
        mysqli_query($dbc, $query6)
        or die('Error al hacer query6 en la base de datos!');

        echo 'Listo! Verificación fue exitosa! <br />';
     }

    // Rechazar la organización.
    if (isset($_POST['rechazar'])) {
        $id_temp_organizacion = $_POST['id_temp_organizacion'];
        $query7 = "DELETE FROM Temp_Organizacion WHERE id_temp_organizacion = $id_temp_organizacion";
        mysqli_query($dbc, $query7)
        or die('Error al hacer query7 en la base de datos!');   
        echo 'La organización fue rechazada!';
    }         

     // Desplegar la lista de Organizaciones Temporales para aprobar.
    $query2 = "SELECT * FROM Temp_Organizacion";
    $result2 = mysqli_query($dbc, $query2)
    or die('Error al hacer query2 en la base de datos!');

    echo "<table border='1' class='container text-center'>
    <tr>
        <th>ID</th>
        <th>Nombre Organización</th>
        <th>RNC</th>
        <th>Email</th>
        <th>Opciones</th>
    </tr>";
    while ($row = mysqli_fetch_array($result2)) {
    echo "<tr>";
        $id_temp_organizacion = $row['id_temp_organizacion'];
        echo "<td>" . $row['id_temp_organizacion'] . "</td>";
        $nombre_organizacion = $row['nombre_organizacion'];
        echo "<td>" . $row['nombre_organizacion'] . "</td>";
        $rnc = $row['rnc'];
        echo "<td>" . $row['rnc'] . "</td>";
        $email = $row['email'];
        echo "<td>" . $row['email'] . "</td>";
        $clave = $row['clave'];
        echo "<td>";

        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input  type="hidden" name="id_temp_organizacion" value="<?php echo $row['id_temp_organizacion']?>"/>
            <input class='btn-accept' type='submit' name='aprobar' value='' />
            <input class='btn-rechazar' type='submit' name='rechazar' value='' />
        </form>
         <?php    
        echo "</td>";


    echo "</tr>";
    }
    echo "</table>";

    mysqli_close($dbc);
    ?>
    
                           
    </section><!--/#error-->
    <?php
}
?>

<section id="error" class="container text-center"> <!-- Lista de Organizaciones -->
    <h1>Página de Organizaciones</h1>
    <p>Esta es la página de Organizaciones.</p>
        
        
<?php
$dbc3 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
or die('Error al intentar conexion con el servidor MySQL!');

$query3 = "SELECT * FROM Organizacion";
$result3 = mysqli_query($dbc3, $query3)
or die('Error al hacer query3 en la base de datos!');

echo "<table border='1' class='container text-center'>
<tr>
    <th>ID</th>
    <th>Nombre Organización</th>
    <th>Tipo Organización</th>
    <th>Dirección</th>
    <th>Ciudad</th>
    <th>Provincia</th>
    <th>Codigo Postal</th>
</tr>";
while ($row = mysqli_fetch_array($result3)) {
echo "<tr>";
    echo "<td>" . $row['id_organizacion'] . "</td>";
    echo "<td>" . $row['nombre_organizacion'] . "</td>";
    echo "<td>" . $row['tipo_organizacion'] . "</td>";
    echo "<td>" . $row['direccion'] . "</td>";
    echo "<td>" . $row['ciudad'] . "</td>";
    echo "<td>" . $row['provincia'] . "</td>";
    echo "<td>" . $row['codigo_postal'] . "</td>";
echo "</tr>";
}
echo "</table>";

        $query9 = "SELECT Count(id_organizacion) AS total FROM Organizacion";
        $result9 = mysqli_query($dbc3, $query9)
        or die('Error al hacer query9 en la base de datos!');

        echo "<table border='1' class='container text-center'>
        <tr>

            <th style='text-align:center'>Total de Organizaciones</th>
        </tr>";
        while ($row = mysqli_fetch_array($result9)) {
        echo "<tr>";

            echo "<td>" . $row['total'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";

mysqli_close($dbc3);

?>        
               
</section><!--/# Lista de Organizaciones -->
    
<?php
require_once('footer.php');
?>