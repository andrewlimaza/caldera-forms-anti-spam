<?php
class CF_Antispam_Recapatcha {
	/**
	 * Overwrite old field in Caldera Forms
	 *
	 * @since 0.1.0
	 *
	 * @uses "caldera_forms_get_field_types" filter
	 *
	 * @param array $fields Registered fields
	 *
	 * @return array
	 */
	public function add_field( $fields ){

		$fields[ 'recaptcha'  ]      = array(
			"field"       => __( 'reCAPTCHA', 'cf-anti-spam' ),
			"description" => __( 'reCAPTCHA anti-spam field', 'cf-anti-spam' ),
			"file"        => CF_ANTISPAM_PATH . "fields/recaptcha/field.php",
			"category"    => __( 'Special', 'cf-anti-spam' ),
			"handler"     => array( $this, 'handler' ),
			"capture"     => false,
			"setup"       => array(
			"template"      => CF_ANTISPAM_PATH . "fields/recaptcha/config.php",
			"preview"       => CF_ANTISPAM_PATH . "fields/recaptcha/preview.php",
			"not_supported" => array(
				'caption',
			'required'
				),
			),
			/*"scripts" => array( 'https://www.google.com/recaptcha/api.js?onload=cf_recaptcha_is_ready&render=explicit&hl=' . $language )*/
		);

		return $fields;
	}

	/**
	 * Remove the recaptcha field type from the summary email using the caldera hook
	 *
	 * @since 0.2
	 *
	 * @uses "caldera_forms_summary_magic_fields" filter
	 *
	 * @param array $fields Fields in form submission
	 * @param object $form Form object from caldera
	 *
	 * @return array
	 */
	public function remove_from_summary( $fields, $form ){
		if(!empty($fields)){
			foreach($fields as $field_id => $field){
				$type = Caldera_Forms_Field_Util::get_type($field, $form);
				if($type === 'recaptcha'){
					unset($fields[$field_id]);
				}
			}
		}

		return $fields;
	}

	/**
	 * Modify field attributes so recpatcha field has type "hidden" not "recpatcha"
	 *
	 * @since 0.1.0
	 *
	 * @uses "caldera_forms_field_attributes-recaptcha" filter
	 *
	 * @param $attrs
	 * @param $form
	 *
	 * @return array
	 */
	public function field_attrs( $attrs, $form ){
		$attrs[ 'type' ] = 'hidden';
		return $attrs;
	}
	/**
	 * Check that the recaptcha response is sent on forms that have a recapthca field.
	 *
	 * @since 0.1.0
	 *
	 * @uses "caldera_forms_validate_field_recaptcha"
	 *
	 * @param $entry
	 * @param $field
	 * @param $form
	 *
	 * @return WP_Error|boolean
	 */
	public function check_for_captcha( $entry, $field, $form   ){
		if ( ! isset( $_POST[ 'g-recaptcha-response' ] ) || empty( $_POST[ 'g-recaptcha-response' ] ) ) {
			return new WP_Error( 'error' );
		}
		return true;
	}
	/**
	 * Field handler -- checks for recaptcha and verifies  it if possible
	 *
	 * @since 0.1.0
	 *
	 * @param string $value Field value, should be empty
	 * @param array $field Field config
	 * @param array $form Form config
	 *
	 * @return WP_Error|boolean
	 */
	public function handler( $value, $field, $form ){

		/**
		 * Check if this is V3, then we grab the dynamically generated field value
		*/
		if (!empty($field['config']['recapv']) && $field['config']['recapv'] === 1 ) {
			if(!empty($_POST['cf-recapv-token'])){
				$_POST[ 'g-recaptcha-response' ] = $_POST['cf-recapv-token'];
			}
		}

		if ( ! isset( $_POST[ 'g-recaptcha-response' ] ) || empty( $_POST[ 'g-recaptcha-response' ] ) ) {
			return new WP_Error( 'error' );
		}
		$args = array(
			'secret'   => $field[ 'config' ][ 'private_key' ],
			'response' => sanitize_text_field( $_POST[ 'g-recaptcha-response' ] )
		);
		$request = wp_remote_get( add_query_arg( $args, 'https://www.google.com/recaptcha/api/siteverify' ) );
		$result  = json_decode( wp_remote_retrieve_body( $request ) );
		if ( empty( $result->success ) ) {
			return new WP_Error( 'error',
				__( "The captcha wasn't entered correctly.", 'cf-anti-spam' ) . ' <a href="#" class="reset_' . sanitize_text_field( $_POST[ $field[ 'ID' ] ] ) . '">' . __( 'Reset', 'cf-anti-spam' ) . '<a>.'
			);
		}
		return true;
	}
}