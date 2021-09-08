<?php
@session_start();
get_includes('head');
get_includes('header');
get_includes('banner');
if(is_front_page()){
    get_includes('middle');
}
?>
<div id="main_area">
	<div class="wrapper">
		<div class="main_cont">
			<?php if(!is_front_page()){ ?>
				<div class="breadcrumbs">
				<?php
						if(function_exists('bcn_display'))
						{
							bcn_display();
						}?>
				</div>
			<?php } ?>
			<main>
				<?php if(is_front_page()){ ?>
					<?php get_includes('main_section'); ?>
			   <?php } ?>
			   <?php get_template_part('loop','page');?>
			</main>
		</div>
	</div>
</div>

<?php get_includes('footer'); ?>