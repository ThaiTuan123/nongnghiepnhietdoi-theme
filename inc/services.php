<?php
/**
 * Trang Lĩnh vực & Dịch vụ: nội dung mặc định, hộp Meta và tạo trang lần đầu.
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
function nongnghiepnhietdoi_services_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$short = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_short_name' ) : 'TARCC';
	if ( ! $short ) {
		$short = 'TARCC';
	}

	$defaults = array(
		'lv_hero_eyebrow'    => 'Lĩnh vực hoạt động',
		'lv_hero_title'      => 'Lĩnh vực & Dịch vụ',
		'lv_hero_lead'       => $short . ' nhận ba nhóm việc: nghiên cứu để chuyển giao ra đồng, tư vấn đánh giá độc lập, và đề tài cùng chương trình quốc gia.',
		'lv_s1_nav'          => 'Nghiên cứu & chuyển giao',
		'lv_s1_title'        => 'Nghiên cứu, Triển khai & Chuyển giao Công nghệ',
		'lv_s1_intro'        => 'Đưa quy trình từ phòng thí nghiệm ra ruộng: vi sinh, thích ứng khí hậu, xử lý môi trường và tập huấn cho người trực tiếp làm.',
		'lv_s1_points'       => array(
			array(
				'title' => 'Công nghệ vi sinh',
				'text'  => 'Phân lập, nhân sinh khối và chuyển giao chế phẩm phù hợp đất và cây của từng vùng.',
				'image' => null,
			),
			array(
				'title' => 'Thích ứng khí hậu',
				'text'  => 'Mô hình nông nghiệp thông minh với khí hậu theo mùa vụ, nguồn nước và quy mô hợp tác xã.',
				'image' => null,
			),
			array(
				'title' => 'Chuyển giao hiện trường',
				'text'  => 'Tập huấn, sổ tay kỹ thuật và đồng hành sau khi mô hình được bàn giao cho nông hộ.',
				'image' => null,
			),
		),
		'lv_s1_more_label'   => 'Xem thêm',
		'lv_s1_more_url'     => '',
		'lv_s2_nav'          => 'Tư vấn & đánh giá',
		'lv_s2_title'        => 'Dịch vụ Tư vấn & Đánh giá dự án độc lập',
		'lv_s2_intro'        => 'Một ý kiến riêng, tách khỏi đơn vị thực hiện, để nhà tài trợ và cơ quan chủ quản nhìn rõ thiết kế, tiến độ và kết quả.',
		'lv_s2_points'       => array(
			array(
				'title' => 'Thẩm định trước khi làm',
				'text'  => 'Rà quy trình, chỉ số theo dõi và giả định của dự án trước khi xuống hiện trường.',
				'image' => null,
			),
			array(
				'title' => 'Đánh giá giữa kỳ và cuối kỳ',
				'text'  => 'Đối chiếu việc đã làm với mục tiêu đã cam kết, kèm số liệu năng suất, sinh kế và môi trường.',
				'image' => null,
			),
			array(
				'title' => 'Độc lập với bên thực hiện',
				'text'  => 'Không thay đơn vị triển khai và không nhận kết quả hộ cho bên được đánh giá.',
				'image' => null,
			),
		),
		'lv_s2_more_label'   => 'Xem thêm',
		'lv_s2_more_url'     => '',
		'lv_s3_nav'          => 'Đề tài & chương trình',
		'lv_s3_title'        => 'Đề tài KH&CN & Chương trình Quốc gia',
		'lv_s3_intro'        => 'Xây dựng, thực hiện và báo cáo đề tài khoa học công nghệ cùng các chương trình ngành, từ hồ sơ đến số liệu trên đồng.',
		'lv_s3_points'       => array(
			array(
				'title' => 'Đề tài đặt hàng',
				'text'  => 'Hồ sơ, phương pháp và sản phẩm giao nộp đúng khung của cơ quan chủ quản.',
				'image' => null,
			),
			array(
				'title' => 'Chương trình quốc gia',
				'text'  => 'Gắn mô hình đồng ruộng với chỉ tiêu ngành về sinh kế, môi trường và phát thải.',
				'image' => null,
			),
			array(
				'title' => 'Đầu mối kỹ thuật',
				'text'  => 'Phối hợp khi một chương trình có nhiều đơn vị cùng tham gia, để số liệu và quy trình đi cùng một hướng.',
				'image' => null,
			),
		),
		'lv_s3_more_label'   => 'Xem thêm',
		'lv_s3_more_url'     => '',
		'lv_cta_title'       => 'Cần trao đổi một hạng mục cụ thể?',
		'lv_cta_text'        => 'Cho chúng tôi biết việc cần làm, quy mô và thời điểm. ' . $short . ' sẽ trả lời phạm vi có thể nhận.',
		'lv_cta_button_label' => 'Hợp tác dự án',
		'lv_cta_button_url'  => home_url( '/#lien-he' ),
	);

	return $defaults;
}

/**
 * ID trang Lĩnh vực & Dịch vụ, tạo mới nếu chưa có.
 *
 * @return int
 */
