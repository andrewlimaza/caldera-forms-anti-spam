<?php
/**
 * Renders the field in the visitor-facing form
 *
 * @package caldera-forms-anti-spam
 */

$recaptcha_version = ( ! empty( $field['config']['recapv'] ) && 1 === $field['config']['recapv'] ) ? 'v3' : 'v2';

// phpcs:disable
echo $wrapper_before;
// phpcs:enable

if ( 'v2' === $recaptcha_version ) {
	echo esc_html( $field_label );
}

if ( false !== strpos( $field_input_class, 'has-error' ) ) {
	echo '<span class="has-error">';
	echo esc_html( $field_caption );
	echo '</span>';
}

if ( empty( $field['config']['public_key'] ) ) {
	$field['config']['public_key'] = null;
}

/**
 * We have moved the enqueue here as this allows us to alter the URL on the fly
*/
$language = get_locale();
if ( 'v3' === $recaptcha_version ) {
	$script_url = 'https://www.google.com/recaptcha/api.js?render=' . trim( $field['config']['public_key'] ) . '&hl=' . $language;
} else {
	$script_url = 'https://www.google.com/recaptcha/api.js?render=explicit&onload=cf_recaptcha_is_ready&hl=' . $language;
}
wp_enqueue_script( 'cf-anti-spam-recapthca-lib', $script_url, array(), 1, true );

// phpcs:disable
echo $field_before;
// phpcs:enable

if ( 'v3' === $recaptcha_version ) {
	echo '<div id="cap' . esc_html( $field_id ) . '"></div>';
} else {
	// phpcs:disable
	echo Caldera_Forms_Field_Input::html( $field, $field_structure, $form );
	// phpcs:enable
	?>
	<div id="cap<?php echo esc_html( $field_id ); ?>" class="g-recaptcha" data-sitekey="<?php echo esc_html( $field['config']['public_key'] ); ?>" 
		<?php
		if ( ! empty( $field['config']['invis'] ) && 1 === $field['config']['invis'] ) {
			echo ' data-size="invisible" ';}
		?>
		</div>
	<?php
}

// phpcs:disable
echo $field_caption;
echo $field_after;
echo $wrapper_after;
// phpcs:enable

ob_start();
?>
	<script>
		var cf_recaptcha_executed = false;
		var cf_recaptcha_execute = function ( event, obj ) {
			grecaptcha.ready( function () {
				var cf_form = jQuery('#cap<?php echo esc_html( $field_id ); ?>').parents('form:first');
				var cf_form_name = cf_form.attr('aria-label').replace(/[^a-zA-Z]+/g, '_') || 'homepage';
				grecaptcha.execute("<?php echo esc_html( trim( $field['config']['public_key'] ) ); ?>", {action: cf_form_name}).then( function (token) {
					var captch = jQuery('#cap<?php echo esc_html( $field_id ); ?>');
					var captchToken = jQuery('#captoken<?php echo esc_html( $field_id ); ?>');
					if (captchToken.length === 0) {
						jQuery('<input type="hidden" id="captoken<?php echo esc_html( $field_id ); ?>" name="cf-recapv-token" value="' + token + '">').insertAfter(captch[0]);
					} else {
						captchToken.val(token);
					}
					obj.inst.validationResult = true;
					cf_recaptcha_executed = true;
					cf_form.submit();
				});
			});
		}
		var cf_recaptcha_is_ready = function (){
			<?php if ( 'v2' === $recaptcha_version ) { ?>
				var captch = jQuery('#cap<?php echo esc_html( $field_id ); ?>');
				captch.empty();

				grecaptcha.render( captch[0], { "sitekey" : "<?php echo esc_html( trim( $field['config']['public_key'] ) ); ?>", "theme" : "<?php echo esc_html( isset( $field['config']['theme'] ) ? $field['config']['theme'] : 'light' ); ?>" } );

				// Only load grecaptcha.execute if it's set to invisible mode.
				<?php
				if ( ! empty( $field['config']['invis'] ) && 1 === $field['config']['invis'] ) {
					?>
					grecaptcha.execute(); <?php } ?>
			<?php } ?>
		}
		jQuery(document).on('cf.validate.FormSuccess', function( event, obj ){
			if ( cf_recaptcha_executed === false ) {
				///make invalid until we finish the grecaptcha execution
				obj.inst.validationResult = false;
				cf_recaptcha_execute( event, obj );
			}
		});
	</script>
<?php
$script_template = ob_get_clean();
Caldera_Forms_Render_Util::add_inline_data( $script_template, $form );

