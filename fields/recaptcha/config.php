<input type="hidden" value="1" name="config[fields][{{_id}}][required]" class="field-config">

<p class="description" style="text-align:center;">
	<?php esc_html_e('reCAPTCHA required keys from Google.', 'cf-anti-spam'); ?><a href="https://www.google.com/recaptcha" target="_blank"> Visit reCAPTCHA</a>
</p>

<div class="caldera-config-group">
    <label for="{{_id}}_recapv">
        <?php esc_html_e('Use reCAPTCHA V3', 'cf-anti-spam'); ?>
    </label>
    <div class="caldera-config-field">
        <input id="{{_id}}_recapv" type="checkbox" class="field-config" name="{{_name}}[recapv]" value="1" {{#if recapv}}checked="checked"{{/if}} >
    </div>
</div>

{{#if recapv}}
<br>
<p class="description" style="text-align:left;">
    <?php esc_html_e('reCAPTCHA V3 returns a score for each request without user friction', 'cf-anti-spam'); ?>
</p>
{{else}}
<div class="caldera-config-group">
	<label for="{{_id}}_invis">
        <?php esc_html_e('Invisible reCAPTCHA', 'cf-anti-spam'); ?>
    </label>
	<div class="caldera-config-field">
		<input id="{{_id}}_invis" type="checkbox" class="field-config" name="{{_name}}[invis]" value="1" {{#if invis}}checked="checked"{{/if}} >
        <small><?php esc_html_e('Automatically enabled with V3 reCAPTCHA', 'cf-anti-spam'); ?></small>
	</div>
</div>
{{/if}}

<div class="caldera-config-group">
	<label for="{{_id}}_public">
        <?php esc_html_e('Site Key', 'cf-anti-spam'); ?>
    </label>
	<div class="caldera-config-field">
		<input type="text" id="{{_id}}_public" class="block-input field-config required" name="{{_name}}[public_key]" value="{{public_key}}">
	</div>
</div>

<div class="caldera-config-group">
	<label for="{{_id}}_secret">
        <?php esc_html_e('Secret Key', 'cf-anti-spam'); ?>
    </label>
	<div class="caldera-config-field">
		<input id="{{_id}}_secret" type="text" class="block-input field-config required" name="{{_name}}[private_key]" value="{{private_key}}">
	</div>
</div>
