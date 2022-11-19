
</main>



        <footer>

            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex flex-column">


                    <div class="footer-menu">
                         <!-- Dynamic Menu // Footer -->
                        <?php wp_nav_menu(array('menu' => 'footer')); ?>
                        
                    </div>
                   
               


                                <ul class="social-media">
                                    <li><a href="#"><i class="fa-brands fa-facebook-square"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                    <li><a href="'#"><i class="fa-brands fa-instagram"></i></a></li>

                                </ul>   
                                
                                <div class="credits">
                                        <?php wp_nav_menu(array('menu' => 'footer-down-menu')); ?>
                                </div>
                    </div>
                </div>
            </div>
        </footer>







        
        <?php //includeComponent('cookie', true); ?>

        <?php wp_footer(); ?>
    </body>
</html>