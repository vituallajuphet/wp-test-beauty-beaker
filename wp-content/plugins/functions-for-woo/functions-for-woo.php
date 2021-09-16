<?php
/*
Plugin Name: Functionality Plugin for WooCommerce
Description: Additional functions for WooCommerce
Author: (Juphet Vitualla)
Version: 1.2
*/

/**********************************************************************/
if(!defined('ABSPATH')){
	return;
}

include_once (ABSPATH. 'wp-content/plugins/functions-for-woo/inc/ffw_admin.php');

// CONFIGURATION
global $settings;

global $setting_checkout;

define('DISPLAY_SALE_PERCENTAGE', $settings['sale_tag']); //Hide WooCommerce Page title

define('SALE_TAG_TEXT', $settings['sale_text']); //Sale Tag Text

define('CATEGORY_DISPLAY', $settings['enable_category_list']); //Display Product Categories

define('QUICK_VIEW', $settings['qv_enable']); //Display Quick View

define('QUICK_VIEW_TITLE',$settings['qv_text']); //Hide WooCommerce Page title

define('OUT_OF_STOCK_TEXT', $settings['out_of_stock_text']); //Display Quick View

define('PRODUCT_GALLERY', $settings['product_gallery']); //Display Quick View

define('HIDE_PAGE_TITLE', true); //Hide WooCommerce Page titles

// Checkout

define('ADDITIONAL_NOTES_CHECKOUT', $setting_checkout['enable_additional_notes']); //Hide Additional Notes for orders

// CONFIGURATION

// register jquery and style on initialization
add_action('init', 'register_script');
function register_script() {
     wp_register_script( 'my_jquery', plugins_url('/js/my-jquery.js', __FILE__), array('jquery'), '2.5.1', true );
     wp_register_style( 'my_style', plugins_url('/css/my-style.css', __FILE__), false, '1.0.0', 'all');
     wp_register_style( 'my_quick_view', plugins_url('/css/my_quick_view.css', __FILE__), false, '1.0.0', 'all');
     wp_register_style( 'my_media', plugins_url('/css/my-media.css', __FILE__), false, '1.0.0', 'all');
     wp_register_style( 'my_media', plugins_url('/css/my-media.css', __FILE__), false, '1.0.0', 'all');
}

// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'enqueue_style', 99);
function enqueue_style(){
     wp_enqueue_script('my_jquery');
     wp_enqueue_style( 'my_style' );
     wp_enqueue_style( 'my_quick_view' );
     wp_enqueue_style( 'my_media' );
}

/*************** Categories on Shop Page ******************************************************/
//display category before product name on shop page
if (CATEGORY_DISPLAY) {
   add_action('woocommerce_shop_loop_item_title', 'custom_pre_title', 1);
   function custom_pre_title(){
      global $product;

      $categories = $product->get_categories( ', ', _n( '', '', sizeof( get_the_terms( $post->ID, 'product_cat' ) ), 'woocommerce' ) . ' ' );

      // $categories = $product->get_categories();

      $a = explode(', ', $categories);
      $cat = array();

      if (sizeof($a) > 2) {
         for ($i=0; $i < 2; $i++) {
            array_push($cat, $a[$i]);
         }
         $categories = implode(', ', $cat);
      }else {
         $categories = implode(', ', $a);
      }
		echo "</a>";
      	echo sprintf('<h3 class="product-title">%s</h3>', $categories);
		echo "<a href=".get_permalink($id).">";
   }
}

//Quick VIEW
if(QUICK_VIEW){
   add_filter('woocommerce_shop_loop_item_title', 'qv_text',0);
   function qv_text(){
      // echo '<a href="javascript:;" id="'.get_the_ID().'" class="qv_text"><span>'.QUICK_VIEW_TITLE.'</span></a>';
      echo '<div id="'.get_the_ID().'" data-url="'.site_url().'" class="qv_text"><span>'.QUICK_VIEW_TITLE.'</span></div>';
   }
}

//Hide page title
if (HIDE_PAGE_TITLE) {
   add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
   function woo_hide_page_title() {
      return false;
   }
}

//remove additional information title and order notes field
if (!ADDITIONAL_NOTES_CHECKOUT) {
   add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
   add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );
   function remove_order_notes( $fields ) {
      unset($fields['order']['order_comments']);
      return $fields;
   }
}

if (PRODUCT_GALLERY) {
	function my_gallery_script() {
		wp_register_script('my-gallery-script', plugins_url('/js/my-gallery.js', __FILE__),array('jquery'), '1', true);
		wp_enqueue_script('my-gallery-script');
	}
	add_action( 'wp_enqueue_scripts', 'my_gallery_script',20,1);
}
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

