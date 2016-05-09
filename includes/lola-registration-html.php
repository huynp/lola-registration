<?php
/**
 * lola_registration_html short summary.
 *
 * lola_registration_html description.
 *
 * @version 1.0
 * @author huynp
 */
class lola_registration_html
{
    function getClientHtml()
    {
?>

<div class="registration-cover hide">
    <div id="lr-registration-app" ng-app="la-registration-app">
        <div ng-controller="registrationController as ctrl" class="lr-container">
            <div class="close-button" ng-click="ctrl.CancelBtnClick()"></div>
            <div class="lr-loading" ng-show="ctrl.showLoading">
                <div class="cssload-thecube">
                    <div class="cssload-cube cssload-c1"></div>
                    <div class="cssload-cube cssload-c2"></div>
                    <div class="cssload-cube cssload-c4"></div>
                    <div class="cssload-cube cssload-c3"></div>
                </div>
            </div>
            <ng-form name="loginForm" novalidate>
                <div class="init-screen" ng-show="ctrl.mode=='init'">
                    <div class="login-box lr-step-content">
                        <h2>Log In</h2>
                        <critical-form-group input-options="{name:'userName', type:'text',  required:true}" bind-to="ctrl.loginInfo.userName" label="Username*" ng-keyup="$event.keyCode == 13 && ctrl.Login()"></critical-form-group>
                        <critical-form-group input-options="{name:'password', type:'password', required:true}" bind-to="ctrl.loginInfo.password" label="Password*" ng-keyup="$event.keyCode == 13 && ctrl.Login()"></critical-form-group>

                        <div class="lr-action-bar">
                            <button class="lr-step-submit-btn" ng-click="ctrl.Login()">Login</button>
                            <button class="lr-cancel-btn" ng-click="ctrl.CancelBtnClick()">Cancel</button>
                        </div>
                    </div>
                    <div class="registration-box">
                        <img src="/wp-content/plugins/lola-registration/images/register_now_2.png" width="100%" ng-click="ctrl.RegistrationNow()" />
                    </div>
                </div>
            </ng-form>
            <div class="registration-process-container" ng-show="ctrl.mode=='registration'">
                <div class="lr-status-bar">
                    <img ng-src="{{ctrl.stepProgressBar}}" />
                </div>
                <div class="lr-step-content" ng-switch="ctrl.step">
                    <form name="registrationFormStep1" novalidate>
                        <div class="step-1" ng-switch-when="1">
                            <div class="content-text P1-Condensed-18">
                                Welcome to Get Lola Lola<sup>TM</sup>, where the highest quality cannabis goods are delivered straight to your door. To set up your account, you will need proof of identification, physician information and patient ID number <span class="P2-Condensed-Bold-18">GET LOLA LOLA <sup>TM</sup> NOW!</span>
                            </div>
                            <critical-form-group input-options="{name:'email', type:'email',  maxLength:100, required:true}" bind-to="ctrl.user.email" label="Email*" is-disabled="ctrl.user.userId != undefined"></critical-form-group>
                            <critical-form-group input-options="{name:'userName', type:'text',  required:true}" bind-to="ctrl.user.userName" label="Username*" is-disabled="ctrl.user.userId != undefined"></critical-form-group>
                            <critical-form-group input-options="{name:'password', type:'password', required:true}" bind-to="ctrl.user.password" label="Password*" is-disabled="ctrl.user.userId != undefined" ng-keyup="$event.keyCode == 13 && ctrl.StepSubmitBtnClick()"></critical-form-group>
                        </div>
                    </form>
                    <form name="registrationFormStep2">
                        <div class="step-2" ng-switch-when="2">
                            <div class="content-text P1-Condensed-18">
                                Get Lola Lola <sup>TM</sup> delivery is currently open to California residents.
                            </div>
                            <critical-form-group input-options="{name:'firstName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.firstName" label="First Name*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'lastName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.lastName" label="Last Name*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'address1', type:'text',  maxLength:200, required:true}" bind-to="ctrl.userAdditionalInfo.address1" label="Address 1*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'address2', type:'text',  maxLength:200}" bind-to="ctrl.userAdditionalInfo.address2" label="Address 2">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'PostCode', type:'text',  maxLength:10, required:true}" bind-to="ctrl.userAdditionalInfo.postCode" label="Post Code*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'cellPhone', type:'phone',  maxLength:20, required:true}" bind-to="ctrl.userAdditionalInfo.cellPhone" label="Cell Phone*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'dob', type:'date',  required:true}" bind-to="ctrl.userAdditionalInfo.dob" label="Date of Birth*">
                            </critical-form-group>
                            <select class="form-control" id="optGovIssueType" ng-model="ctrl.userAdditionalInfo.govIssueType">
                                <option value="1">Passport</option>
                                <option value="2">Driver's License</option>
                            </select>
                            <critical-form-group input-options="{name:'govIssueId', type:'text',  required:true}" bind-to="ctrl.userAdditionalInfo.govIssueId" label="Government Issued ID Number*"  ng-keyup="$event.keyCode == 13 && ctrl.StepSubmitBtnClick()">
                            </critical-form-group>
                        </div>
                    </form>
                    <form name="registrationFormStep3">
                        <div class="step-3" ng-switch-when="3">
                            <div class="content-text P1-Condensed-18">
                                Please enter your physician information and patient ID # corresponding with your medical marijuana card.
                            </div>
                            <critical-form-group input-options="{name:'phycianName', type:'text',  maxLength:200, required:true}" bind-to="ctrl.userAdditionalInfo.phycianName" label="Physician Name*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'phycianPhone', type:'phone',  maxLength:20, required:true}" bind-to="ctrl.userAdditionalInfo.phycianPhone" label="Physician Phone*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'phycianVerificationUrl', type:'text',  maxLength:200, required:true}" bind-to="ctrl.userAdditionalInfo.phycianVerificationUrl" label="Physician Verification URL*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'patientId', type:'text',  maxLength:200, required:true}" bind-to="ctrl.userAdditionalInfo.patientId" label="Patient ID Number*">
                            </critical-form-group>
                            <critical-form-group input-options="{name:'patientIdExpiration', type:'date',  maxLength:200, required:true}" bind-to="ctrl.userAdditionalInfo.patientIdExpiration" label="Patient ID Expiration*"   ng-keyup="$event.keyCode == 13 && ctrl.StepSubmitBtnClick()">
                            </critical-form-group>
                        </div>
                    </form>
                    <div class="step-4" ng-switch-when="4">
                        <div class="content-text P1-Condensed-18">
                            Now, simply upload your documents. You will receive an email notifying you of account verification within 30 minutes. Once you are verified, your account status will be saved in our system for future orders.
                        </div>
                        <form id="documentUploadForm" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype="multipart/form-data">
                            <?php wp_nonce_field('ajax_file_nonce', 'security'); ?>
                            <div class="file-upload-form">
                                <label for="file_upload">Government ID Photo</label>
                                <input type="file" name="governmentIDPhoto" />
                            </div>
                            <div class="file-upload-form">
                                <label for="file_upload">Medical ID Photo</label>
                                <input type="file" name="medicalPhoto" />
                            </div>
                            <div class="file-upload-form">
                                <label for="file_upload">Personal Photo</label>
                                <input type="file" name="personalPhoto" />
                            </div>
                        </form>
                    </div>
                    <form name="registrationFormStep5">
                        <div class="step-5" ng-switch-when="5">
                            <div class="userAgreement form-control P1-Condensed-18">
                                The ancient art of alchemy is making a long awaited comeback. Naturally, the Golden State will be the first to experience the magic. Get ready to discover the freshest, most flavorful flowers, packed with all the good juju. It's plant magic like you've never seen before, and it's coming this winter to a dispensary near you.
                            </div>
                            <div class="form-group">
                                <label class="checkbox">
                                    <input type="checkbox" name="agreeTerm" ng-required="true" ng-model="ctrl.userAdditionalInfo.isAgreeTerm"> I have read and agree with terms and condititons
                                </label>
                                <div class="help-block error-message" ng-messages="registrationFormStep5.agreeTerm.$error" ng-show="registrationFormStep5.agreeTerm.$invalid && registrationFormStep5.$submitted">
                                    <p>Please confirm you have read and agree with terms and conditions</p>
                                </div>
                            </div>
                            <critical-form-group input-options="{name:'eSignature', type:'text',  maxLength:200, required:true}" bind-to="ctrl.userAdditionalInfo.eSignature" label="Please sign your name here*"   ng-keyup="$event.keyCode == 13 && ctrl.StepSubmitBtnClick()">
                            </critical-form-group>
                        </div>
                    </form>
                </div>
                <div class="content-character">
                    <img ng-src="{{ctrl.characterImage}}" />
                </div>
                <div class="lr-action-bar">
                    <button class="lr-prev-btn" ng-click="ctrl.PrevBtnClick()">Prev</button>
                    <button class="lr-step-submit-btn" ng-click="ctrl.StepSubmitBtnClick()">Submit</button>
                    <button class="lr-cancel-btn" ng-click="ctrl.CancelBtnClick()">Cancel</button>
                </div>
            </div>
            <div class="popup" ng-show="ctrl.mode=='popup'">
                <div class="account-registration-message P1-Condensed-18" ng-show="ctrl.popupType=='account-registration-message'">
                    Mission accomplished, welcome to Lolalandia! It only takes 30 minutes to confirm your registration, then you are ready to shop. Please check your email for account verification, then follow the link to Get Lola Lola.
                </div>
                <div class="account-not-verified-message P1-Condensed-18" ng-show="ctrl.popupType=='account-not-verified-message'">
                    We’re sorry, there was trouble processing your request. If you are over 18 years old, have a valid medicinal marijuana card, and are a CA resident, please contact support@getlolalola.com for further assistance.
                </div>
            </div>
        </div>
    </div>
