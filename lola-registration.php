<?php
/**
 * Plugin Name: Lola Registration
 * Plugin URI: http://getlola.com
 * Description: Get lola registration plugin
 * Version: 1.0
 * Author: Huy Nguyen Phan
 * Author URI: huynp88@gmail.com
 * License: GPLv2 or later
 */
?>
<?php
//Plugin Code
if(!class_exists("Lola_Registration"))
{
    define('LR_PLUGIN_PATH', plugin_dir_path(__FILE__));
    define('LR_PLUGIN_URL', plugin_dir_url(__FILE__));
    class Lola_Registration {
        var $lr_upload_dirname;
        var $lr_upload_urlname;
        function __construct(){
            $this->addRequiredFile();
            $this->addScriptsAndStyles();
            $this->addLolaRegistrationAngularApp();
            $this->registerAjaxCallBack();
            $this->createDocumentUploadDir();
        }

        function createDocumentUploadDir(){
            //Create upload dir
            $upload_dir = wp_upload_dir();
            $this->lr_upload_dirname= $upload_dir['basedir'].'/lr-user-documents';
            $this->lr_upload_urlname = $upload_dir['baseurl'].'/lr-user-documents';
            if ( ! file_exists( $this->lr_upload_dirname ) ) {
                wp_mkdir_p( $this->lr_upload_dirname );
            }
        
        }

        
        function addRequiredFile(){
            require( LR_PLUGIN_PATH . 'includes/lola-registration-response.php' );
            require(LR_PLUGIN_PATH.'includes/lola-registration-html.php');
            require(LR_PLUGIN_PATH.'includes/lola-registration-admin.php');
            require(LR_PLUGIN_PATH.'includes/woocommerce-hook-integration.php');
            
        }

        function registerAjaxCallBack(){
            //login ajax
            add_action( 'wp_ajax_nopriv_lr_user_login', array($this,'ajax_login') );
            add_action( 'wp_ajax_lr_user_login',  array($this,'ajax_login'));

            //registration ajax
            add_action( 'wp_ajax_nopriv_lr_user_registration', array($this,'user_registration') );
            add_action( 'wp_ajax_lr_user_registration',  array($this,'user_registration'));

            //update user ajax
            add_action( 'wp_ajax_nopriv_lr_user_additional_data_update', array($this,'user_additional_data_update') );
            add_action( 'wp_ajax_lr_user_additional_data_update',  array($this,'user_additional_data_update'));

            //my account update ajax
            add_action( 'wp_ajax_nopriv_lr_my_account_update', array($this,'lr_my_account_update') );
            add_action( 'wp_ajax_lr_my_account_update',  array($this,'lr_my_account_update'));

            //Upload image ajax
            add_action('wp_ajax_nopriv_lr_file_upload',array($this, 'handle_file_upload'));
            add_action('wp_ajax_lr_file_upload', array($this,'handle_file_upload'));

            //Remove image ajax
            add_action('wp_ajax_nopriv_lr_file_remove',array($this, 'handle_file_remove'));
            add_action('wp_ajax_lr_file_remove', array($this,'handle_file_remove'));
        }

        function lr_document_upload_dir( $dir ) {
            return array(
                'path'   => $this->lr_upload_dirname,
                'url'    => $this->lr_upload_urlname,
                'subdir' => '/lr-user-documents',
            ) + $dir;
        }

        function handle_file_remove()
        {
            $userId = $_POST['userId'];
            $metaKey="";
            switch($_POST['imageType'])
            {
                case "government":
                    $metaKey ="critical_government_img";
                    break;
                case "medical":
                    $metaKey ="critical_medical_img";
                    break;
                case "personal":
                    $metaKey ="critical_personal_img";
                    break;
            }

            $imageInfo = get_usermeta($userId,$metaKey);
            unlink($imageInfo->imgDir);
            update_usermeta($userId,$metaKey,null);
        }

        function getImageInfo($upload_overrides,$imagePrefix,$fileObject,$userId, $metaKey)
        {
            list($name, $type) = split('[.]', $fileObject['name']);
            $fileObject['name'] =  $imagePrefix.$userId.".".$type;
            
            //remove old and add new image
            unlink($this->lr_upload_dirname.'/'.$fileObject['name']);
            wp_handle_upload($fileObject, $upload_overrides);

            //Save image info to meta data
            $imageInfo = new stdClass();
            $imageInfo->imgUrl = $this->lr_upload_urlname.'/'.$fileObject['name'];
            $imageInfo->imgDir = $this->lr_upload_dirname.'/'.$fileObject['name'];
            update_usermeta( $userId, $metaKey,$imageInfo );
            return $imageInfo;
        }

        function handle_file_upload(){
            //check_ajax_referer('ajax_file_nonce', 'security');
            if(!(is_array($_POST) && is_array($_FILES) && defined('DOING_AJAX') && DOING_AJAX))
                return;

            if(!function_exists('wp_handle_upload'))
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            
            $upload_overrides = array('test_form' => false);
            $userId = $_POST['userId'];
            $result = new stdClass();
            // change upload.
            add_filter( 'upload_dir', array($this,'lr_document_upload_dir') );

            //GovernmentIDPhoto
            $governmentIDPhoto = $_FILES['governmentIDPhoto'];
            if ($governmentIDPhoto!=null)
                $result->government_photo = $this->getImageInfo($upload_overrides,"government-id-photo-",$governmentIDPhoto,$userId,'critical_government_img')->imgUrl;

            //Medical photo
            $medicalPhotoInfo = $_FILES['medicalPhoto'];
            if ($medicalPhotoInfo!=null)
                $result->medical_photo = $this->getImageInfo($upload_overrides,"medical-photo-",$medicalPhotoInfo,$userId,'critical_medical_img')->imgUrl;

            //Personal photo
            $personalPhotoInfo = $_FILES['personalPhoto'];
            if ($personalPhotoInfo!=null)
                $result->personal_photo = $this->getImageInfo($upload_overrides,"personal-photo-",$personalPhotoInfo,$userId,'critical_personal_img')->imgUrl;
               
            // Set everything back to normal.
            remove_filter( 'upload_dir', array($this,'lr_document_upload_dir') );
            echo json_encode(new Lola_Registration_Response($result,"success",null));
            die();
        }

        function updateWoocommerceMetaData($userId, $userAddintionalData){
            update_user_meta($userId,"billing_first_name",$userAddintionalData->billingFirstName);
            update_user_meta($userId,"billing_last_name",$userAddintionalData->billingLastName);
            update_user_meta($userId,"billing_address_1",$userAddintionalData->billingAddress1);
            update_user_meta($userId,"billing_address_2",$userAddintionalData->billingAddress2);
            update_user_meta($userId,"billing_state",$userAddintionalData->billingState);
            update_user_meta($userId,"billing_country",$userAddintionalData->billingCountry);
            update_user_meta($userId,"billing_postcode",$userAddintionalData->billingPostCode);
            update_user_meta($userId,"billing_phone",$userAddintionalData->billingCellPhone);
            update_user_meta($userId,"billing_email",$userAddintionalData->billingEmail);
            update_user_meta($userId,"billing_city",$userAddintionalData->billingCity);
            
            update_user_meta($userId,"shipping_first_name",$userAddintionalData->shippingFirstName);
            update_user_meta($userId,"shipping_last_name",$userAddintionalData->shippingLastName);
            update_user_meta($userId,"shipping_address_1",$userAddintionalData->shippingAddress1);
            update_user_meta($userId,"shipping_address_2",$userAddintionalData->shippingAddress2);
            update_user_meta($userId,"shipping_postcode",$userAddintionalData->shippingPostCode);
            update_user_meta($userId,"shipping_country",$userAddintionalData->shippingCountry);
            update_user_meta($userId,"shipping_state",$userAddintionalData->shippingState);
            update_user_meta($userId,"shipping_city",$userAddintionalData->shippingCity);
        }

        function lr_my_account_update(){
            $userInfo = json_decode( stripslashes($_POST['userInfo']));
            $userId =intval( $_POST['userId']);
            try{
                if($userId!=null)
                {
                    $this->updateWoocommerceMetaData($userId,$userInfo);
                    update_usermeta( $userId, 'lr_user_additional_data', $userInfo );
                }
                else
                    throw new Exception("User id can not be null");
                echo json_encode(new Lola_Registration_Response( get_usermeta( $userId, 'lr_user_additional_data'), "success" , null));
            }
            catch(Exception $ex)
            {
                echo json_encode(new Lola_Registration_Response( null, "error" ,$ex->getMessage()));
            }
            die();
        }

        function user_additional_data_update(){
            $userAddintionalData = json_decode( stripslashes($_POST['userAddintionalData']));
            $userId =intval( $_POST['userId']);
            try{
                if($userId!=null)
                {
                    $this->updateWoocommerceMetaData($userId,$userAddintionalData);
                    update_usermeta( $userId, 'lr_user_additional_data', $userAddintionalData );
                }
                else
                    throw new Exception("User id can not be null");
                echo json_encode(new Lola_Registration_Response( get_usermeta( $userId, 'lr_user_additional_data'), "success" , null));
            }
            catch(Exception $ex)
            {
                echo json_encode(new Lola_Registration_Response( null, "error" ,$ex->getMessage()));
            }
            die();
        }

        function user_registration() {
            global $wpdb;
            $error = '';
            $success = '';
            $userData = json_decode( stripslashes($_POST['userData']));
            if( empty( $userData->userName ) ) {
                $error = 'Username field is required.';
            } else if( empty( $userData->password ) ) {
                $error = 'Password field is required.';
            } else {
                $user_params = array (
                    'user_email' =>$userData->email,
                    'user_login' 	=> $userData->userName,
                    'user_pass' 	=> $userData->password,
                    'role' 			=> 'subscriber'
                );
                $user_id = wp_insert_user( $user_params );
                if( is_wp_error( $user_id ) )
                    $error = $user_id->get_error_message();
                else
                {
                    do_action( 'user_register', $user_id );
                    $success= $user_id;
                    //TODO: Sent welcome email here.
                }
            }
            if(!empty($error))
                echo json_encode(new Lola_Registration_Response(null,"error", $error));
            if(!empty($success))
                echo json_encode(new Lola_Registration_Response($success,"success", null));
            // return proper result
            die();
        }

        function ajax_login(){
            $info = array();
            $userData = json_decode( stripslashes($_POST['userData']));
            $info['user_login'] = $userData->userName;
            $info['user_password'] = $userData->password;
            $info['remember'] = true;
            $user_signon = wp_signon( $info, false );
            if ( is_wp_error($user_signon) ){
                echo json_encode(new Lola_Registration_Response(null,"error", 'Wrong username or password.'));
            } else
            {
                wp_set_current_user($user_signon->ID);
                echo json_encode(new Lola_Registration_Response('successful',"success", null));
            }
            die();
        }

        function addScriptsAndStyles(){
            //Add angular scripts
            //Angular script
            wp_enqueue_script( 'angular-js-script' , LR_PLUGIN_URL . 'js/angular.js', array( 'jquery','jquery-form' ));
            wp_enqueue_script( 'angular-messages-script' , LR_PLUGIN_URL . 'js/angular-js/angular-messages.js', array( 'angular-js-script'));
            wp_enqueue_script( 'lr-popup-js-script' , LR_PLUGIN_URL . 'js/lr-popup.js', array( 'jquery'));
            
            //Thirdparty Directive
            wp_enqueue_script( 'angular-third-party-ui-bootstrap-tpls' , LR_PLUGIN_URL . 'js/angular-js/angular-ui/ui-bootstrap-tpls.min.js', array( 'angular-js-script'));
            wp_enqueue_script( 'angular-third-party-validate.min.js' , LR_PLUGIN_URL . 'js/angular-js/angular-ui/validate.min.js', array( 'angular-js-script'));
            wp_enqueue_script( 'angular-third-party-mask.min.js' , LR_PLUGIN_URL . 'js/angular-js/angular-ui/mask.min.js', array( 'angular-js-script'));
            //Angular custome directive
            wp_enqueue_script( 'angular-critical-module' , LR_PLUGIN_URL . 'js/directives/CriticalModule.js', array( 'angular-js-script'));
            wp_enqueue_script( 'angular-directives-CriticalInputs' , LR_PLUGIN_URL . 'js/directives/CriticalInputs.js', array( 'angular-js-script','angular-critical-module'));
            wp_enqueue_script( 'angular-directives-NumberOnly' , LR_PLUGIN_URL . 'js/directives/NumberOnly.js', array( 'angular-js-script','angular-critical-module'));
            wp_enqueue_script( 'angular-directives-DateValidator' , LR_PLUGIN_URL . 'js/directives/DateValidator.js', array( 'angular-js-script','angular-critical-module'));
            //Add script and style
            if(!is_admin() &&  !in_array( $GLOBALS['pagenow'], array( 'wp-login.php') ))
            {
                wp_enqueue_style( 'lr-styles', LR_PLUGIN_URL . 'css/styles.css' );
                //Jquery plugin
                wp_enqueue_script( 'lr-app-script' , LR_PLUGIN_URL . 'js/lr-app.js', array( 'angular-js-script','angular-critical-module' ));
                wp_localize_script( 'lr-app-script', 'lrSettings', array(
		            'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'nonce'=>wp_create_nonce(),
                    'is_user_logged_in'=> is_user_logged_in(),
                    'is_user_active'=> user_is_active()
	            ));
            }
        }

        function addLolaRegistrationAngularApp(){
            add_action('wp_footer',array( new lola_registration_html(),'getPopupHtml'));
            add_action('wp_footer',array( new lola_registration_html(),'getClientHtml'));
        }
    }
}
// Add Plugin
add_action("plugins_loaded","lr_load");
function lr_load(){
    global $lr;
    $lr = new Lola_Registration();
}
?>













<?php
////Uncomment to Register setting menu if need
////Add Setting Menu
//add_action('admin_menu','lr_create_admin_menu');
function lr_create_admin_menu(){
    add_options_page('Lola Registration Settings','Lola Registration', 'manage_options','lr-registration','lr_settings_page');
    add_action( 'admin_init', 'register_lr_settings' );
}
function register_lr_settings(){
}
function lr_settings_page(){
?><div class="wrap">
    <h2>Lola Registration Settings</h2>
    <form method="post" action="options.php">
        <?php //settings_fields( 'lr-settings-group' );?>
        <table class="form-table"></table>
        <?php //submit_button(); ?>
    </form>
</div>
<?php } ?>
