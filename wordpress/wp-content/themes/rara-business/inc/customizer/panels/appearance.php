<?php
/**
 * Appearance Setting Panel
 *
 * @package Rara_Business
 */

if ( ! function_exists( 'rara_business_customize_register_appearance_settings_panel' ) ) :
	/**
	 * Add appearance settings panel
	 */
	function rara_business_customize_register_appearance_settings_panel( $wp_customize ) {

	    $wp_customize->add_panel( 'appearance_settings_panel', array(
	        'title'          => __( 'Appearance Settings', 'rara-business' ),
	        'priority'       => 60,
	        'capability'     => 'edit_theme_options',
	    ) );

		/** Typography */
		$wp_customize->add_section(
			'typography_settings',
			array(
				'title'    => __( 'Typography', 'rara-business' ),
				'priority' => 70,
				'panel'    => 'appearance_settings',
			)
		);

		$wp_customize->add_setting(
			'ed_localgoogle_fonts',
			array(
				'default'           => false,
				'sanitize_callback' => 'rara_business_sanitize_checkbox',
			)
		);
		
		$wp_customize->add_control(
			'ed_localgoogle_fonts',
			array(
				'label'   => __( 'Load Google Fonts Locally', 'rara-business' ),
				'section' => 'typography_settings',
				'type'    => 'checkbox',
			)
		);
	
		$wp_customize->add_setting(
			'ed_preload_local_fonts',
			array(
				'default'           => false,
				'sanitize_callback' => 'rara_business_sanitize_checkbox',
			)
		);
		
		$wp_customize->add_control(
			'ed_preload_local_fonts',
			array(
				'label'           => __( 'Preload Local Fonts', 'rara-business' ),
				'section'         => 'typography_settings',
				'type'            => 'checkbox',
				'active_callback' => 'rara_business_flush_fonts_callback'
			)
		);
		
	
		$wp_customize->add_setting(
			'flush_google_fonts',
			array(
				'default'           => '',
				'sanitize_callback' => 'wp_kses',
			)
		);
	
		$wp_customize->add_control(
			'flush_google_fonts',
			array(
				'label'       => __( 'Flush Local Fonts Cache', 'rara-business' ),
				'description' => __( 'Click the button to reset the local fonts cache.', 'rara-business' ),
				'type'        => 'button',
				'settings'    => array(),
				'section'     => 'typography_settings',
				'input_attrs' => array(
					'value' => __( 'Flush Local Fonts Cache', 'rara-business' ),
					'class' => 'button button-primary flush-it',
				),
				'active_callback' => 'rara_business_flush_fonts_callback'
			)
		);
	    
	    // Move default section to apperance settings panel
		$wp_customize->get_section( 'background_image' )->panel = 'appearance_settings_panel';
		$wp_customize->get_section( 'colors' )->panel           = 'appearance_settings_panel';
		$wp_customize->get_section( 'typography_settings' )->panel              = 'appearance_settings_panel';
	}
endif;
add_action( 'customize_register', 'rara_business_customize_register_appearance_settings_panel' );

function rara_business_flush_fonts_callback( $control ){
    $ed_localgoogle_fonts   = $control->manager->get_setting( 'ed_localgoogle_fonts' )->value();
    $control_id   = $control->id;
    
    if ( $control_id == 'flush_google_fonts' && $ed_localgoogle_fonts ) return true;
    if ( $control_id == 'ed_preload_local_fonts' && $ed_localgoogle_fonts ) return true;
    return false;
}