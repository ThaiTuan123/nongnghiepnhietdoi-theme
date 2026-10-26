<?php
/**
 * Nav menu locations. Menu items are managed in WP Admin → Appearance → Menus.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		register_nav_menus(
			array(
				'primary'  => __( 'Menu chính', 'nongnghiepnhietdoi' ),
				'footer_1' => __( 'Chân trang - Về chúng tôi', 'nongnghiepnhietdoi' ),
				'footer_2' => __( 'Chân trang - Tin tức & Sự kiện', 'nongnghiepnhietdoi' ),
				'footer_3' => __( 'Chân trang - Thông tin khác', 'nongnghiepnhietdoi' ),
				'social'   => __( 'Mạng xã hội', 'nongnghiepnhietdoi' ),
			)
		);
	}
);

/**
 * Rewrite the menu item pointing to the static front page so it links to the
 * site root (home_url('/')) instead of its page permalink (e.g. /trang-chu/),
 * and mark it as the current item when viewing the front page.
 */
add_filter(
	'wp_nav_menu_objects',
	function ( $items ) {
		$front_page_id = (int) get_option( 'page_on_front' );

		if ( $front_page_id <= 0 ) {
			return $items;
		}

		foreach ( $items as $item ) {
			$is_front_item = ( 'post_type' === $item->type
				&& 'page' === $item->object
				&& (int) $item->object_id === $front_page_id );

			if ( ! $is_front_item ) {
				continue;
			}

			$item->url = home_url( '/' );

			if ( is_front_page() ) {
				$item->classes[] = 'current-menu-item';
				$item->current    = true;
			}
		}

		return $items;
	}
);

/**
 * Mục menu Liên hệ — bỏ khỏi hàng desktop 3-3 (đã có nút CTA riêng).
 *
 * @param object $item Menu item.
 * @return bool
 */
function nongnghiepnhietdoi_is_contact_menu_item( $item ) {
	$title = trim( wp_strip_all_tags( (string) $item->title ) );
	if ( 0 === strcasecmp( $title, 'Liên hệ' ) || 0 === strcasecmp( $title, 'Contact' ) ) {
		return true;
	}

	$path = wp_parse_url( (string) $item->url, PHP_URL_PATH );
	return is_string( $path ) && (bool) preg_match( '#/lien-he/?$#', $path );
}

/**
 * Chia menu chính desktop: 3 mục trái + 3 mục phải quanh logo.
 * Dùng qua $args->varc_split = 'left' | 'right'.
 */
add_filter(
	'wp_nav_menu_objects',
	function ( $items, $args ) {
		$split = isset( $args->varc_split ) ? (string) $args->varc_split : '';
		if ( 'left' !== $split && 'right' !== $split ) {
			return $items;
		}

		$tops = array();
		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent !== 0 ) {
				continue;
			}
			if ( nongnghiepnhietdoi_is_contact_menu_item( $item ) ) {
				continue;
			}
			$tops[] = $item;
		}

		$slice = ( 'left' === $split )
			? array_slice( $tops, 0, 3 )
			: array_slice( $tops, 3, 3 );

		if ( ! $slice ) {
			return array();
		}

		$keep = array();
		foreach ( $slice as $top ) {
			$keep[ (int) $top->ID ] = true;
		}

		foreach ( $items as $item ) {
			$parent = (int) $item->menu_item_parent;
			if ( $parent && isset( $keep[ $parent ] ) ) {
				$keep[ (int) $item->ID ] = true;
			}
		}

		return array_values(
			array_filter(
				$items,
				static function ( $item ) use ( $keep ) {
					return isset( $keep[ (int) $item->ID ] );
				}
			)
		);
	},
	20,
	2
);
