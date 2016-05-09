<?php

/**
 * lola_registration_html short summary.
 *
 * lola_registration_html description.
 *
 * @version 1.0
 * @author huynp
 */
?>
<?php
add_action( 'show_user_profile', 'lola_registration_show_extra_profile_fields' , 100);
add_action( 'edit_user_profile', 'lola_registration_show_extra_profile_fields' , 100);
function lola_registration_show_extra_profile_fields( $user ) {
    $extraInfo = get_usermeta($user->ID, 'lr_user_additional_data');
    $government_photo = get_usermeta($user->ID, 'critical_government_img');
    $medical_photo = get_usermeta($user->ID, 'critical_medical_img');
    $personal_photo = get_usermeta($user->ID, 'critical_personal_img');
    wp_enqueue_script( 'lr-app-script-admin' , LR_PLUGIN_URL . 'js/lr-app-admin.js', array( 'angular-js-script','angular-critical-module','angular-directives-CriticalInputs', 'angular-directives-NumberOnly','angular-directives-DateValidator'  ));
    wp_localize_script( 'lr-app-script-admin', 'extraInfo', array(
        'ajax_url'=>admin_url( 'admin-ajax.php' ),
        'userId'=>$user->ID,
        'data' =>json_encode($extraInfo),
        'government_photo'=> $government_photo,
        'medical_photo'=> $medical_photo,
        'personal_photo'=> $personal_photo
    ));
    (new lola_registration_html())->getAdminHtml();
}
add_action( 'personal_options_update', 'lola_registration_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'lola_registration_save_extra_profile_fields' );

function lola_registration_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
    $userAddintionalData = json_decode( stripslashes($_POST['userAdditionalInfo']));
    update_usermeta( $user_id, 'lr_user_additional_data', $userAddintionalData );
}
?>