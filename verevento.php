<?php
$title = 'Ver Evento';

require_once('header.php');
?>

<section id="error" class="container text-center">
    <h1>Página de Ver Eventos</h1>
    <p>Esta es la página de ver detalles de un evento de voluntarios.</p>
    <a class="btn btn-primary" href="eventos.php">Regresar a Eventos</a><br />

<?php
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
    $query = "SELECT * FROM Evento WHERE id_evento = $_GET[id_evento]";    
    $result = mysqli_query($dbc, $query)
        or die('Error al hacer query en la base de datos!');
    
    $row = mysqli_fetch_array($result);
    $nombre_evento = $row['nombre_evento'];
    $nombre_lugar = $row['nombre_lugar'];
    $provincia = $row['provincia'];
    $direccion = $row['direccion'];
    
    // Registrar el voluntario.
    if (isset($_GET['registrar'])) {
        $query1 = "SELECT * FROM Voluntario WHERE id_usuario = $_SESSION[id_usuario]";
        $result1 = mysqli_query($dbc, $query1)
                or die('Error al hacer query1 en la base de datos!');
        $row = mysqli_fetch_array($result1);
        $id_voluntario = $row['id_voluntario'];
        
        $query2 = "SELECT * from Voluntario_Evento where id_voluntario = $id_voluntario AND id_evento = $_GET[id_evento]";
        $result2 = mysqli_query($dbc, $query2)
                or die('Error al hacer query2 en la base de datos!');
        
        $query3 = "SELECT * from Temp_Voluntario_Evento where id_voluntario = $id_voluntario AND id_evento = $_GET[id_evento]";
        $result3 = mysqli_query($dbc, $query3)
                or die('Error al hacer query3 en la base de datos!');        
        
        if (mysqli_fetch_array($result2)) {
            echo '<p class="errormessage">Ya estas registrado en este evento!<p><br/>';
        }
        else if(mysqli_fetch_array($result3)){
            echo '<p class="errormessage">Ya estas registrado en este evento!<p><br/>';
        }
        else {
            $query4 = "INSERT INTO Temp_Voluntario_Evento (id_voluntario, id_evento) " .
                            "VALUES($id_voluntario, $_GET[id_evento])";
            $result4 = mysqli_query($dbc, $query4)
                    or die('Error al hacer query4 en la base de datos!');

            echo '<p class="okmessage" >Listo! Estas registrado en el evento! </p><br />';             
        }
    }
    
?>                   
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <div>
                <label style="width:150px;display:inline-block;text-align:right;">Nombre del Evento: </label>
                <label><?php print $nombre_evento ?></label>
            </div>
            <div>
                <label style="width:150px;display:inline-block;text-align:right;">Nombre Lugar: </label>
                <label><?php print $nombre_lugar ?></label>
            </div>
            <div>
                <label style="width:150px;display:inline-block;text-align:right;">Provincia: </label>
                <label><?php print $provincia ?></label>
            </div> 
            <div>
                <label style="width:150px;display:inline-block;text-align:right;">Dirección: </label>
                <label><?php print $direccion ?></label>
            </div>

        </div>
    </form>      
<!--<div class="fb-share-button" data-href="http://proyectovoluntariado.azurewebsites.net/index.php/verevento.php?id_evento=<?php print $_GET[id_evento]?>&editar=Editar+Evento" data-layout="icon_link"></div>-->
<div class="fb-send" data-href="http://proyectovoluntariado.azurewebsites.net/index.php/verevento.php?id_evento=<?php print $_GET[id_evento] ?>&editar=Editar+Evento" data-colorscheme="light"></div>
  
<?php
if($_SESSION['id_tipo_usuario'] == 3){
?>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <br />
        <input type="hidden" name="id_evento" value="<?php echo $_GET[id_evento] ?>"/>
        <button class="btn btn-primary" type="submit" name="registrar">Registrarse</button>
    </form>
<?php

}
?>

</section><!--/#error-->
<section id="contact-info">
    <h1>Mapa del Evento</h1>
        <div class="gmap-area">
            <div class="container">
                <div class="row">
                     <div class="col-sm-5 text-center">
                        <div class="gmap">
                            <!--
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=JoomShaper,+Dhaka,+Dhaka+Division,+Bangladesh&amp;aq=0&amp;oq=joomshaper&amp;sll=37.0625,-95.677068&amp;sspn=42.766543,80.332031&amp;ie=UTF8&amp;hq=JoomShaper,&amp;hnear=Dhaka,+Dhaka+Division,+Bangladesh&amp;ll=23.73854,90.385504&amp;spn=0.001515,0.002452&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=1073661719450182870&amp;output=embed"></iframe>
                            -->
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.googleapis.com/maps/api/staticmap?center=40.714728,-73.998672&zoom=12&size=400x400"></iframe>
                            
                        </div>
                     </div>
                    <div class="col-sm-7 map-content">
                        <ul class="row">
                            <li class="col-sm-6">
                                <address>
                                    <h5>Nombre del Evento: <?php print $nombre_evento ?></h5>
                                    <p>Nombre del Lugar: <?php print $nombre_lugar ?><br>
                                    Provincia: <?php print $provincia ?><br/>
                                    Dirección: <?php print $direccion ?></p>
                                    <p>Teléfono:809-898-2847 <br>
                                    <!-- Email : <?php print $_SESSION['email'] ?>--></p>
                                </address>
                            </li>
                        </ul>
                    </div>
               </div>
            </div>
        </div>   

</section><!--/mapa-->
    
<?php
require_once('footer.php');