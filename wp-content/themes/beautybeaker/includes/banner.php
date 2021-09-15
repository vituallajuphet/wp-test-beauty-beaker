<div id="banner">
    <div class="wrapper">
        <div class="banner_cont animatedParent animateOnce">
           <?php if(is_front_page()) { ?>
            <figure>
                <img src="<?php bloginfo('template_url');?>/images/slide/slide1.png" alt="woman smiling">
            </figure>
            <div class="brn_info">
                <h2 class='animated fadeInUp'>The Best Things In Life Are FREE!</h2>
                <p class='animated fadeInUp delay-500'>Tell us what you think, <span>Get products for FREE!</span></p>
                <a class="btn_started" href="<?= site_url()?>/register-2">Get Started</a>
                <div class="bnr_btm">
                    Already registered? <a href="<?= site_url();?>/my-account" class="login-btn" >Login</a>
                </div>
            </div>
           <?php } else{ ?>
                <div class="non_home">
                    <figure>
                        <img src="<?php bloginfo('template_url');?>/images/non_home.jpg" alt="products">
                    </figure>
                </div> 
           <?php }?>
        </div>
    </div>
</div>