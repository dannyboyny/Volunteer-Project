
    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Proyecto de Voluntariado</h3>
                        <ul>
                            <li><a href="#">Sobre nosotros</a></li>
                            <li><a href="#">Trabaje con nosotros</a></li>
                            <li><a href="#">El equipo</a></li>
                            <li><a href="#">Copyright</a></li>
                            <li><a href="#">Terminos de uso</a></li>
                            <li><a href="#">Política de Privacidad</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Soporte</h3>
                        <ul>
                            <li><a href="#">Preguntas Frequentes</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Forum</a></li>
                            <li><a href="#">Documentación</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Organizaciones</h3>
                        <ul>
                            <li><a href="http://www.cruzroja.org.do/">Cruz Roja</a></li>
                            <li><a href="#">Defensa Civil</a></li>
                            <li><a href="#">Bomberos</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Patrocinadores</h3>
                        <ul>
                            <li><a href="http://www.edessis.com/">Edessis</a></li>
                            <li><a href="#">Corasaan</a></li>
                            <li><a href="#">EdeNorte</a></li>
                            <li><a href="#">Claro</a></li>
                            <li><a href="#">PUCMM</a></li>
                            <li><a href="#">Grupo M</a></li>
                            <li><a href="#">Baldom</a></li>
                            <li><a href="#">Acero Estrella</a></li>
                        </ul>
                    </div>    
                </div><!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2014 <a target="_blank" href="index.php" title="Eventos sociales de voluntariado">Proyecto Voluntariado</a>. Todos los derechos reservados.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="eventos.php">Eventos</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
    
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    
    
    <script src="js/colResizable.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#selectall').click(function(event) {  //on click 
            if(this.checked) { // check select status
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
        });

    });
    </script>
    <script>
    $(document).ready(function(){
      $('.container text-center').colResizable();
    });
    </script>

    
    
</body>
</html>