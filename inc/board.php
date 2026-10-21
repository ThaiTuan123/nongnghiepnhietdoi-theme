<?php
/**
 * Trang Hội đồng Cố vấn & Ban Điều hành.
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
function nongnghiepnhietdoi_board_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$short = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_short_name' ) : 'VARC';
	if ( ! $short ) {
		$short = 'VARC';
	}

	$defaults = array(
		'hd_hero_eyebrow'   => 'Con người của trung tâm',
		'hd_hero_title'     => 'Hội đồng Cố vấn & Ban Điều hành',
		'hd_hero_lead'      => 'Hội đồng phản biện hướng khoa học. Ban điều hành chịu trách nhiệm chiến lược, nghiên cứu, dự án, tài chính và kết nối đối tác.',
		'hd_advisors_label' => 'Hội đồng Cố vấn Khoa học',
		'hd_advisors_intro' => 'Các cố vấn cao cấp giữ hướng chuyên môn trước khi một quy trình được đưa ra đồng.',
		'hd_advisors'       => array(
			array(
				'name' => 'TS. Nguyễn Đăng Nghĩa',
				'role' => 'Cố vấn cao cấp – Chuyên gia Nông hóa Thổ nhưỡng',
				'bio'  => 'Chuyên gia đầu ngành về nông hóa, thổ nhưỡng và phân bón; nhiều năm nghiên cứu, tư vấn kỹ thuật canh tác cho các vùng nguyên liệu lớn tại Việt Nam.',
			),
			array(
				'name' => 'TS. Hoàng Văn Tám',
				'role' => 'Cố vấn cao cấp – Chuyên gia Đất & Dinh dưỡng cây trồng',
				'bio'  => 'Nghiên cứu chuyên sâu về dinh dưỡng cây trồng, quản lý độ phì đất và giải pháp canh tác bền vững thích ứng biến đổi khí hậu.',
			),
			array(
				'name' => 'TS. Nguyễn Thị Ngọc Trúc',
				'role' => 'Cố vấn cao cấp – Chuyên gia Vi sinh & Bảo vệ thực vật',
				'bio'  => 'Chuyên gia vi sinh vật học ứng dụng, phát triển chế phẩm sinh học thay thế thuốc bảo vệ thực vật hóa học.',
			),
		),
		'hd_board_label'    => 'Ban Điều hành',
		'hd_board_intro'    => 'Ban điều hành giữ chiến lược, nghiên cứu, dự án ngoài thực địa, tài chính và kết nối đối tác.',
		'hd_board'          => array(
			array(
				'name' => 'ThS. Bạch Thanh Ấn',
				'role' => 'Giám đốc Điều hành',
				'bio'  => 'Phụ trách chiến lược và định hướng phát triển của Trung tâm.',
			),
			array(
				'name' => 'Vũ Thị Huyền',
				'role' => 'Phó Giám đốc Nghiên cứu & Đào tạo',
				'bio'  => 'Phụ trách R&D và chuyển giao công nghệ.',
			),
			array(
				'name' => 'Nguyễn Song Tùng',
				'role' => 'Phó Giám đốc Dự án',
				'bio'  => 'Phụ trách quản lý và thực thi các dự án thực địa.',
			),
			array(
				'name' => 'Phan Đặng Phước Vĩnh',
				'role' => 'Phó Giám đốc Tài chính',
				'bio'  => 'Phụ trách kiểm soát tài chính và minh bạch nguồn vốn.',
			),
			array(
				'name' => 'Nguyễn Văn Mười',
				'role' => 'Phó Giám đốc Truyền thông & Marketing',
				'bio'  => 'Phụ trách kết nối đối tác và quảng bá mô hình.',
			),
		),
	);

	return $defaults;
}

/**
 * ID trang Hội đồng & Ban điều hành. Tạo trang nếu chưa có.
 *
 * @return int
 */
function nongnghiepnhietdoi_board_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_board_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		if ( 'page-hoi-dong-co-van-ban-dieu-hanh.php' !== get_page_template_slug( $stored ) ) {
			update_post_meta( $stored, '_wp_page_template', 'page-hoi-dong-co-van-ban-dieu-hanh.php' );
		}
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'hoi-dong-co-van-ban-dieu-hanh',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_post_meta( $page_id, '_wp_page_template', 'page-hoi-dong-co-van-ban-dieu-hanh.php' );
		if ( 'publish' !== get_post_status( $page_id ) ) {
			wp_update_post(
				array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				)
			);
		}
		update_option( 'nongnghiepnhietdoi_board_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Hội đồng Cố vấn & Ban Điều hành',
			'post_name'   => 'hoi-dong-co-van-ban-dieu-hanh',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-hoi-dong-co-van-ban-dieu-hanh.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_board_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_board_page_id();
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
function nongnghiepnhietdoi_board_field( $name, $post_id = 0 ) {
	$defaults = nongnghiepnhietdoi_board_defaults();
	$default  = array_key_exists( $name, $defaults ) ? $defaults[ $name ] : '';
	$page_id  = $post_id ? (int) $post_id : nongnghiepnhietdoi_board_page_id();

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
 * Chữ cái trên huy hiệu khi chưa có ảnh.
 *
 * @param string $name     Họ tên, có thể kèm học hàm.
 * @param string $monogram Chữ khách tự nhập.
 * @return string
 */
function nongnghiepnhietdoi_board_initial( $name, $monogram = '' ) {
	$monogram = trim( (string) $monogram );
	if ( '' !== $monogram ) {
		return mb_strtoupper( mb_substr( $monogram, 0, 2 ) );
	}

	$name = trim( (string) $name );
	if ( '' === $name ) {
		return '•';
	}

	$parts  = preg_split( '/\s+/u', $name );
	$titles = array( 'TS.', 'TS', 'THS.', 'THS', 'PGS.', 'PGS', 'GS.', 'GS', 'PGS.TS.', 'GS.TS.' );
	$word   = $parts[0];
	if ( in_array( mb_strtoupper( $word ), $titles, true ) && isset( $parts[1] ) ) {
		$word = $parts[1];
	}

	return mb_strtoupper( mb_substr( $word, 0, 1 ) );
}

/**
 * Ghi nội dung mặc định vào hộp Meta lần đầu.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_board_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_board_page_id();
		if ( ! $page_id ) {
			return;
		}

		$existing = get_field( 'hd_hero_title', $page_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_board_seeded', 1, false );
			return;
		}

		foreach ( nongnghiepnhietdoi_board_defaults() as $name => $value ) {
			if ( null === $value || '' === $value || array() === $value ) {
				continue;
			}
			update_field( $name, $value, $page_id );
		}

		update_option( 'nongnghiepnhietdoi_board_seeded', 1, false );
	},
	30
);

/**
 * Đổi câu mở ban điều hành nếu lần gieo đầu còn là câu hướng dẫn quản trị.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_board_intro_copy' ) || ! function_exists( 'get_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_board_page_id();
		if ( ! $page_id ) {
			return;
		}

		$current = (string) get_field( 'hd_board_intro', $page_id );
		$old     = 'Người đứng đầu đặt ở dòng đầu tiên. Các dòng sau là ban điều hành cùng chịu trách nhiệm vận hành.';
		if ( $current === $old ) {
			update_field( 'hd_board_intro', nongnghiepnhietdoi_board_defaults()['hd_board_intro'], $page_id );
		}

		update_option( 'nongnghiepnhietdoi_board_intro_copy', 1, false );
	},
	40
);
