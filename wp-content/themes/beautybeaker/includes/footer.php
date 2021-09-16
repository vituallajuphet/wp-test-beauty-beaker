<!-- s -->
<div id="footer">
            <div class="ftr_top">
                <div class="wrapper">
                    <div class="ftrtop_cont">
                        <div class="row-cont">
                            <div class="ftrlogo">
                                <a href="<?= get_home_url()?>"><img src="<?php bloginfo('template_url');?>/images/main_logo.png" alt="logo"></a>
                            </div>
                        </div>
                        <div class="row-cont">
                            <h3>
                                Useful links
                            </h3>
                            <div class="ftr_links">
                                <ul>
                                   <?php wp_nav_menu( array( 'theme_location' => 'secondary') ); ?> 
                                </ul>
                            </div>
                        </div>
                        <div class="row-cont">
                            <h3>
                                Follow Us
                            </h3>
                            <div class="ftr_links social_lnks">
                                <a target="_blank" href="https://www.facebook.com"><img src="<?php bloginfo('template_url');?>/images/icons/fb.jpg" alt="facebook"></a>
                                <a target="_blank" href="https://www.twitter.com"><img src="<?php bloginfo('template_url');?>/images/icons/twit.jpg" alt="twitter"></a>
                                <a target="_blank" href="https://www.pinterest.com"><img src="<?php bloginfo('template_url');?>/images/icons/pinterest.jpg" alt="pinterest"></a>
                                <a target="_blank" href="https://www.instagram.com"><img src="<?php bloginfo('template_url');?>/images/icons/insta.jpg" alt="instagram"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ftr_btm">
                <div class="wrapper">
                    Copyright © 2020 Beauty Beaker. All rights reserved. Terms of Use | Privacy Policy
                </div>
            </div>
            </div>
        </div>
<!-- e -->
    </div>
    <script src='<?php bloginfo('template_url');?>/js/jquery.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script src='<?php bloginfo('template_url');?>/js/rslider.js'></script>
    <script src='<?php bloginfo('template_url');?>/js/css3-animate-it.js'></script>
    <script src='<?php bloginfo('template_url');?>/js/app.js'></script>
    <script src='<?php bloginfo('template_url');?>/js/checkout.js'></script>
    <?php wp_footer(); ?>

    <!-- DEVELOPED BY: JUPHET VITUALLA -->
</body>
</html>