<div id="header_nav_cont">
    <div class="wrapper">
        <div class="hdr_cont">
            <header id="header">
                <div class="logo">
                    <a href="<?= get_home_url()?>"><img src="<?php bloginfo('template_url');?>/images/main_logo.png" alt="logo"></a>
                </div>
            </header>
            <nav class='main_nav'>
                <span class="mobileClose"><i class='fas fa-times'></i></span>
                <div class='nav-cart-cont'>
                    <ul>
                        <li><a href="<?= site_url()?>/register-2">Sign Up</a></li>
                        <?php  wp_nav_menu( array( 'container_class' => 'nav-menu', 'theme_location' => 'primary' )); ?> 
                        <li>
                            <a href="<?= site_url()?>/my-account"><i class='fas fa-user'></i> <?= is_user_logged_in() ? 'My Account' :'Login' ?></a>
                        </li>
                    </ul>
                    <div class='cart-cont'>
                        <a href="<?= site_url()?>/cart"><i class='fas fa-shopping-cart'></i> <span class='cart-num'><?= do_shortcode('[cart_count]')?></span></a>
                    </div>
                </div>
            </nav>
            <div class="mobileBar">
                <a href="#"><i class='fas fa-bars'></i></a>
            </div>
        </div>
    </div>
</div>