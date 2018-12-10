<?php
/**
* Plugin Name: Caldera Forms Anti Spam
* Description: Anti-spam for Caldera Forms. Recaptcha field!
* Author: YooHoo Plugins
* Version: 0.1.1
* Author URI: https://yoohooplugins.com
* Text Domain: caldera-forms-anti-spam
 */

define( 'CF_ANTISPAM_PATH',  plugin_dir_path( __FILE__ ) );
define( 'CF_ANTISPAM_URL',  plugin_dir_url( __FILE__ ) );
define( 'CF_ANTISPAM_VER', '0.1.1' );



add_action( 'caldera_forms_includes_complete', 'cf_antispam_init' );

function cf_antispam_init(){
	Caldera_Forms_Autoloader::add_root( 'CF_Antispam', __DIR__ . '/classes' );
	cf_antispam_init_recpatcha();
}


function cf_antispam_init_recpatcha(){
	$recaptcha = new CF_Antispam_Recapatcha();

	//Replace existing recaptcha field
	add_filter( 'caldera_forms_get_field_types', array( $recaptcha, 'add_field' ), 25 );

	//Prevent removing recaptcha from DOM from being effective bypass of recpatcha
	add_filter( 'caldera_forms_validate_field_recaptcha', array( $recaptcha, 'check_for_captcha' ), 10, 3 );


	add_filter( 'caldera_forms_field_attributes-recaptcha', array( $recaptcha, 'field_attrs' ), 10, 2 );
}
