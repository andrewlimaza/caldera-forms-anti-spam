<?php echo $wrapper_before; ?>
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

?>

<?php echo $field_before; ?>

<?php echo Caldera_Forms_Field_Input::html( $field, $field_structure, $form ); ?>

<div id="cap<?php echo $field_id; ?>" class="g-recaptcha" data-sitekey="<?php echo $field['config']['public_key']; ?>" <?php if (!empty($field['config']['invis']) && $field['config']['invis'] === 1 ) { ?>data-size="invisible" <?php } ?>></div>

<img onload="cf_load_recaptcha_<?php echo $field_id; ?>()" style="position:fixed;top:0;left:0;" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" />

<?php echo $field_caption; ?>

<?php echo $field_after; ?>

<?php
	echo $wrapper_after;
	ob_start();
?>

	<script>

		var cf_recaptcha_is_ready = function (){
			window.cf_anti_recaptcha_loading = false;
			window.cf_anti_recaptcha_load = true;
			jQuery(document).trigger("cf-anti-init-recaptcha");
		}

var cf_load_recaptcha_<?php echo $field_id; ?> = function() {
	if(!window.cf_anti_recaptcha_load) {
		jQuery(document).on("cf-anti-init-recaptcha", function(){
			jQuery(document).on('click', '.reset_<?php echo $field_id; ?>', function(e){
				e.preventDefault();
				cf_init_recaptcha_<?php echo $field_id; ?>();
			});
			cf_init_recaptcha_<?php echo $field_id; ?>();
		});
		if(!window.cf_anti_recaptcha_loading) {
			jQuery('<script>').attr('src', "<?php echo $script_url ?>").appendTo('body');
			window.cf_anti_recaptcha_loading = true;
		}
	}
	else {
		jQuery('#cap<?php echo $field_id; ?>').html('');
		cf_init_recaptcha_<?php echo $field_id; ?>();
	}
}

var cf_init_recaptcha_<?php echo $field_id; ?> = function() {

					var captch = jQuery('#cap<?php echo $field_id; ?>');
					<?php if (!empty($field['config']['recapv']) && $field['config']['recapv'] === 1 ) { ?>
						grecaptcha.ready(function() {
						var captch = jQuery('#cap<?php echo $field_id; ?>');
					      	grecaptcha.execute("<?php echo trim( $field['config']['public_key'] ); ?>", {action: 'homepage'}).then(function(token) {
					          jQuery('<input type="hidden" name="cf-recapv-token" value="' + token + '">').insertAfter(captch[0]);
					      	});;
					  	});
					<?php } else { ?>

						captch.empty();


						grecaptcha.render( captch[0], { "sitekey" : "<?php echo trim( $field['config']['public_key'] ); ?>", "theme" : "<?php echo isset( $field['config']['theme'] ) ? $field['config']['theme'] : "light"; ?>" } );

						// Only load grecaptcha.execute if it's set to invisible mode.
						<?php if ( !empty( $field['config']['invis']) && $field['config']['invis'] === 1 ) { ?> grecaptcha.execute(); <?php } ?>
					<?php } ?>
				}

	</script>

	<?php

		$script_template = ob_get_clean();

		Caldera_Forms_Render_Util::add_inline_data( $script_template, $form );