function nongnghiepnhietdoi_services_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_services_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		if ( ! get_page_template_slug( $stored ) ) {
			update_post_meta( $stored, '_wp_page_template', 'page-linh-vuc-dich-vu.php' );
		}
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'linh-vuc-dich-vu',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		if ( ! get_page_template_slug( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-linh-vuc-dich-vu.php' );
		}
		update_option( 'nongnghiepnhietdoi_services_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Lĩnh vực & Dịch vụ',
			'post_name'   => 'linh-vuc-dich-vu',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-linh-vuc-dich-vu.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_services_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_services_page_id();
	},
	4
);

/**
 * Lấy một ô nội dung: giá trị đã lưu, hoặc mặc định nếu chưa từng lưu.
 *
 * @param string $name    Tên field.
 * @param int    $post_id ID trang. 0 thì dùng trang Lĩnh vực & Dịch vụ.
 * @return mixed
 */
function nongnghiepnhietdoi_services_field( $name, $post_id = 0 ) {
	$defaults = nongnghiepnhietdoi_services_defaults();
	$default  = array_key_exists( $name, $defaults ) ? $defaults[ $name ] : '';
	$page_id  = $post_id ? (int) $post_id : nongnghiepnhietdoi_services_page_id();

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
 * Ảnh nền mặc định cho thẻ Lĩnh vực & Dịch vụ.
 *
 * @param int $service_index 1|2|3.
 * @param int $point_index   Chỉ số thẻ (0-based).
 * @return string
 */
function nongnghiepnhietdoi_services_card_fallback( $service_index, $point_index ) {
	$map = array(
		1 => array(
			'assets/images/eco-scientist.jpg',
			'assets/images/eco-farmers.jpg',
			'assets/images/person-field.jpg',
		),
		2 => array(
			'assets/images/eco-agency.jpg',
			'assets/images/person-scientist.jpg',
			'assets/images/eco-business.jpg',
		),
		3 => array(
			'assets/images/eco-business.jpg',
			'assets/images/eco-agency.jpg',
			'assets/images/person-farmer.jpg',
		),
	);

	$service_index = (int) $service_index;
	if ( ! isset( $map[ $service_index ] ) ) {
		$service_index = 1;
	}

	$list = $map[ $service_index ];
	$file = $list[ (int) $point_index % count( $list ) ];
	$path = NONGNGHIEPNHIETDOI_DIR . '/' . $file;

	return file_exists( $path ) ? ( NONGNGHIEPNHIETDOI_URI . '/' . $file ) : '';
}

/**
 * URL ảnh nền thẻ dịch vụ: Meta trước, không có thì ảnh theme.
 *
 * @param mixed $image         Giá trị field image.
 * @param int   $service_index 1|2|3.
 * @param int   $point_index   Chỉ số thẻ.
 * @return string
 */
function nongnghiepnhietdoi_services_card_image( $image, $service_index, $point_index = 0 ) {
	if ( function_exists( 'nongnghiepnhietdoi_about_image_url' ) ) {
		$url = nongnghiepnhietdoi_about_image_url( $image );
		if ( $url ) {
			return $url;
		}
	}

	return nongnghiepnhietdoi_services_card_fallback( $service_index, $point_index );
}

/**
 * Ghi nội dung mặc định vào hộp Meta lần đầu.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_services_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_services_page_id();
		if ( ! $page_id ) {
			return;
		}

		$existing = get_field( 'lv_hero_title', $page_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_services_seeded', 1, false );
			return;
		}

		foreach ( nongnghiepnhietdoi_services_defaults() as $name => $value ) {
			if ( null === $value || '' === $value || array() === $value ) {
				continue;
			}

			if ( is_array( $value ) ) {
				$value = array_map(
					static function ( $row ) {
						if ( ! is_array( $row ) ) {
							return $row;
						}

						return array_filter(
							$row,
							static function ( $cell ) {
								return null !== $cell && '' !== $cell;
							}
						);
					},
					$value
				);
			}

			update_field( $name, $value, $page_id );
		}

		update_option( 'nongnghiepnhietdoi_services_seeded', 1, false );
	},
	30
);
