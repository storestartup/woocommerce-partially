<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: WooCommerce Partial.ly
License: GPLv2 or later
Plugin URI: https://partial.ly
Version: 1.0.0
Description: Add Partial.ly payment plans to your WooCommerce store
*/

function partially_create_button() {
	$template_name = 'partially-checkout.php';
	$custom_template = locate_template($template_name);
	if ($custom_template) {
		load_template($custom_template);
	}
	else {
		include "templates/$template_name";
	}
}

add_action('woocommerce_after_cart_totals', 'partially_create_button');

function partially_options_page() {
	?>
    <div class="wrap">
        <h2>WooCommerce Partial.ly</h2>
        <form method="post" action="options.php">

        <?php
		settings_fields( 'partiallyPluginPage' );
		do_settings_sections( 'partiallyPluginPage' );
		submit_button();
		?>

        </form>
    </div>
    <?php
}

function partially_add_admin_menu() {
	add_options_page('WooCommerce Partial.ly Settings', 'Partial.ly Settings', 
		'manage_options', 'partially-settings', 'partially_options_page');
}

function partially_settings_init() {
	register_setting('partiallyPluginPage', 'partially_settings');

	add_settings_section(
		'partially_pluginPage_section', 
		__( 'Partial.ly Options', 'wordpress' ), 
		'partially_settings_section_callback', 
		'partiallyPluginPage'
	);

	add_settings_field( 
		'partially_offer', 
		__( 'Offer ID', 'wordpress' ), 
		'partially_offer_render', 
		'partiallyPluginPage', 
		'partially_pluginPage_section' 
	);
}

function partially_offer_render(  ) { 
	$options = get_option( 'partially_settings' );
	?>
	<input type='text' name='partially_settings[partially_offer]' value='<?php echo $options['partially_offer']; ?>'>
	<?php
}


function partially_settings_section_callback(  ) { 
	//echo __( 'Partial.ly Settings', 'wordpress' );
}

add_action('admin_menu', 'partially_add_admin_menu');

add_action('admin_init', 'partially_settings_init');

?>