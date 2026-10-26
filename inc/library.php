<?php
/**
 * Thư viện & Tin tức: chuyên mục, trang và truy vấn bài viết.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ba chuyên mục hiển thị trên trang Thư viện & Tin tức.
 *
 * @return array<int, array{name: string, slug: string}>
 */
function nongnghiepnhietdoi_library_categories() {
	return array(
		array(
			'name' => 'Công trình nghiên cứu và báo cáo',
			'slug' => 'cong-trinh-nghien-cuu-va-bao-cao',
		),
		array(
			'name' => 'Cẩm nang kỹ thuật cho nông dân',
			'slug' => 'cam-nang-ky-thuat-cho-nong-dan',
		),
		array(
			'name' => 'Video & Infographic',
			'slug' => 'video-infographic',
		),
	);
}

/**
 * Tạo chuyên mục thư viện nếu chưa có. Không ghi đè tên khách đã sửa.
 */
function nongnghiepnhietdoi_seed_library_categories() {
	foreach ( nongnghiepnhietdoi_library_categories() as $category ) {
		if ( term_exists( $category['slug'], 'category' ) || term_exists( $category['name'], 'category' ) ) {
			continue;
		}
		wp_insert_term(
			$category['name'],
			'category',
			array( 'slug' => $category['slug'] )
		);
	}
}

/**
 * ID trang Thư viện & Tin tức, tạo trang nếu chưa có.
 */
function nongnghiepnhietdoi_library_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_library_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		$page_id = $stored;
		if ( 'page-thu-vien-tin-tuc.php' !== get_page_template_slug( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-thu-vien-tin-tuc.php' );
		}
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'thu-vien-tin-tuc',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_post_meta( $page_id, '_wp_page_template', 'page-thu-vien-tin-tuc.php' );
		update_option( 'nongnghiepnhietdoi_library_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'   => 'Thư viện & Tin tức',
			'post_name'    => 'thu-vien-tin-tuc',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-thu-vien-tin-tuc.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_library_page_id', $page_id, false );
	return $page_id;
}

/**
 * URL trang thư viện, kèm bộ lọc danh mục nếu có.
 *
 * @param string $slug Slug chuyên mục, rỗng = tất cả.
 */
function nongnghiepnhietdoi_library_url( $slug = '' ) {
	$page_id = nongnghiepnhietdoi_library_page_id();
	$url     = $page_id ? get_permalink( $page_id ) : home_url( '/thu-vien-tin-tuc/' );
	if ( $slug ) {
		$url = add_query_arg( 'danh_muc', $slug, $url );
	}
	return $url;
}

/**
 * Term objects của ba chuyên mục thư viện, theo thứ tự cố định.
 *
 * @return WP_Term[]
 */
function nongnghiepnhietdoi_library_terms() {
	$terms = array();
	foreach ( nongnghiepnhietdoi_library_categories() as $category ) {
		$term = get_term_by( 'slug', $category['slug'], 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			$term = get_term_by( 'name', $category['name'], 'category' );
		}
		if ( $term && ! is_wp_error( $term ) ) {
			$terms[] = $term;
		}
	}
	return $terms;
}

/**
 * Nội dung mặc định trang Thư viện. Khách sửa trong hộp Meta sẽ ghi đè.
 *
 * @return array<string,string>
 */
function nongnghiepnhietdoi_library_defaults() {
	return array(
		'tv_hero_eyebrow'  => 'Tài liệu & hoạt động',
		'tv_hero_title'    => 'Thư viện & Tin tức',
		'tv_hero_lead'     => 'Công trình nghiên cứu, cẩm nang kỹ thuật và video để nông hộ, nhà khoa học và đối tác dùng chung.',
		'tv_list_eyebrow'  => 'Thư viện',
		'tv_latest_title'  => 'Tin mới nhất',
	);
}

/**
 * Lấy một ô nội dung trang Thư viện: đã lưu hoặc mặc định.
 *
 * @param string $name    Tên field.
 * @param int    $post_id ID trang.
 * @return mixed
 */
function nongnghiepnhietdoi_library_field( $name, $post_id = 0 ) {
	$defaults = nongnghiepnhietdoi_library_defaults();
	$default  = array_key_exists( $name, $defaults ) ? $defaults[ $name ] : '';
	$page_id  = $post_id ? (int) $post_id : nongnghiepnhietdoi_library_page_id();

	if ( ! $page_id || ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $name, $page_id );

	if ( null === $value || false === $value ) {
		return $default;
	}

	return $value;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_seed_library_categories();
		nongnghiepnhietdoi_library_page_id();
	},
	5
);

/**
 * Ghi nội dung mặc định vào hộp Meta trang Thư viện lần đầu.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_library_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_library_page_id();
		if ( ! $page_id ) {
			return;
		}

		$existing = get_field( 'tv_hero_title', $page_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_library_seeded', 1, false );
			return;
		}

		foreach ( nongnghiepnhietdoi_library_defaults() as $name => $value ) {
			if ( '' === $value ) {
				continue;
			}
			update_field( $name, $value, $page_id );
		}

		update_option( 'nongnghiepnhietdoi_library_seeded', 1, false );
	},
	30
);

/**
 * Chuyên mục thư viện mở trên trang Thư viện, không ra archive mặc định.
 */
add_action(
	'template_redirect',
	static function () {
		if ( ! is_category() ) {
			return;
		}
		$term = get_queried_object();
		if ( ! $term instanceof WP_Term ) {
			return;
		}
		$slugs = wp_list_pluck( nongnghiepnhietdoi_library_categories(), 'slug' );
		if ( ! in_array( $term->slug, $slugs, true ) ) {
			return;
		}
		wp_safe_redirect( nongnghiepnhietdoi_library_url( $term->slug ), 301 );
		exit;
	}
);
