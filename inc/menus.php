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
