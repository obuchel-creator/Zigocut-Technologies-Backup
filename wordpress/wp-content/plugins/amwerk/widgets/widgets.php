<?php
// Widgets for Amwerk theme by BoldThemes

function amwerk_register_widgets() {
	register_widget( 'BT_Button_Widget' );
}
add_action( 'widgets_init', 'amwerk_register_widgets' );

// BT_Button_Widget
if ( ! class_exists( 'BT_Button_Widget' ) ) {

	class BT_Button_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_button_widget', // Base ID
				__( 'BT Button', 'bt_plugin' ), // Name
				array( 'description' => __( 'Button Widget.', 'bt_plugin' ) ) // Args
			);
            $this->prefix = 'bt_button_widget';
		}

		public function widget( $args, $instance ) {	                    
			$icon   = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$icon_position = ( ! empty( $instance['icon_position'] ) ) ? $instance['icon_position'] : '';
			$text   = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$url    = ! empty( $instance['url'] ) ? $instance['url'] : '';
			$target = ! empty( $instance['target'] ) ? $instance['target'] : '_self';
			$style  = ! empty( $instance['style'] ) ? $instance['style'] : '';
			$css    = ! empty( $instance['css'] ) ? $instance['css'] : '';

			$class = array();                        
			if ( $icon != '' && $icon != 'no_icon' ) {
					$class[] = 'btIconWidget ';
			}                        

			if ( $icon_position != '' ) {
					$class[] = "btIconWidget" . $icon_position;
			}

			$args['before_widget'] = '<div class="btBox widget_' . $this->prefix . ' ' . implode( ' ', $class ) . '">';
                       
			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
                        
			$output = $this->get_html( $icon, $text, $url, $target, $style, $css );  
			echo $output;
                        
			echo $args['after_widget'];

		}
                
		function get_html( $icon, $text, $url, $target, $style, $css  ) {
				$class = array( $this->prefix , 'bt_bb_button_link' );

				if ( $style != '' ) {
						 $class[] = esc_attr( $this->prefix . '_' . $style );
				}

				if ( $css != '' ) {
						 $class[] = esc_attr( $css );
				}

				if ( $url == '' ) {
						$url = '#';
				}

				$text_output = '';
				if ( $text != '' ) {
						$text_output = '<span class="bt_bb_button_text">' . $text . '</span>';
				}

				$link = '';
				$url = untrailingslashit( $url );
				if ( $url != '' && $url != '#' && substr( $url, 0, 4 ) != 'http' && substr( $url, 0, 5 ) != 'https' && substr( $url, 0, 6 ) != 'mailto' ) {
						$link = amwerk_get_permalink_by_slug( $url );
				} else {
						$link = $url;
				}

				$output = '<a href="' . esc_attr( $link ) . '" target="' . esc_attr( $target ) . '" class="' . implode( ' ', $class ) . '" title="' . esc_attr( $text ) . '">';
				if ( $icon == '' || $icon == 'no_icon' ) {
						$output .= $text_output;
				} else {
						$output .= $text_output . $this->bt_button_widget_get_html( $icon, '', '', '' );
				}
				$output .= '</a>';                        

				return $output;
		}

		public function form( $instance ) {	
			$icon   = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$icon_position   = ! empty( $instance['icon_position'] ) ? $instance['icon_position'] : '';
			$text   = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$url    = ! empty( $instance['url'] ) ? $instance['url'] : '';
			$target = ! empty( $instance['target'] ) ? $instance['target'] : '';
			$style  = ! empty( $instance['style'] ) ? $instance['style'] : '';
			$css    = ! empty( $instance['css'] ) ? $instance['css'] : '';

			$icon_arr = array();
			if ( function_exists( 'boldthemes_get_icon_fonts_bb_array' ) ) {
				$icon_arr = boldthemes_get_icon_fonts_bb_array();
			} else {
                if ( class_exists( 'BoldThemes_BB_Settings') ) {
					require_once( WP_PLUGIN_DIR . '/bold-page-builder/content_elements_misc/fa_icons.php' );
					require_once( WP_PLUGIN_DIR . '/bold-page-builder/content_elements_misc/s7_icons.php' );
					if ( function_exists( 'bt_bb_fa_icons' ) && function_exists( 'bt_bb_s7_icons' ) ) {
						$icon_arr = array( 'Font Awesome' => bt_bb_fa_icons(), 'S7' => bt_bb_s7_icons() );
					}
				}
			}

			$clear_display = $icon != '' ? 'block' : 'none';
			
			$icon_set = '';
			$icon_code = '';
			$icon_name = '';

			if ( $icon != '' ) {
				$icon_set = substr( $icon, 0, -5 );
				$icon_code = substr( $icon, -4 );
				$icon_code = '&#x' . $icon_code;
				foreach( $icon_arr as $k => $v ) {
					foreach( $v as $k_inner => $v_inner ) {
						if ( $icon == $v_inner ) {
							$icon_name = $k_inner;
						}
					}
				}
			}
                        
			?>
			<div class="bt_bb_iconpicker_widget_container">
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon:', 'bt_plugin' ); ?></label>
				<div class="bt_bb_iconpicker">
					<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>">
					<div class="bt_bb_iconpicker_select">
						<div class="bt_bb_icon_preview bt_bb_icon_preview_<?php echo $icon_set; ?>" data-icon="<?php echo $icon; ?>" data-icon-code="<?php echo $icon_code; ?>"></div>
						<div class="bt_bb_iconpicker_select_text"><?php echo $icon_name; ?></div>
						<i class="fa fa-close bt_bb_iconpicker_clear" style="display:<?php echo $clear_display; ?>"></i>
						<i class="fa fa-angle-down"></i>
					</div>
					<div class="bt_bb_iconpicker_filter_container">
						<input type="text" class="bt_bb_filter" placeholder="<?php _e( 'Filter...', 'bt_plugin' ); ?>">
					</div>
					<div class="bt_bb_iconpicker_icons">
						<?php
						$icon_content = '';
						foreach( $icon_arr as $k => $v ) {
							$icon_content .= '<div class="bt_bb_iconpicker_title">' . $k . '</div>';
							foreach( $v as $k_inner => $v_inner ) {
								$icon = $v_inner;
								$icon_set = substr( $icon, 0, -5 );
								$icon_code = substr( $icon, -4 );
								$icon_content .= '<div class="bt_bb_icon_preview bt_bb_icon_preview_' . $icon_set . '" data-icon="' . $icon . '" data-icon-code="&#x' . $icon_code . '" title="' . $k_inner . '"></div>';
							}
						}
						echo $icon_content;
						?>
					</div>
				</div>
			</div>
                        <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>"><?php _e( 'Icon Position:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_position' ) ); ?>">
					<option value=""></option>;
					<?php
					$icon_position_arr = array("Left" => "Left", "Right" => "Right");
					foreach( $icon_position_arr as $key => $value ) {
						if ( $value == $icon_position ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
                        <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( 'URL or slug:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
			</p>
                        <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php _e( 'Target:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>">
					<option value=""></option>;
					<?php
					$target_arr = array("Self" => "_self", "Blank" => "_blank", "Parent" => "_parent", "Top" => "_top");
					foreach( $target_arr as $key => $value ) {
						if ( $value == $target ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
                        <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php _e( 'Style:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
					<option value=""></option>;
					<?php
					$style_arr = array("Accent" => "accent", "Alternate" => "alternate", "Dark" => "dark", "Light" => "light");
					foreach( $style_arr as $key => $value ) {
						if ( $value == $style ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
                        <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>"><?php _e( 'CSS extra class:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'css' ) ); ?>" type="text" value="<?php echo esc_attr( $css ); ?>">
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['icon']   = ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : strip_tags( $old_instance['icon'] );
			$instance['icon_position'] = ( ! empty( $new_instance['icon_position'] ) ) ? strip_tags( $new_instance['icon_position'] ) : '';
			$instance['text']   = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
			$instance['url']    = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
			$instance['target'] = ( ! empty( $new_instance['target'] ) ) ? strip_tags( $new_instance['target'] ) : '';
			$instance['style']  = ( ! empty( $new_instance['style'] ) ) ? strip_tags( $new_instance['style'] ) : '';
			$instance['css']    = ( ! empty( $new_instance['css'] ) ) ? strip_tags( $new_instance['css'] ) : '';			

			return $instance;
		}
                
		public function bt_button_widget_get_html( $icon, $text = '', $url = '', $url_title = '', $target = '' ) {

			$icon_set = substr( $icon, 0, -5 );
			$icon = substr( $icon, -4 );

			$link = amwerk_get_url( $url );

			if ( $text != '' ) {
					if ( $url_title == '' ) $url_title = strip_tags($text);
					$text = '<span>' . $text . '</span>';
			}

			$url_title_attr = '';

			if ( $url_title != '' ) {
					$url_title_attr = ' title="' . esc_attr( $url_title ) . '"';
			}

			if ( $link == '' ) {
					$ico_tag = 'span' . ' ';
					$ico_tag_end = 'span';	
			} else {
					$target_attr = 'target="_self"';
					if ( $target != '' ) {
							$target_attr = ' ' . 'target="' . ( $target ) . '"';
					}
					$ico_tag = 'a href="' . esc_attr( $link ) . '"' . ' ' . $target_attr . ' ' . $url_title_attr . ' ';
					$ico_tag_end = 'a';
			}

			return '<' . $ico_tag . ' data-ico-' . esc_attr( $icon_set ) . '="&#x' . esc_attr( $icon ) . ';" class="bt_bb_icon_holder">' . $text . '</' . $ico_tag_end . '>';
	}
             
	}	
}

