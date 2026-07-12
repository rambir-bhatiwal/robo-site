<?php
/**
 * Custom Bootstrap 5 NavWalker.
 *
 * @package Robo
 */

if ( ! class_exists( 'Robo_WP_Bootstrap_Navwalker' ) ) {
	class Robo_WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

		/**
		 * Start Level.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth  Depth of page. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			$indent = str_repeat( "\t", $depth );
			$classes = array( 'dropdown-menu' );
			
			// Handle multi-level nested dropdowns.
			if ( $depth > 0 ) {
				$classes[] = 'submenu';
			}
			
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$output .= "\n$indent<ul class=\"$class_names\" aria-labelledby=\"dropdown-menu-" . esc_attr( $depth ) . "\">\n";
		}

		/**
		 * Start Element.
		 *
		 * @see Walker::start_el()
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param WP_Post $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$has_children = in_array( 'menu-item-has-children', $classes, true );

			// LI classes.
			$li_classes = array();
			if ( 0 === $depth ) {
				$li_classes[] = 'nav-item';
				if ( $has_children ) {
					$li_classes[] = 'dropdown';
				}
			} else {
				if ( $has_children ) {
					$li_classes[] = 'dropdown-submenu';
				}
			}

			// Active state.
			if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
				$li_classes[] = 'active';
			}

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $li_classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$output .= $indent . '<li' . $class_names . '>';

			// Anchor attributes.
			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			if ( 0 === $depth ) {
				$atts['class'] = 'nav-link';
				if ( $has_children ) {
					$atts['class']         .= ' dropdown-toggle';
					$atts['data-bs-toggle'] = 'dropdown';
					$atts['role']           = 'button';
					$atts['aria-haspopup']  = 'true';
					$atts['aria-expanded']  = 'false';
					$atts['id']             = 'nav-dropdown-' . $item->ID;
				}
			} else {
				$atts['class'] = 'dropdown-item';
				if ( $has_children ) {
					$atts['class']         .= ' dropdown-toggle';
					$atts['data-bs-toggle'] = 'dropdown';
					$atts['role']           = 'button';
					$atts['aria-haspopup']  = 'true';
					$atts['aria-expanded']  = 'false';
					$atts['id']             = 'nav-dropdown-' . $item->ID;
				}
			}

			// Add active class to anchor link too.
			if ( in_array( 'current-menu-item', $classes, true ) ) {
				$atts['class'] .= ' active';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			// Check for custom icons.
			$icon_html = '';
			if ( ! empty( $item->icon ) ) {
				$icon_html = '<i class="' . esc_attr( $item->icon ) . ' me-1"></i> ';
			}

			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . $icon_html . $title . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}
