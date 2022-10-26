<?php
require_once "class-msbr-lic-base.php";
class MSBR_Lic {
    public $plugin_file=__FILE__;
    public $responseObj;
    public $licenseMessage;
    public $showMessage=false;
    public $slug="mswebarts-overview";
    function __construct() {
        add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
        $licenseKey=get_option("msbr_lic_key","");
        $liceEmail=get_option( "msbr_lic_email","");
        MSBR_Lic_Base::addOnDelete(function(){
           delete_option("msbr_lic_key");
        });
        if(MSBR_Lic_Base::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj,__FILE__)){
            add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);
            add_action( 'admin_post_msbr_lic_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
            //$this->licenselMessage=$this->mess;
            //***Write you plugin's code here***
            add_action( 'msbr_license_box', [ $this, 'Activated' ] );

        }else{
            if(!empty($licenseKey) && !empty($this->licenseMessage)){
               $this->showMessage=true;
            }
            update_option("msbr_lic_key","") || add_option("msbr_lic_key","");
            add_action( 'admin_post_msbr_lic_el_activate_license', [ $this, 'action_activate_license' ] );
            add_action( 'admin_menu', [$this,'InactiveMenu']);
            add_action( 'msbr_license_box', [ $this, 'LicenseForm' ] );
        }
    }
    function SetAdminStyle() {
        global $msbr_dir;
        wp_register_style( "msbr_lic_css", plugins_url("../admin/assets/css/_lic_style.css",$this->plugin_file),10);
        wp_enqueue_style( "msbr_lic_css" );
    }
    function ActiveAdminMenu(){
        
		//add_submenu_page ( $this->slug,  "MSBR_Lic", "MSBR_Lic", "activate_plugins", $this->slug, [$this,"Activated"], " dashicons-star-filled ");
		//add_submenu_page(  $this->slug, "MSBR_Lic License", "License Info", "activate_plugins",  $this->slug."_license", [$this,"Activated"] );
        
        // add sub menu page
        add_submenu_page(
            $this->slug,
            'Breview General Settings',
            'Breview',
            'manage_options',
            'breview-settings',
            'msbr_breview_general_settings_page'
        );
        // add sub menu page
        add_submenu_page(
            'breview-settings',
            'Breview Style Settings',
            'Style',
            'manage_options',
            'breview-style-settings',
            'msbr_breview_style_settings_page'
        );
        // add sub menu page
        add_submenu_page(
            'breview-settings',
            'Breview Email Settings',
            'Emails',
            'manage_options',
            'breview-email-settings',
            'msbr_breview_email_settings_page'
        );

    }
    function InactiveMenu() {
        //add_submenu_page( 'mswebarts-overview',  "MSBR_Lic", "MSBR_Lic", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], " dashicons-star-filled " );
    }
    function action_activate_license(){
        check_admin_referer( 'el-license' );
        $licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
        $licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
        update_option("msbr_lic_key",$licenseKey) || add_option("msbr_lic_key",$licenseKey);
        update_option("msbr_lic_email",$licenseEmail) || add_option("msbr_lic_email",$licenseEmail);
        update_option('_site_transient_update_plugins','');
        wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
    function action_deactivate_license() {
        check_admin_referer( 'el-license' );
        $message="";
        if(MSBR_Lic_Base::RemoveLicenseKey(__FILE__,$message)){
            update_option("msbr_lic_key","") || add_option("msbr_lic_key","");
            update_option('_site_transient_update_plugins','');
        }
        wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
    function Activated(){
        ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="msbr_lic_el_deactivate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("Breview License Info", 'breview');?> </h3>
                <hr>
                <ul class="el-license-info">
                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("Status", "breview");?></span>

                        <?php if ( $this->responseObj->is_valid ) : ?>
                            <span class="el-license-valid"><?php _e("Valid", "breview");?></span>
                        <?php else : ?>
                            <span class="el-license-valid"><?php _e("Invalid", "breview");?></span>
                        <?php endif; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("License Type", "breview");?></span>
                        <?php echo $this->responseObj->license_title; ?>
                    </div>
                </li>

               <li>
                   <div>
                       <span class="el-license-info-title"><?php _e("License Expired on", "breview");?></span>
                       <?php echo $this->responseObj->expire_date;
                       if(!empty($this->responseObj->expire_renew_link)){
                           ?>
                           <a target="_blank" class="el-blue-btn" href="<?php echo $this->responseObj->expire_renew_link; ?>"><?php echo esc_html_e( 'Renew', 'breview' ) ?></a>
                           <?php
                       }
                       ?>
                   </div>
               </li>

               <li>
                   <div>
                       <span class="el-license-info-title"><?php _e("Support Expired on", "breview");?></span>
                       <?php
                           echo $this->responseObj->support_end;
                        if(!empty($this->responseObj->support_renew_link)){
                            ?>
                               <a target="_blank" class="el-blue-btn" href="<?php echo $this->responseObj->support_renew_link; ?>"><?php echo esc_html_e( 'Renew', 'breview' ) ?></a>
                            <?php
                        }
                       ?>
                   </div>
               </li>
                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("Your License Key", "breview");?></span>
                        <span class="el-license-key"><?php echo esc_attr( substr($this->responseObj->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->responseObj->license_key,-9) ); ?></span>
                    </div>
                </li>
                </ul>
                <div class="el-license-active-btn">
                    <?php wp_nonce_field( 'el-license' ); ?>
                    <?php submit_button('Deactivate'); ?>
                </div>
            </div>
        </form>
    <?php
    }

    function LicenseForm() {
        ?>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="msbr_lic_el_activate_license"/>
        <div class="el-license-container">
            <h3 class="el-license-title"><?php _e("Activate Breview - Better Review System for WooCommerce", "breview");?></h3>
            <hr>
            <?php
            if(!empty($this->showMessage) && !empty($this->licenseMessage)){
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo _e($this->licenseMessage, "breview"); ?></p>
                </div>
                <?php
            }
            ?>
            <p><?php _e("Enter your license key here, to activate the product, and get full feature updates and premium support.", "breview");?></p>
            <ol>
                <li><?php _e("You can get the License Code in your order page", "breview");?></li>
                <li><?php _e("You must activate the license to be able to use the plugin", "breview");?></li>
                <li>
                    <?php _e("Experiencing any issue with the activation? ", "breview");?>
                    <a href="<?php echo esc_url( "https://www.mswebarts.com/support") ?>" target="<?php echo esc_attr( "_blank" ); ?>"><?php _e("Contact Us", "breview");?></a>
                </li>
            </ol>
            <div class="el-license-field">
                <label for="el_license_key"><?php _e("License code", "breview");?></label>
                <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
            </div>
            <div class="el-license-field">
                <label for="el_license_key"><?php _e("Email Address", "breview");?></label>
                <?php
                    $purchaseEmail   = get_option( "msbr_lic_email", get_bloginfo( 'admin_email' ));
                ?>
                <input type="text" class="regular-text code" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">
                <div><small><?php _e("We will send update news of this product by this email address, don't worry, we hate spam", "breview");?></small></div>
            </div>
            <div class="el-license-active-btn">
                <?php wp_nonce_field( 'el-license' ); ?>
                <?php submit_button('Activate'); ?>
            </div>
        </div>
    </form>
        <?php
    }
}

new MSBR_Lic();