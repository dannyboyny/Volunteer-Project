<?php
session_start();
// Borrar el mensaje de error.
$error_msg = "";
$selected = 'selected="selected"';
require_once('conexion.php');
//require_once('conexionAzure.php');

// Asignar los valores de la sesión si no tienen valores asignado usando un cookie.
if (!isset($_SESSION['id_usuario'])) {
    if (isset($_COOKIE['id_usuario']) && isset($_COOKIE['email']) && isset($_COOKIE['id_tipo_usuario'])) {
        $_SESSION['id_usuario'] = $_COOKIE['id_usuario'];
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['id_tipo_usuario'] = $_COOKIE['id_tipo_usuario'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta charset="utf-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php print $title ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

    <?php
    if ($title == 'Organizaciones123') {
        ?>
 <!--       <script type="text/javascript">
        function mostrareventos (str) {
          if (str=="") {
            /*document.getElementById('listado').innerHTML="";
            return; */
            xmlhttp.open("GET", "getuser.php?org=0",true);
            xmlhttp.send();
          }
          if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
          }else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }

          xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
              document.getElementById("listado").innerHTML=xmlhttp.responseText;
            }
          }
          xmlhttp.open("GET", "getevento.php?org="+str,true);
          xmlhttp.send();
        }
        </script>  -->

        <?php
    }
    ?>
</head><!--/head-->
<body>

    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-4">
                        <div class="top-number"><p><i class="fa fa-phone-square"></i>  809 200 1234</p></div>
                    </div>
                    <div class="col-sm-6 col-xs-8">
                       <div class="social">
                            <ul class="social-share">
                                <li><a href="https://es-la.facebook.com/pages/Cruz-Roja-Dominicana/139587719453563"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/crdominicana"><i class="fa fa-twitter"></i></a></li>
                                <!--
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li> 
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                                -->
                            </ul>
                            <div class="search">
                                <form role="form">
                                    <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                    <i class="fa fa-search"></i>
                                </form>
                           </div>
                       </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="images/voluntario.png" alt="logo"></a>
                </div>
                
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li <?php print $index ?> ><a href="index.php">Inicio</a></li>
                        <li <?php print $eventos ?> ><a href="eventos.php">Eventos</a></li>
                        <?php
                        if ($_SESSION['id_tipo_usuario'] == 2) { ?>
                        <li <?php print $miseventos ?> ><a href="miseventos.php">Mis Eventos</a></li>
                        <!-- <li <?php print $aprobacion ?> ><a href="aprobacion.php">Aprobaciones</a></li> -->
                        <?php 
                        
                        } ?>
                        <li <?php print $organizaciones ?> ><a href="organizaciones.php">Organizaciones</a></li>
                        <li <?php print $donaciones ?> ><a href="donar.php">Donaciones</a></li>

                        <?php 
                        if (!isset($_SESSION['id_usuario'])) { ?>
                            <li class="dropdown <?php print $dropdown  ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Crear Cuenta <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li <?php print $formvoluntario ?> ><a href="formvoluntario.php">Cuenta de Voluntario</a></li>
                                    <li <?php print $formorganizacion ?> ><a href="formorganizacion.php">Cuenta de Organización</a></li>
                                    <!-- <li <?php /*print $pagenotfound */?> ><a href="404.php">404</a></li> -->
                                </ul>
                            </li>
                            <li <?php print $login ?> ><a href="login.php">Entrar</a></li>
                        <?php
                        }
                        else { 
                            ?>
                            <li <?php print $perfil ?> ><a href="perfil.php">Perfil</a></li>
                            <li><a href="logout.php">Salir</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
        
    </header><!--/header-->