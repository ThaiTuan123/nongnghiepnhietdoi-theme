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

/**
 * Chuyên mục của khối Tin tức trên trang chủ.
 *
 * @return WP_Term|null
 */
function nongnghiepnhietdoi_activity_news_term() {
	$term = get_term_by( 'slug', 'tin-tuc-hoat-dong', 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		$term = get_term_by( 'name', 'Tin tức hoạt động', 'category' );
	}

	return ( $term && ! is_wp_error( $term ) ) ? $term : null;
}

/**
 * Chuyên mục của khối Dự án tiêu biểu trên trang chủ.
 *
 * @return WP_Term|null
 */
function nongnghiepnhietdoi_featured_project_term() {
	$term = get_term_by( 'slug', 'du-an-tieu-bieu', 'category' );
	if ( $term && ! is_wp_error( $term ) ) {
		return $term;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		)
	);
	if ( is_wp_error( $terms ) ) {
		return null;
	}

	foreach ( $terms as $candidate ) {
		$name = mb_strtolower( trim( (string) $candidate->name ) );
		if ( 'dự án tiêu biểu' === $name || 'du an tieu bieu' === $name ) {
			return $candidate;
		}
	}

	return null;
}

/**
 * Tạo chuyên mục "Tin tức hoạt động" nếu chưa có, để gắn bài trên trang chủ.
 */
add_action(
	'init',
	static function () {
		if ( nongnghiepnhietdoi_activity_news_term() ) {
			return;
		}

		wp_insert_term(
			'Tin tức hoạt động',
			'category',
			array( 'slug' => 'tin-tuc-hoat-dong' )
		);
	},
	6
);

/**
 * Tạo chuyên mục "Dự án tiêu biểu" nếu chưa có, để gắn bài trên trang chủ.
 */
add_action(
	'init',
	static function () {
		if ( nongnghiepnhietdoi_featured_project_term() ) {
			return;
		}

		wp_insert_term(
			'Dự án tiêu biểu',
			'category',
			array( 'slug' => 'du-an-tieu-bieu' )
		);
	},
	6
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
		} elseif ( is_category() ) {
			$dark = true; // Archive chuyên mục mở đầu bằng hero banner tối.
		} elseif ( is_post_type_archive( 'du_an' ) ) {
			$dark = true; // Archive Bất động sản mở đầu bằng hero banner tối.
		} elseif ( is_page_template( 'page-tin-tuc.php' ) || is_page( 'tin-tuc' ) ) {
			$dark = true; // Trang Tin tức mở đầu bằng hero banner tối.
		} elseif ( is_page( array( 'gioi-thieu', 'thiet-ke', 'lien-he', 'chinh-sach-bao-mat', 've-chung-toi', 'linh-vuc-dich-vu', 'du-an-tac-dong', 'thu-vien-tin-tuc', 'hop-tac-du-an', 'hoi-dong-co-van-ban-dieu-hanh', 'doi-tac-nha-tai-tro' ) ) || is_page_template( array( 'page-ve-chung-toi.php', 'page-linh-vuc-dich-vu.php', 'page-du-an-tac-dong.php', 'page-thu-vien-tin-tuc.php', 'page-hop-tac-du-an.php', 'page-hoi-dong-co-van-ban-dieu-hanh.php', 'page-doi-tac-nha-tai-tro.php' ) ) ) {
			$dark = true; // Các trang mở đầu bằng hero banner tối.
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

/**
 * Tạo trang Liên hệ (slug lien-he) nếu chưa có, để nút header mở được trang.
 *
 * @return int
 */
function nongnghiepnhietdoi_contact_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_contact_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		if ( 'page-lien-he.php' !== get_page_template_slug( $stored ) ) {
			update_post_meta( $stored, '_wp_page_template', 'page-lien-he.php' );
		}
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'lien-he',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_post_meta( $page_id, '_wp_page_template', 'page-lien-he.php' );
		if ( 'publish' !== get_post_status( $page_id ) ) {
			wp_update_post(
				array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				)
			);
		}
		update_option( 'nongnghiepnhietdoi_contact_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Liên hệ',
			'post_name'   => 'lien-he',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-lien-he.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_contact_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_contact_page_id();
	},
	4
);
