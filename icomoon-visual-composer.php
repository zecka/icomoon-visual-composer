<?php
/*
Plugin Name: Icomoon in visual composer
Author: Robin Ferrari
Version: 0.0.1
Author URI: https://robinferrari.ch
*/


// Add new custom font to Font Family selection in icon box module
function zeckart_add_new_icon_set_to_iconbox( ) {
	$param = WPBMap::getParam( 'vc_icon', 'type' );
	$param['value'][__( 'IcoMoon', 'total' )] = 'icomoon';
	vc_update_shortcode_param( 'vc_icon', $param );
}
add_filter( 'init', 'zeckart_add_new_icon_set_to_iconbox', 40 );

// Add font picker setting to icon box module when you select your font family from the dropdown
function zeckart_add_font_picker() {
	vc_add_param( 'vc_icon', array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'total' ),
			'param_name' => 'icon_icomoon',
			'settings' => array(
				'emptyIcon' => true,
				'type' => 'icomoon',
				'iconsPerPage' => 200,
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'icomoon',
			),
		)
	);
}
add_filter( 'vc_before_init', 'zeckart_add_font_picker', 1 );

// Add array of your fonts so they can be displayed in the font selector
function zeckart_icon_array() {
	return array(
		array('icomoon icon-droplet' => 'droplet'),
		array('icomoon icon-pencil' => 'pencil'),
		array('icomoon icon-home' => 'home')
	);
}
add_filter( 'vc_iconpicker-type-icomoon', 'zeckart_icon_array' );


/**
 * Register Backend and Frontend CSS Styles
 */
add_action( 'vc_base_register_front_css', 'zeckart_vc_iconpicker_base_register_css' );
add_action( 'vc_base_register_admin_css', 'zeckart_vc_iconpicker_base_register_css' );
function zeckart_vc_iconpicker_base_register_css(){
    wp_register_style('icomoon',plugin_dir_url( __FILE__ ) . 'icomoon/style.css');
}

/**
 * Enqueue Backend and Frontend CSS Styles
 */
add_action( 'vc_backend_editor_enqueue_js_css', 'zeckart_vc_iconpicker_editor_jscss' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'zeckart_vc_iconpicker_editor_jscss' );
function zeckart_vc_iconpicker_editor_jscss(){
    wp_enqueue_style( 'icomoon' );
}

/**
 * Enqueue CSS in Frontend when it's used
 */
add_action('vc_enqueue_font_icon_element', 'zeckart_enqueue_font_icomoon');
function zeckart_enqueue_font_icomoon($font){
    switch ( $font ) {
        case 'icomoon': wp_enqueue_style( 'icomoon' );
    }
}