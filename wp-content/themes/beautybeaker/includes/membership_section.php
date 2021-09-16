<?php 
$has_err = false;
function is_already_member(){
    $user_id = get_current_user_id();
    $args = array( 
        'status' => array( 'active', 'complimentary', 'pending' ),
    );  
    $active_memberships = wc_memberships_get_user_memberships( $user_id, $args );
    if(!empty($active_memberships)){
        foreach ($active_memberships as $key) {
            if($key->plan_id ==  '103'){
                return true;
                break;
            }
        }
    }
    return false;
}

function woo_in_cart($product_id) {
    global $woocommerce;
    foreach($woocommerce->cart->get_cart() as $key => $val ) {
        $_product = $val['data'];
        if($_product->name == 'Annual Membership' ) {
            return true;
        }
    }
    return false;
}
?>
<div id="member_section">
    <div class="member_cont">
        <?php if(is_already_member()){
            $has_err = true;
            echo '<div class="err-member">You are already subscribed on this membership plan!</div>';
        }
        ?>
        <?php if(!is_already_member() && woo_in_cart(103)){
            echo '<div class="err-member">You already added this membership plan in cart!</div>';
            $has_err = true;
        }
        ?>
        <h2>It's easy. Choose a membership, and start shopping at unbeatable insider prices.</h2>
        <div class="member_item">
            <div class='mem_top'>
                <h3>$25</h3>
                <div class='mem_label'>Annual <span>Membership</span></div>
            </div>
            <span class='no-limit'>No monthly limits.</span>
            <img src="<?php bloginfo('template_url');?>/images/membercard.png" alt="card">
            <a class='member-link' href="<?php echo $has_err ? '#' : site_url('/products/?add-to-cart=106')?>">Add to Bag</a>
        </div>
    </div>
</div>