/********************************* Woo new features ************************************/
add_action( 'after_setup_theme', 'yourtheme_setup' );

function yourtheme_setup() {
   add_theme_support( 'wc-product-gallery-zoom' );
   add_theme_support( 'wc-product-gallery-lightbox' );
   add_theme_support( 'wc-product-gallery-slider' );
}

/*****************************************************************/

/****** Show regular price in variable products - woo 3.0 bug fix *******/
//add variation sale strikethrough with original price on shop and category pages
add_filter('woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2);
add_filter('woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2);
function wc_wc20_variation_price_format($price, $product) {
     // Main Price
     $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
     $price_min = $prices[0] !== $prices[1] ? sprintf(__('%1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
     $price_max = $prices[0] !== $prices[1] ? sprintf(__('%1$s', 'woocommerce'), wc_price($prices[1])) : wc_price($prices[1]);
     // Sale Price
     $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
     sort($prices);
     $saleprice_min = $prices[0] !== $prices[1] ? sprintf(__('%1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
     $saleprice_max = $prices[0] !== $prices[1] ? sprintf(__('%1$s', 'woocommerce'), wc_price($prices[1])) : wc_price($prices[1]);
     if ($price_min !== $saleprice_min || $price_max !== $saleprice_max) {
          $del = $saleprice_min === $saleprice_max ? $saleprice_min : "$saleprice_min - $saleprice_max";
          $ins = $price_min === $price_max ? $price_min : "$price_min - $price_max";
          return "<del>$del</del> <ins>$ins</ins>";
     }
     return $price;
}

/*********************** My Account ******************************/

//Custom Login/ Register message
add_action( 'woocommerce_before_customer_login_form', 'custom_login_message' );
function custom_login_message() {
     if ( get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes' ) {
     ?>
     	<div class="woocommerce-info">
     		<p><?php _e( "Returning customers can log in. <br />New users can register in order to:" ); ?></p>
     		<ul>
     			<li><?php _e( 'View order history' ); ?></li>
     			<li><?php _e( 'Check on orders' ); ?></li>
     			<li><?php _e( 'Edit addresses' ); ?></li>
     			<li><?php _e( 'Change passwords' ); ?></li>
     		</ul>
     	</div>
     <?php
     }
}

//Change the 'Billing details' checkout label to 'Contact Information'
function wc_billing_field_strings( $translated_text, $text, $domain ) {
   switch ( $translated_text ) {
   case 'Billing details' :
   $translated_text = __( 'Contact Information', 'woocommerce' );
   break;
   }
   return $translated_text;
   }
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );




// Custom registration fields
add_action( 'woocommerce_register_form_start', 'woo_extra_register_fields' );
function woo_extra_register_fields() {?>
     <p class="form-row form-row-first">
          <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?>
               <span class="required">*</span>
          </label>
          <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( !empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
     </p>
     <p class="form-row form-row-last">
          <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?>
               <span class="required">*</span>
          </label>
          <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( !empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
     </p>
     <p class="form-row form-row-wide">
          <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
          <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
     </p>
     <div class="clear"></div>
     <?php
}

//Validating register fields input
add_action( 'woocommerce_register_post', 'woo_validate_extra_register_fields', 10, 3 );
function woo_validate_extra_register_fields( $username, $email, $validation_errors ) {
     if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
          $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
     }
     if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
     }
     return $validation_errors;
}

// Saving register fields input
add_action( 'woocommerce_created_customer', 'woo_save_extra_register_fields' );
function woo_save_extra_register_fields( $customer_id ) {
     if ( isset( $_POST['billing_phone'] ) ) {
          // Phone input field which is used in WooCommerce
          update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
     }
     if ( isset( $_POST['billing_first_name'] ) ) {
          //First name field which is by default
          update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
          // First name field which is used in WooCommerce
          update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
     }
     if ( isset( $_POST['billing_last_name'] ) ) {
          // Last name field which is by default
          update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
          // Last name field which is used in WooCommerce
          update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
     }
}

/************************************************************************/
// Display category image on category archive
// add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
// function woocommerce_category_image() {
//      if ( is_product_category() ){
//           global $wp_query;
//           $cat = $wp_query->get_queried_object();
//           $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
//           $image = wp_get_attachment_url( $thumbnail_id );
//           if ( $image ) {
//               echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
//           }
//      }
// }
/***********************************************************************/

/************************* For Checkout Page Re-Layout *******************/
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);


/* Move "Place your order" button */
add_action( 'woocommerce_review_order_before_submit', 'output_payment_button' );
function output_payment_button() {
    $order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place Order', 'woocommerce' ) );
    echo '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />';
}

add_filter( 'woocommerce_order_button_html', 'remove_woocommerce_order_button_html' );
function remove_woocommerce_order_button_html() {
    return '';
}

// start register
add_shortcode( 'wc_reg_form_bbloomer', 'bbloomer_separate_registration_form' );
    
function bbloomer_separate_registration_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
 
   // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
   // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
 
   do_action( 'woocommerce_before_customer_login_form' );
 
   ?>
      <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
 
         <?php do_action( 'woocommerce_register_form_start' ); ?>
         <div class='email_conts'>
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
 
         <?php endif; ?>
 
         <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
         </p>
 
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
            </p>
 
         <?php else : ?>
 
            <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
 
         <?php endif; ?>
         </div>
        <div>
           <?php do_action( 'woocommerce_register_form' ); ?>
        </div>
 
         <p class="woocommerce-FormRow form-row">
            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
         </p>
 
         <?php do_action( 'woocommerce_register_form_end' ); ?>
 
      </form>
 
   <?php
     
   return ob_get_clean();
}
// end reguster

// redirect if not loggin
function wpse_131562_redirect() {
   if (
       ! is_user_logged_in()
       && (is_checkout())
   ) {
       // feel free to customize the following line to suit your needs
       wp_redirect('register-2');
       exit;
   }
}
add_action('template_redirect', 'wpse_131562_redirect');

// send email to admin register

function my_wc_customer_created_notification( $id ) {
	wp_new_user_notification( $id, null, 'admin' );
}

add_action( 'woocommerce_created_customer', 'my_wc_customer_created_notification' );


// Modifying checkout fields

add_filter( 'woocommerce_review_order_before_payment' , 'payment_detail_text' );
function payment_detail_text() {
     echo '<h3>Payment Details</h3>';
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_company']);
     unset($fields['shipping']['shipping_company']);

     return $fields;
}

add_filter('woocommerce_default_address_fields', 'custom_override_default_address_fields');
function custom_override_default_address_fields($address_fields) {
     $address_fields['address_1']['label'] = 'Street Address';
     $address_fields['address_1']['placeholder'] = 'House number and street name';
     return $address_fields;
}

// confirm
/**
 * Add the code below to your theme's functions.php file
 * to add a confirm password field on the register form under My Accounts.
 */ 
function woocommerce_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}
add_filter('woocommerce_registration_errors', 'woocommerce_registration_errors_validation', 10, 3);

function woocommerce_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide confirm-pass">
		<label for="reg_password2"><?php _e( 'Confirm password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}
add_action( 'woocommerce_register_form', 'woocommerce_register_form_password_repeat' );
// end confirm


//Re-order fields
add_filter('woocommerce_checkout_fields', 'custom_order_fields');
function custom_order_fields($fields) {
     $order = array(
          'billing_country',
          'billing_first_name',
          'billing_last_name',
          'billing_email',
          'billing_phone',
          // 'billing_company',
          'billing_address_1',
          'billing_address_2',
          'billing_city',
          'billing_state',
          'billing_postcode'
     );

    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields['billing'][$field];
    }

     $fields['billing'] = $ordered_fields;

     $fields['billing']['billing_country']['priority'] = 10;
     $fields['billing']['billing_first_name']['priority'] = 20;
     $fields['billing']['billing_last_name']['priority'] = 30;
     $fields['billing']['billing_email']['priority'] = 40;
     $fields['billing']['billing_phone']['priority'] = 50;
     // $fields['billing']['billing_company']['priority'] = 60;
     $fields['billing']['billing_address_1']['priority'] = 60;
     $fields['billing']['billing_address_2']['priority'] = 70;
     $fields['billing']['billing_city']['priority'] = 80;
     $fields['billing']['billing_state']['priority'] = 90;
     $fields['billing']['billing_postcode']['priority'] = 100;

     return $fields;

}

/*********************************************************************************/

add_filter( 'woocommerce_ajax_variation_threshold', 'custom_wc_ajax_variation_threshold', 10, 2 );
function custom_wc_ajax_variation_threshold($qty, $product) {
    return 200;
}

// // Continue Shopping on Cart Page
// add_action( 'woocommerce_before_cart_table', 'woo_add_continue_shopping_button_to_cart' );
// function woo_add_continue_shopping_button_to_cart() {
//  $shop_page_url = get_permalink(get_option('woocommerce_shop_page_id'));
//
//  echo '<div class="woocommerce-message t_div">';
//  echo '<a href="'.$shop_page_url.'" class="button t_button">Continue Shopping →</a> <span class="t_message">Add more products?</span> ';
//  echo '</div>';
// }

add_filter( 'woocommerce_sale_flash', 'my_custom_sales_badge' );
function my_custom_sales_badge() {
   return false;
}

add_filter( 'woocommerce_before_shop_loop_item_title', 'my_custom_badge');
function my_custom_badge(){
   global $product;
   $img = '';

   if ($product->sale_price) {
      $text = SALE_TAG_TEXT;

      if (DISPLAY_SALE_PERCENTAGE == true) {
         $text = (100 - round(($product->sale_price / $product->regular_price),2) * 100).'% OFF';
      }

      $img = '<span class="onsale Woocommerce_onsale_tag">'.$text.'</span>';
   }

   if ($product->stock_status == 'outofstock') {
      $img = '<span class="onsale Woocommerce_onsale_tag sold">'.OUT_OF_STOCK_TEXT.'</span>';
   }

   echo $img;
}

// add_filter( 'woocommerce_product_tabs', 'delete_tab', 98 );
//     function delete_tab( $tabs ) {
//     unset($tabs['reviews']);
//     return $tabs;
// }



add_filter( 'woocommerce_product_tabs', 'woo_custom_product_tabs' );
function woo_custom_product_tabs( $tabs ) {

    unset( $tabs['additional_information'] );   // Remove the additional information tab

    //Attribute Description tab
//     $tabs['ingredients'] = array(
//         'title'     => __( 'Ingredients', 'woocommerce' ),
//         'priority'  => 100,
//         'callback'  => 'woo_attrib_ingredients_tab_content'
//     );

//     $tabs['direction'] = array(
//       'title'     => __( 'Directions', 'woocommerce' ),
//       'priority'  => 120,
//       'callback'  => 'woo_attrib_directions_tab_content'
//   );

  $tabs['reviews']['priority'] = 140;

    return $tabs;

}

add_filter( 'woocommerce_product_tabs', 'reordered_tabs', 98 );
function reordered_tabs( $tabs ) {
    $tabs['reviews']['priority'] = 140;
 
    return $tabs;
}

function woo_attrib_ingredients_tab_content() {
   the_field('ingredients');
}

function woo_attrib_directions_tab_content() {
   the_field('direction');
}

// TEMPLATE FIX
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/******************* DYNAMIC CART COUNT AND AMOUNT TOTAL *******************/

// add shortcode cart count
function cart_count_content(){
   global $woocommerce;
   $count = $woocommerce->cart->cart_contents_count;
   $woo_cart_count = sprintf($woocommerce->cart->cart_contents_count);
   return "<span class='counter' style='display: contents;'>".$woo_cart_count."</span>";
}
add_shortcode( 'cart_count', 'cart_count_content' );

// add shortcode cart total
function cart_total_content(){
   global $woocommerce;
   $count1 = $woocommerce->cart->get_cart_total();
   $woo_cart_total = sprintf($woocommerce->cart->get_cart_total());
   return "<span class='woo-cart-total-amount'><span class='woocommerce-Price-amount amount' style='display: inline;'>".$woo_cart_total."</span></span>";
}
add_shortcode( 'cart_total', 'cart_total_content' );

function iconic_cart_total_fragments( $fragments ) {
   global $woocommerce;
   $fragments['span.woo-cart-total-amount span.woocommerce-Price-amount'] = $woocommerce->cart->get_cart_total();
   $fragments['span.counter'] = '<span class="counter" style="display: contents;">' . WC()->cart->get_cart_contents_count() . '</span>';
   return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_total_fragments', 10, 1 );

/******************* DYNAMIC CART COUNT AND AMOUNT TOTAL *******************/

/******************* GET PRICE *******************/
function get_price(){
   global $product;
   $currency = get_option('woocommerce_currency');
   $i_price = number_format($product->price,2,'.',',');
   echo get_woocommerce_currency_symbol($currency).$i_price;
}
/******************* GET PRICE *******************/

// add_action( 'after_setup_theme', 'bbloomer_remove_zoom_lightbox_theme_support', 99 );
//
// function bbloomer_remove_zoom_lightbox_theme_support() {
// remove_theme_support( 'wc-product-gallery-zoom' );
// }

/**** QUICK VIEW ****/

// Summary
add_action( 'qv_summary', 'woocommerce_template_single_title', 5 );
add_action( 'qv_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'qv_summary', 'woocommerce_template_single_price', 15 );
add_action( 'qv_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'qv_summary', 'woocommerce_template_single_add_to_cart', 25 );
add_action( 'qv_summary', 'woocommerce_template_single_meta', 30 );

add_action('qv_image', 'get_qv_image');
function get_qv_image(){
	global $product;


	if (has_post_thumbnail($product->id)) { ?>
		<img src="<?php $url =  wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');echo $url[0];  ?>" alt="Featured Product" />
	<?php }else { ?>
		<img src="<?= get_home_url(); ?>/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="Featured Product" />
	<?php }
}

// add_action( 'qv_gallery', 'woocommerce_product_thumbnails', 20 );
add_action('qv_gallery', 'qv_gallery_func');
function qv_gallery_func(){
  global $product;
    $attachment_ids = $product->get_gallery_attachment_ids(); ?>
    <?php
    foreach( $attachment_ids as $attachment_id ) { ?>
        <img src="<?php echo $image_link = wp_get_attachment_url( $attachment_id ); ?>">
      <?php } ?>
    <?php
}

//Quick View Panel
function qv_panel(){
	$html  = '<div class="qv_opac"></div>';
	$html .= '<div class="qv_panel">';
	$html .= '<div class="qv_preloader xoo-qv-opl">';
	$html .= '<div class="qv_speeding-wheel"></div>';
	$html .= '</div>';
	$html .= '<div class="qv_modal"></div>';
	$html .= '</div>';
	echo $html;
}
add_action('wp_footer','qv_panel');

// billing in register

// Function to check starting char of a string
function startsWith($haystack, $needle){
   return $needle === '' || strpos($haystack, $needle) === 0;
}


// Custom function to display the Billing Address form to registration page
function zk_add_billing_form_to_registration(){
   global $woocommerce;
   $checkout = $woocommerce->checkout();
   ?>
   <?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>

       <?php if($key!='billing_email'){ 
           woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
       } ?>

   <?php endforeach; 
}
add_action('woocommerce_register_form_start','zk_add_billing_form_to_registration');

// Custom function to save Usermeta or Billing Address of registered user
function zk_save_billing_address($user_id){
   global $woocommerce;
   $address = $_POST;
   foreach ($address as $key => $field){
       if(startsWith($key,'billing_')){
           // Condition to add firstname and last name to user meta table
           if($key == 'billing_first_name' || $key == 'billing_last_name'){
               $new_key = explode('billing_',$key);
               update_user_meta( $user_id, $new_key[1], $_POST[$key] );
           }
           update_user_meta( $user_id, $key, $_POST[$key] );
       }
   }

}
add_action('woocommerce_created_customer','zk_save_billing_address');


// Registration page billing address form Validation
function zk_validation_billing_address(){
   global $woocommerce;
   $address = $_POST;
   foreach ($address as $key => $field) :
       // Validation: Required fields
       if(startsWith($key,'billing_')){
           if($key == 'billing_country' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please select a country.', 'woocommerce' ) );
           }
           if($key == 'billing_first_name' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter first name.', 'woocommerce' ) );
           }
           if($key == 'billing_last_name' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter last name.', 'woocommerce' ) );
           }
           if($key == 'billing_address_1' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter address.', 'woocommerce' ) );
           }
           if($key == 'billing_city' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter city.', 'woocommerce' ) );
           }
           if($key == 'billing_state' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter state.', 'woocommerce' ) );
           }
           if($key == 'billing_postcode' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter a postcode.', 'woocommerce' ) );
           }
           /*
           if($key == 'billing_email' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter billing email address.', 'woocommerce' ) );
           }
           */
           if($key == 'billing_phone' && $field == ''){
               $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter phone number.', 'woocommerce' ) );
           }

       }
   endforeach;
}
add_action('register_post','zk_validation_billing_address');

add_filter( 'woocommerce_checkout_fields' , 'remove_company_name' );

function remove_company_name( $fields ) {
     unset($fields['billing']['billing_first_name']);
     unset($fields['billing']['billing_last_name']);
     unset($fields['billing']['billing_phone']);
     return $fields;
}

add_filter( 'woocommerce_default_address_fields' , 'override_default_address_fields' );
function override_default_address_fields( $address_fields ) {

    // @ for postcode
    $address_fields['country']['label'] = __('Where can we ship your free products and gift certificates?', 'woocommerce');

    return $address_fields;
}

// end billing form

require_once (ABSPATH.'wp-content/plugins/functions-for-woo/templates/qv-ajax.php');
