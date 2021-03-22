<?php
/**
 * Renders the field in the visitor-facing form
 *
 * @package caldera-forms-anti-spam
 */

echo $wrapper_before; ?>

<?php echo empty( $field['config']['recapv'] ) ? $field_label : ''; ?>

<?php

if(false !== strpos($field_input_class, 'has-error')){
	echo '<span class="has-error">';
	echo 	$field_caption;
	echo '</span>';
}

if( empty( $field['config']['public_key'] ) ){
	$field['config']['public_key'] = null;
}

/**
 We have moved the enqueue here as this allows us to alter the URL on the fly
*/
$language = get_locale();
$script_url = "https://www.google.com/recaptcha/api.js?onload=cf_recaptcha_is_ready&render=explicit&hl=" . $language;
if (!empty($field['config']['recapv']) && $field['config']['recapv'] === 1 ) {
	$script_url = "https://www.google.com/recaptcha/api.js?onload=cf_recaptcha_is_ready&render=" . trim($field['config']['public_key']) . "&hl=" . $language;
}
// wp_enqueue_script('cf-anti-spam-recapthca-lib', $script_url);

?>

<?php echo $field_before; ?>

<?php echo Caldera_Forms_Field_Input::html( $field, $field_structure, $form ); ?>

<?php if (!empty($field['config']['recapv']) && $field['config']['recapv'] === 1 ) { ?>
	<div id="cap<?php echo $field_id; ?>"></div>
<?php } else { ?>
	<div id="cap<?php echo $field_id; ?>" class="g-recaptcha" data-sitekey="<?php echo $field['config']['public_key']; ?>" <?php if (!empty($field['config']['invis']) && $field['config']['invis'] === 1 ) { ?>data-size="invisible" <?php } ?>></div>
<?php } ?>

<script>
	if(!window.cf_anti_loading_recaptcha) {
		window.cf_anti_loading_recaptcha = true;
		jQuery('.cf_anti_capfld').html('');
		jQuery('script[src="<?php echo $script_url ?>"]').remove();
		jQuery('<script>').attr('src', "<?php echo $script_url ?>").appendTo('body');
	}
</script>

<?php echo $field_caption; ?>

<?php echo $field_after; ?>

<?php
	echo $wrapper_after;
	ob_start();
?>

<script>

	var cf_recaptcha_is_ready = function (){
		window.cf_anti_loading_recaptcha = false;
		jQuery(document).trigger("cf-anti-init-recaptcha");
	}

	jQuery( function($){
        function init_recaptcha_<?php echo $field_id; ?>(){

            var captch = jQuery('#cap<?php echo $field_id; ?>').addClass('cf_anti_capfld');
            <?php if (!empty($field['config']['recapv']) && $field['config']['recapv'] === 1 ) { ?>
            grecaptcha.ready(function() {
                var captch = jQuery('#cap<?php echo $field_id; ?>');
                grecaptcha.execute("<?php echo trim( $field['config']['public_key'] ); ?>", {action: 'homepage'}).then(function(token) {
					if( token !== "" ){ $("#cf-recapv-token").val( token ); }
                });
            });
            <?php } else { ?>

            captch.empty();


            grecaptcha.render( captch[0], { "sitekey" : "<?php echo trim( $field['config']['public_key'] ); ?>", "theme" : "<?php echo isset( $field['config']['theme'] ) ? $field['config']['theme'] : "light"; ?>" } );

            // Only load grecaptcha.execute if it's set to invisible mode.
            <?php if ( !empty( $field['config']['invis']) && $field['config']['invis'] === 1 ) { ?> grecaptcha.execute(); <?php } ?>
            <?php } ?>
        }

		jQuery(document).on("cf-anti-init-recaptcha", function(){
			setTimeout( init_recaptcha_<?php echo $field_id; ?>(), 1000 );
		});
	});

</script>

<?php

	$script_template = ob_get_clean();

	Caldera_Forms_Render_Util::add_inline_data( $script_template, $form );