<input type="hidden" value="1" name="config[fields][{{_id}}][required]" class="field-config">

<p class="description" style="text-align:center;">
	<?php esc_html_e('reCaptcha required keys from Google.', 'caldera-forms-anti-spam'); ?><a href="https://www.google.com/recaptcha" target="_blank"> Visit reCAPTCHA</a>
</p>
<div class="caldera-config-group">
	<label for="{{_id}}_public">
        <?php esc_html_e('Site Key', 'caldera-forms-anti-spam'); ?>
    </label>
	<div class="caldera-config-field">
		<input type="text" id="{{_id}}_public" class="block-input field-config required" name="{{_name}}[public_key]" value="{{public_key}}">
	</div>
</div>
<div class="caldera-config-group">
	<label for="{{_id}}_secret">
        <?php esc_html_e('Secret Key', 'caldera-forms-anti-spam'); ?>
    </label>
	<div class="caldera-config-field">
		<input id="{{_id}}_secret" type="text" class="block-input field-config required" name="{{_name}}[private_key]" value="{{private_key}}">
	</div>
</div>

