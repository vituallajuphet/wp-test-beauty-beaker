<div id="header_nav_cont">
    <div class="wrapper">
        <div class="hdr_cont">
            <header id="header">
                <div class="logo">
                    <a href="<?= get_home_url()?>"><img src="<?php bloginfo('template_url');?>/images/main_logo.png" alt="logo"></a>
                </div>
            </header>
            <nav class='main_nav'>
                <ul>
                     <?php  wp_nav_menu( array( 'container_class' => 'nav-menu', 'theme_location' => 'primary' )); ?> 
                </ul>
            </nav>
        </div>
    </div>
</div>