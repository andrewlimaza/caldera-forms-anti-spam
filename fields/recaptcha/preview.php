{{#if config/public_key}}
	{{#if config/private_key}}
		<div id="cap{{id}}" class="g-recaptcha" data-sitekey="{{config/public_key}}" data-theme="{{config/theme}}">
			<img src="<?php echo CF_ANTISPAM_URL . 'assets/recaptcha.png'; ?>" width="50px" height="auto" alt="reCaptcha Logo"/>
			{{#if config/recapv}}
				(<?php _e( 'Using reCaptcha V3 - Invisible by default.', 'cf-anti-spam' ); ?>)
			{{else}}
				{{#if config/invis}} (<?php _e( 'Invisible Recaptcha enabled.', 'cf-anti-spam' ); ?>){{/if}}
			{{/if}}
			</div>
		<!-- before the script yo! -->
		{{#script}}

		jQuery(document).ready( function(){
			if( typeof grecaptcha === 'object' ){

				var captch = jQuery('#cap{{id}}');

				grecaptcha.render( captch[0], {
					"sitekey"	:	"{{config/public_key}}",
					"theme"		:	"{{config/theme}}"
				});
			}
		});

		{{/script}}
	{{else}}
		<p><?php esc_html_e( 'No Secret Key Added', 'cf-anti-spam' ); ?></p>
	{{/if}}
{{else}}
	<p><?php esc_html_e( 'No Site Key Added', 'aldera-forms-anti-spam'); ?></p>
{{/if}}
