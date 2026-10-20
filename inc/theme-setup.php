<?php
/**
 * Theme setup: supports, image sizes, i18n.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'nongnghiepnhietdoi', NONGNGHIEPNHIETDOI_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 96,
				'width'       => 240,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'automatic-feed-links' );

		add_image_size( 'nongnghiepnhietdoi-card', 800, 560, true );
		add_image_size( 'nongnghiepnhietdoi-wide', 1600, 900, true );
	}
);

add_action(
	'init',
	function () {
		// Gỡ post type Bất động sản (du_an) và taxonomy Loại dự án khỏi site.
		if ( '3' !== get_option( 'nongnghiepnhietdoi_rewrite_version' ) ) {
			flush_rewrite_rules( false );
			update_option( 'nongnghiepnhietdoi_rewrite_version', '3' );
		}
	},
	99
);

/**
 * Tạo sẵn các chuyên mục (category) mặc định cho Tin tức: "Phong thủy" và
 * "Dự án". Chỉ chạy 1 lần (được đánh dấu qua option) nên khách có thể xoá/đổi
 * tên tự do sau đó mà không bị tạo lại.
 */
add_action(
	'init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_seeded_news_cats' ) ) {
			return;
		}

		$defaults = array(
			'Phong thủy' => 'phong-thuy',
			'Dự án'      => 'du-an-tin-tuc',
		);

		foreach ( $defaults as $name => $slug ) {
			if ( ! term_exists( $name, 'category' ) && ! term_exists( $slug, 'category' ) ) {
				wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
			}
		}

		update_option( 'nongnghiepnhietdoi_seeded_news_cats', 1 );
	}
);

/**
 * Chuyên mục cho trang Phong thủy (3 section riêng):
 *   - phong-thuy-noi-bat  → "Phong thuỷ nổi bật" (layout 3 bài)
 *   - tin-tuc-su-kien     → "Tin tức & sự kiện"
 *   - kien-thuc-phong-thuy → "Kiến thức phong thuỷ"
 */
add_action(
	'init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_seeded_phong_thuy_cats' ) ) {
			return;
		}

		$defaults = array(
			'Phong thủy nổi bật'  => 'phong-thuy-noi-bat',
			'Tin tức & sự kiện'  => 'tin-tuc-su-kien',
			'Kiến thức phong thủy' => 'kien-thuc-phong-thuy',
		);

		foreach ( $defaults as $name => $slug ) {
			if ( ! term_exists( $name, 'category' ) && ! term_exists( $slug, 'category' ) ) {
				wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
			}
		}

		update_option( 'nongnghiepnhietdoi_seeded_phong_thuy_cats', 1 );
	}
);

add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

/**
 * Add `has-dark-hero` body class when the page starts with a dark hero,
 * so the header can render transparent (white text) without a JS flash.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		$dark = false;

		if ( is_singular( array( 'post', 'du_an' ) ) && has_post_thumbnail() ) {
			$dark = true;
		} elseif ( is_post_type_archive( 'du_an' ) ) {
			$dark = true; // Archive Bất động sản mở đầu bằng hero banner tối.
		} elseif ( is_page_template( 'page-tin-tuc.php' ) || is_page( 'tin-tuc' ) ) {
			$dark = true; // Trang Tin tức mở đầu bằng hero banner tối.
		} elseif ( is_page( array( 'gioi-thieu', 'thiet-ke', 'lien-he' ) ) ) {
			$dark = true; // Trang Giới thiệu / Thiết kế / Liên hệ mở đầu bằng hero banner tối.
		} elseif ( ( is_front_page() || is_page() ) && function_exists( 'get_field' ) ) {
			$sections = get_field( 'page_sections' );
			if ( ! empty( $sections[0]['acf_fc_layout'] ) && 'hero' === $sections[0]['acf_fc_layout'] ) {
				$dark = true;
			}
		} elseif ( is_front_page() && ! function_exists( 'get_field' ) ) {
			$dark = true; // Placeholder hero is dark.
		}

		if ( $dark ) {
			$classes[] = 'has-dark-hero';
		}
		return $classes;
	}
);
