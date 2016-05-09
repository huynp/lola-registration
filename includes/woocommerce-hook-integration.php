<?php
add_filter('woocommerce_loop_add_to_cart_link','lr_select_woocommerce_add_to_cart_link',10,2);
function lr_select_woocommerce_add_to_cart_link($link,$product){

    switch ( $product->product_type ) {
            case "variable" :
                $icon_class = 'mk-icon-plus';
                break;
            case "grouped" :
                $icon_class = 'mk-moon-search-3';
                break;
            case "external" :
                $icon_class = 'mk-moon-search-3';
                break;
            default :
                $icon_class = 'mk-moon-cart-plus';
                break;
    }

    if(!$product->is_purchasable() || !$product->is_in_stock()) 
        $icon_class = 'mk-moon-search-3';
    
    if ( is_user_logged_in() && user_is_active())
        return $link;
    else if( is_user_logged_in() && !user_is_active())
        return sprintf( '<a rel="nofollow" href="%s" class="%s"><i class="%s"></i>%s</a>', "#", "inactive-user product_loop_button product_type_simple", esc_attr( $icon_class ), esc_html( $product->add_to_cart_text() ));
    else
        return sprintf( '<a rel="nofollow" href="%s" class="%s"><i class="%s"></i>%s</a>', "#", "registration-link product_loop_button product_type_simple", esc_attr( $icon_class ), esc_html( $product->add_to_cart_text() ));
}

add_action('woocommerce_after_add_to_cart_button','lr_single_product_woocommerce_add_to_cart_link');
function lr_single_product_woocommerce_add_to_cart_link() {
    if(!is_user_logged_in() )
    {?>
        <style>
            .single_add_to_cart_button {
                display:none !important;
            }
        </style>
        <a href="#" class="registration-link shop-skin-btn shop-flat-btn alt">
            <i class="mk-moon-cart-plus"></i> Add to cart
        </a>
    <?php
    }
    else if(is_user_logged_in() && !user_is_active())
    {?>
        <style>
            .single_add_to_cart_button {
                display:none !important;
            }
        </style>
        <a href="#" class="inactive-user shop-skin-btn shop-flat-btn alt">
            <i class="mk-moon-cart-plus"></i>
            Add to cart
        </a>
<?php
    }
}

function user_is_active()
{
    $user_id = get_current_user_id();
    if ($user_id == 0) 
        return false;
    $status = get_user_meta($user_id,'critical_user_status');
    //$status_list = array( "0" => "Pending", "1" => "Active", "2" => "Deactive");
    return $status[0]=="1";
}

function lr_woocommerce_getImageURL($imageInfo)
{
    return ($imageInfo==null || $imageInfo->imgUrl=="")? LR_PLUGIN_URL."images/no_image_available.png":$imageInfo->imgUrl;
}
add_action('woocommerce_before_my_account','lr_woocommerce_before_my_account');
function lr_woocommerce_before_my_account(){
    $user = wp_get_current_user();
    $myAccountData = get_usermeta($user->ID, 'lr_user_additional_data');

    $myAccountData->government_photo =lr_woocommerce_getImageURL(get_usermeta($user->ID, 'critical_government_img'));
    $myAccountData->medical_photo =lr_woocommerce_getImageURL(get_usermeta($user->ID, 'critical_medical_img'));
    $myAccountData->personal_photo =lr_woocommerce_getImageURL(get_usermeta($user->ID, 'critical_personal_img'));

    wp_enqueue_style( 'lr-my-account-styles', LR_PLUGIN_URL . 'css/lr-my-account.css' );
    wp_enqueue_script( 'lr-app-script-my-account' , LR_PLUGIN_URL . 'js/lr-app-my-account.js', array( 'angular-js-script','angular-critical-module','angular-directives-CriticalInputs', 'angular-directives-NumberOnly','angular-directives-DateValidator'  ));
    wp_localize_script( 'lr-app-script-my-account', 'myAccountData', array(
        'ajaxUrl'=>admin_url( 'admin-ajax.php' ),
        'userId'=>$user->ID,
        'data' =>json_encode($myAccountData),
        'noImgUrl'=>LR_PLUGIN_URL."images/no_image_available.png"
    ));
    (new lola_registration_html())->getMyAccountHtml();
}
?>