</div>

<?php
 }
    function getAdminHtml()
    {
?>

<div id="lr-registration-app" ng-app="la-registration-admin-app">
    <h3>Lola Registration User Extra Information</h3>
    <style>
        .help-block {
            color: red;
            font-weight: bold;
        }

        img.lr-image {
            border-radius: 5px;
            border: 2px solid #cacaca;
        }
    </style>
    <div ng-controller="registrationAdminController as ctrl">
        <input type="hidden" value="{{ctrl.userAdditionalInfo}}" name="userAdditionalInfo" />
        <ng-form name="extraInfoForm" novalidate>
            <table class="form-table">
                <tr>
                    <th><label>Date of Birth</label></th>
                    <td>
                        <critical-form-group input-options="{name:'dob', type:'date',  required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.dob" label="Date of Birth*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>Government Issue Type</label></th>
                    <td>

                        <select class="form-control" id="optGovIssueType" ng-model="ctrl.userAdditionalInfo.govIssueType">
                            <option value="1">Passport</option>
                            <option value="2">Driver's License</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>Government Issued ID Number</label></th>
                    <td>
                        <critical-form-group input-options="{name:'govIssueId', type:'text',  required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.govIssueId" label="Government Issued ID Number*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>Physician Name</label></th>
                    <td>
                        <critical-form-group input-options="{name:'phycianName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.phycianName" label="Physician Name*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>Physician Phone</label></th>
                    <td>
                        <critical-form-group input-options="{name:'phycianPhone', type:'phone',  maxLength:20, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.phycianPhone" label="Physician Phone*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>Physician Verification URL</label></th>
                    <td>
                        <critical-form-group input-options="{name:'phycianVerificationUrl', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.phycianVerificationUrl" label="Physician Verification URL*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>Patient ID Number</label></th>
                    <td>
                        <critical-form-group input-options="{name:'patientId', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.patientId" label="Patient ID Number*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>Patient ID Expiration</label></th>
                    <td>
                        <critical-form-group input-options="{name:'patientIdExpiration', type:'date',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.patientIdExpiration" label="Patient ID Expiration*">
                        </critical-form-group>
                    </td>
                </tr>
                <tr>
                    <th><label>E Signature</label></th>
                    <td>
                        <critical-form-group input-options="{name:'eSignature', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userAdditionalInfo.eSignature" label="Please sign your name here*">
                        </critical-form-group>
                    </td>
                </tr>
            </table>
        </ng-form>
    </div>
</div>

<?php
 }
    function getMyAccountHtml()
    {
?>

<div id="lr-my-account-app" ng-app="lr-my-account-app">
    <div ng-controller="lrMyAccountController as ctrl">
        <div class="lr-loading" ng-show="ctrl.showLoading">
            <div class="cssload-thecube">
                <div class="cssload-cube cssload-c1"></div>
                <div class="cssload-cube cssload-c2"></div>
                <div class="cssload-cube cssload-c4"></div>
                <div class="cssload-cube cssload-c3"></div>
            </div>
        </div>
        <h2 class="page-tile H1-Condensed-Bold-36">MY ACCOUNT</h2>
        <div class="welcome-text">
            <?php
                printf(  __( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
               wp_get_current_user()->display_name,
              wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
              );
            ?>
        </div>
        <ng-form name="extraInfoForm" novalidate>
            <div class="left-col">
                <div class="personal-info lr-form-table">
                    <div class="row">
                        <div class="form-title N1-Condensed-Bold-26">Personal Info</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="lr_fullName">First Name*</label>
                        </div>
                        <div class="col">
                            <critical-form-group input-options="{name:'firstName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.firstName" label="First Name*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_fullName">Last Name*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'lastName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.lastName" label="Last Name*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_email">Email*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'email', type:'email',  maxLength:100, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.email" label="Email*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_cellPhone">CellPhone*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'cellPhone', type:'phone',  maxLength:20, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.cellPhone" label="Cell Phone*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Date of Birth*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'dob', type:'date',  required:true, class:'regular-text'}" bind-to="ctrl.userInfo.dob" label="Date of Birth*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Government Issue Type</label></div>
                        <div class="col">

                            <select class="form-control" id="optGovIssueType" ng-model="ctrl.userInfo.govIssueType">
                                <option value="1">Passport</option>
                                <option value="2">Driver's License</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Government Issued ID Number*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'govIssueId', type:'text',  required:true, class:'regular-text'}" bind-to="ctrl.userInfo.govIssueId" label="Government Issued ID Number*">
                            </critical-form-group>
                        </div>
                    </div>
                </div>
                <div class="billing-address lr-form-table">
                    <div class="row">
                        <div class="form-title N1-Condensed-Bold-26">Billing Address</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="lr_billingFistName">First Name*</label>
                        </div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingFirstName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingFirstName" label="First Name*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_billingLastName">Last Name*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingLastName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingLastName" label="Last Name*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_billingAddress1">Address 1</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingAddress1', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingAddress1" label="Address 1*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_billingAddress1">Address 2</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingAddress2', type:'text',  maxLength:200, class:'regular-text'}" bind-to="ctrl.userInfo.billingAddress2" label="Address 2">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_city">City</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'city', type:'text',  maxLength:100, class:'regular-text'}" bind-to="ctrl.userInfo.billingCity" label="City">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_billingPostCode">PostCode</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingPostCode', type:'text',  maxLength:10, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingPostCode" label="Post Code*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_state">State/County</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'state', type:'text',  maxLength:10, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingState" label="State*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_billingCellPhone">CellPhone*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingCellPhone', type:'phone',  maxLength:20, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingCellPhone" label="Cell Phone*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label for="lr_billingEmail">Email*</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'billingEmail', type:'email',  maxLength:100, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.billingEmail" label="Email*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="text-align:right">
                            <label for="lr_sameAsShipping">Same as Shipping?  <input type="checkbox" value="" id="lr_sameAsShipping" ng-model="ctrl.userInfo.sameAsShipping" /></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-col">
                <div class="medical-info lr-form-table">
                    <div class="row">
                        <div class="form-title N1-Condensed-Bold-26">Medical Information</div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Physician Name</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'phycianName', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.phycianName" label="Physician Name*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Physician Phone</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'phycianPhone', type:'phone',  maxLength:20, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.phycianPhone" label="Physician Phone*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Physician Verification URL</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'phycianVerificationUrl', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.phycianVerificationUrl" label="Physician Verification URL*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Patient ID Number</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'patientId', type:'text',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.patientId" label="Patient ID Number*">
                            </critical-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><label>Patient ID Expiration</label></div>
                        <div class="col">
                            <critical-form-group input-options="{name:'patientIdExpiration', type:'date',  maxLength:200, required:true, class:'regular-text'}" bind-to="ctrl.userInfo.patientIdExpiration" label="Patient ID Expiration*">
                            </critical-form-group>
                        </div>
                    </div>
                </div>
                <div class="upload-documents lr-form-table">
                    <div class="row">
                        <div class="form-title N1-Condensed-Bold-26">Document</div>
                    </div>
                    <form id="documentUploadForm" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype="multipart/form-data">
                        <div class="file-upload-form">
                            <label for="file_upload">Government ID Photo</label>
                            <div class="image-holder">
                                <i class="mk-moon-cancel-circle" ng-hide="ctrl.userInfo.government_photo.indexOf('no_image_available.png')>-1" ng-click="ctrl.removeImage('government')"></i>
                                <img ng-src="{{ctrl.userInfo.government_photo}}" />
                            </div>
                            <input type="file" name="governmentIDPhoto" onchange="angular.element(this).scope().ctrl.uploadImage('government')" />
                        </div>
                        <div class="file-upload-form">
                            <label for="file_upload">Medical ID Photo</label>
                            <div class="image-holder">
                                <i class="mk-moon-cancel-circle" ng-hide="ctrl.userInfo.medical_photo.indexOf('no_image_available.png')>-1" ng-click="ctrl.removeImage('medical')"></i>
                                <img ng-src="{{ctrl.userInfo.medical_photo}}" />
                            </div>
                            <input type="file" name="medicalPhoto" onchange="angular.element(this).scope().ctrl.uploadImage('medical')" />
                        </div>
                        <div class="file-upload-form">
                            <label for="file_upload">Personal Photo</label>
                            <div class="image-holder">
                                <i class="mk-moon-cancel-circle" ng-hide="ctrl.userInfo.personal_photo.indexOf('no_image_available.png')>-1" ng-click="ctrl.removeImage('personal')"></i>
                                <img ng-src="{{ctrl.userInfo.personal_photo}}" />
                            </div>
                            <input type="file" name="personalPhoto" onchange="angular.element(this).scope().ctrl.uploadImage('personal')" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="lr-action-bar clear">
                <button class="lr-step-submit-btn" ng-click="ctrl.myAccountSubmit()">Save</button>
            </div>
        </ng-form>
    </div>
</div>

<?php
 }
    function getPopupHtml(){
?>
    <div class="lr-popup-overlay lr-popup">
        <div class="lr-popup-content">
            <div class="lr-popup-close-btn"></div>
            <div class="body-content">

            </div>
            <div class="lr-popup-action-bar">
            </div>
        </div>
    </div>
<?php
 }
}
?>