=== Caldera Forms Anti Spam ===
Contributors: andrewza, yoohooplugins, travislima
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4GC4JEZH7KSKL
Tags: caldera forms, anti-spam, recaptcha
Requires at least: 4.5
Tested up to: 5.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Anti-spam for Caldera Forms. reCAPTCHA and more.
== Description ==

Anti-spam for [Caldera Forms](https://calderaforms.com)

= Adds A Google reCaptcha Field To Caldera Forms =

* Go to [reCAPTCHA Site](https://www.google.com/recaptcha) and click "Get reCpatcha" button.
* In "Register a new site" choose reCAPTCHA v2,v3 or Invisible reCAPTCHA.
* Add your domains and complete form.
* This will show you your new public and secret key.
* On your WordPress site, go to the Caldera Forms editor for form you wish to add a the captcha to.
* Drag "Add Field" bar into the form layout where you want the captcha to appear.
* In field settings enter public and secret keys.


== Installation ==
1. Upload the plugin files to the '/wp-content/plugins' directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to the Caldera Forms editor for form you wish to add a the captcha to.
4. Drag "Add Field" bar into the form layout where you want the captcha to appear.
5. In field settings enter public and secret keys.


== Frequently Asked Questions ==
= Does This Provide A Google reCAPTCHA v3 Field For Caldera Forms =
Yes, this will add a Google reCAPTCHA-powered captcha to your Caldera Form.

= Does This Support V2 and Invisible reCAPTCHA =
Yes, this supports 'legacy' versions of reCaptcha for Caldera Forms.

= How Do I Enable V2 reCAPTCHA =
Add the hidden field to your Caldera Form and do not select V3 or Invisible reCAPTCHA checkboxes.

= How Do I Enable V3 reCAPTCHA =
Once the hidden field is added to your Caldera Form, select the V3 checkbox. (You do not need to select the Invisible reCaptcha option if you have selected this setting).


== Screenshots ==


== Changelog ==

= 0.2 =
* Added invisible reCAPTCHA support and option
* Added reCAPTCHA v3 support and option
* Changed script loader to support both V2 and V3 reCAPTCHA
* Improved JavaScript to better support V2 and V3 reCAPTCHA
* Removed reCAPTCHA field output from email summary

= 0.1.1 =
* Allow more than one recaptcha per page.

= 0.1.0 =
* First release

== Upgrade Notice ==

= 0.2 =
* Please upgrade to support V3 recaptcha and more.

= 0.1.1 =
* Please upgrade for enhancements.

= 0.1.0 =
*First Release
