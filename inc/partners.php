<?php
/**
 * Trang Đối tác & Nhà tài trợ.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nội dung mặc định. Khách sửa trong hộp Meta sẽ ghi đè từng ô.
 *
 * @return array<string,mixed>
 */
function nongnghiepnhietdoi_partners_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$defaults = array(
		'pt_hero_eyebrow' => 'Mạng lưới đồng hành',
		'pt_hero_title'   => 'Đối tác & Nhà tài trợ',
		'pt_hero_lead'    => 'Các quỹ, cơ quan quản lý, doanh nghiệp và hợp tác xã cùng triển khai mô hình với trung tâm.',
		'pt_funds_label'  => 'Quỹ quốc tế & Tổ chức phi chính phủ',
		'pt_funds_intro'  => 'Nguồn lực và khung chương trình cho các mô hình thích ứng khí hậu, sinh kế và đo lường tác động.',
		'pt_funds'        => array(
			array( 'name' => 'UNDP' ),
			array( 'name' => 'GIZ' ),
			array( 'name' => 'USAID' ),
			array( 'name' => 'ACIAR' ),
			array( 'name' => 'World Bank' ),
			array( 'name' => 'WWF' ),
		),
		'pt_gov_label'    => 'Cơ quan quản lý nhà nước',
		'pt_gov_intro'    => 'Đầu mối ngành và địa phương để mô hình đi đúng quy định và nhân rộng được.',
		'pt_gov'          => array(
			array( 'name' => 'Bộ Nông nghiệp & PTNT' ),
			array( 'name' => 'Sở KH&CN TP.HCM' ),
			array( 'name' => 'Sở NN&PTNT các tỉnh' ),
		),
		'pt_biz_label'    => 'Doanh nghiệp & Hợp tác xã',
		'pt_biz_intro'    => 'Nơi mô hình được làm trên đồng và đi vào chuỗi cung ứng.',
		'pt_biz'          => array(
			array( 'name' => 'Hợp tác xã nông nghiệp ĐBSCL' ),
			array( 'name' => 'Doanh nghiệp chuỗi cung ứng nông sản' ),
		),
	);

	return $defaults;
}

/**
 * ID trang Đối tác & Nhà tài trợ. Tạo trang nếu chưa có.
 *
 * @return int
 */
function nongnghiepnhietdoi_partners_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_partners_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		if ( 'page-doi-tac-nha-tai-tro.php' !== get_page_template_slug( $stored ) ) {
			update_post_meta( $stored, '_wp_page_template', 'page-doi-tac-nha-tai-tro.php' );
		}
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'doi-tac-nha-tai-tro',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_post_meta( $page_id, '_wp_page_template', 'page-doi-tac-nha-tai-tro.php' );
		if ( 'publish' !== get_post_status( $page_id ) ) {
			wp_update_post(
				array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				)
			);
		}
		update_option( 'nongnghiepnhietdoi_partners_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Đối tác & Nhà tài trợ',
			'post_name'   => 'doi-tac-nha-tai-tro',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-doi-tac-nha-tai-tro.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_partners_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_partners_page_id();
	},
	4
);

/**
 * Lấy một ô nội dung: giá trị đã lưu, hoặc mặc định nếu chưa từng lưu.
 *
 * @param string $name    Tên field.
 * @param int    $post_id ID trang.
 * @return mixed
 */
function nongnghiepnhietdoi_partners_field( $name, $post_id = 0 ) {
	$defaults = nongnghiepnhietdoi_partners_defaults();
	$default  = array_key_exists( $name, $defaults ) ? $defaults[ $name ] : '';
	$page_id  = $post_id ? (int) $post_id : nongnghiepnhietdoi_partners_page_id();

	if ( ! $page_id || ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $name, $page_id );

	if ( null === $value || false === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Ghi nội dung mặc định vào hộp Meta lần đầu.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_partners_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_partners_page_id();
		if ( ! $page_id ) {
			return;
		}

		$existing = get_field( 'pt_hero_title', $page_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_partners_seeded', 1, false );
			return;
		}

		foreach ( nongnghiepnhietdoi_partners_defaults() as $name => $value ) {
			if ( null === $value || '' === $value || array() === $value ) {
				continue;
			}
			update_field( $name, $value, $page_id );
		}

		update_option( 'nongnghiepnhietdoi_partners_seeded', 1, false );
	},
	30
);
