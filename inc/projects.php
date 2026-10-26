<?php
/**
 * Trang Dự Án & Tác Động: nội dung mặc định, hộp Meta và tạo trang lần đầu.
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
function nongnghiepnhietdoi_projects_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$short = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_short_name' ) : 'TARCC';
	if ( ! $short ) {
		$short = 'TARCC';
	}

	$defaults = array(
		'dt_hero_eyebrow'     => 'Dự án & tác động',
		'dt_hero_title'       => 'Dự Án & Tác Động',
		'dt_hero_lead'        => $short . ' triển khai và đồng hành ba nhóm dự án: tài trợ NGO/ODA, tư vấn đánh giá độc lập, và đề tài đặt hàng từ nhà nước — luôn gắn với số liệu trên đồng.',
		'dt_s1_nav'           => 'Dự án tài trợ',
		'dt_s1_title'         => 'Dự Án Tài Trợ (NGO/ODA)',
		'dt_s1_intro'         => 'Thiết kế và triển khai mô hình do quỹ quốc tế, đại sứ quán và tổ chức phi chính phủ tài trợ: từ hồ sơ đến đo lường tác động sau mỗi vụ.',
		'dt_s1_points'        => array(
			array(
				'title' => 'Thiết kế mô hình',
				'text'  => 'Xây dựng khung kỹ thuật, chỉ số theo dõi và kế hoạch hiện trường phù hợp điều kiện tài trợ.',
				'image' => null,
			),
			array(
				'title' => 'Triển khai ngoài đồng',
				'text'  => 'Lắp đặt mô hình tại hợp tác xã và nông hộ, tập huấn và ghi nhận số liệu theo vụ.',
				'image' => null,
			),
			array(
				'title' => 'Báo cáo tác động',
				'text'  => 'Đối chiếu kết quả với cam kết tài trợ: sinh kế, môi trường và phát thải khí nhà kính.',
				'image' => null,
			),
		),
		'dt_s1_more_label'    => 'Xem thêm',
		'dt_s1_more_url'      => '',
		'dt_s2_nav'           => 'Tư vấn & đánh giá',
		'dt_s2_title'         => 'Dự Án Tư Vấn & Đánh Giá',
		'dt_s2_intro'         => 'Cung cấp ý kiến độc lập cho nhà tài trợ và cơ quan chủ quản: thẩm định trước khi làm, đánh giá giữa kỳ và cuối kỳ.',
		'dt_s2_points'        => array(
			array(
				'title' => 'Thẩm định đầu kỳ',
				'text'  => 'Rà quy trình, chỉ số và giả định của dự án trước khi xuống hiện trường.',
				'image' => null,
			),
			array(
				'title' => 'Đánh giá giữa kỳ / cuối kỳ',
				'text'  => 'Đối chiếu việc đã làm với mục tiêu đã cam kết, kèm bằng chứng số liệu.',
				'image' => null,
			),
			array(
				'title' => 'Độc lập với bên thực hiện',
				'text'  => 'Không thay đơn vị triển khai và không nhận kết quả hộ cho bên được đánh giá.',
				'image' => null,
			),
		),
		'dt_s2_more_label'    => 'Xem thêm',
		'dt_s2_more_url'      => '',
		'dt_s3_nav'           => 'Đề tài nhà nước',
		'dt_s3_title'         => 'Đề Tài Đặt Hàng Từ Nhà Nước',
		'dt_s3_intro'         => 'Xây dựng, thực hiện và bàn giao đề tài khoa học công nghệ theo khung của cơ quan chủ quản, gắn với hiện trường và sản phẩm giao nộp.',
		'dt_s3_points'        => array(
			array(
				'title' => 'Hồ sơ đề tài',
				'text'  => 'Phương pháp, chỉ tiêu và sản phẩm giao nộp đúng khung đặt hàng của nhà nước.',
				'image' => null,
			),
			array(
				'title' => 'Thực hiện hiện trường',
				'text'  => 'Triển khai thử nghiệm, thu thập số liệu và điều chỉnh quy trình theo mùa vụ.',
				'image' => null,
			),
			array(
				'title' => 'Nghiệm thu & chuyển giao',
				'text'  => 'Báo cáo, sản phẩm và hướng dẫn sử dụng để cơ quan chủ quản và nông hộ tiếp tục dùng.',
				'image' => null,
			),
		),
		'dt_s3_more_label'    => 'Xem thêm',
		'dt_s3_more_url'      => '',
		'dt_featured_label'   => 'Mô hình đã ra đồng',
		'dt_featured_title'   => 'Dự án tiêu biểu',
		'dt_featured_intro'   => 'Một số mô hình ' . $short . ' đã triển khai trên đồng — chỉ hiện bài gắn chuyên mục Dự án tiêu biểu.',
		'dt_cta_title'        => 'Muốn đồng hành một dự án cụ thể?',
		'dt_cta_text'         => 'Cho chúng tôi biết loại dự án, quy mô và thời điểm. ' . $short . ' sẽ phản hồi phạm vi có thể nhận.',
		'dt_cta_button_label' => 'Hợp tác dự án',
		'dt_cta_button_url'   => home_url( '/hop-tac-du-an/' ),
	);

	return $defaults;
}

/**
 * ID trang Dự Án & Tác Động, tạo mới nếu chưa có.
 *
 * @return int
 */
function nongnghiepnhietdoi_projects_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_projects_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		if ( 'page-du-an-tac-dong.php' !== get_page_template_slug( $stored ) ) {
			update_post_meta( $stored, '_wp_page_template', 'page-du-an-tac-dong.php' );
		}
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'du-an-tac-dong',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_post_meta( $page_id, '_wp_page_template', 'page-du-an-tac-dong.php' );
		update_option( 'nongnghiepnhietdoi_projects_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Dự Án & Tác Động',
			'post_name'   => 'du-an-tac-dong',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-du-an-tac-dong.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_projects_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_projects_page_id();
	},
	4
);

/**
 * Lấy một ô nội dung: giá trị đã lưu, hoặc mặc định nếu chưa từng lưu.
 *
 * @param string $name    Tên field.
 * @param int    $post_id ID trang. 0 thì dùng trang Dự Án & Tác Động.
 * @return mixed
 */
function nongnghiepnhietdoi_projects_field( $name, $post_id = 0 ) {
	$defaults = nongnghiepnhietdoi_projects_defaults();
	$default  = array_key_exists( $name, $defaults ) ? $defaults[ $name ] : '';
	$page_id  = $post_id ? (int) $post_id : nongnghiepnhietdoi_projects_page_id();

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
 * Ảnh nền mặc định cho thẻ mục trên trang Dự Án & Tác Động.
 *
 * @param int $section_index 1|2|3.
 * @param int $point_index   Chỉ số thẻ (0-based).
 * @return string
 */
function nongnghiepnhietdoi_projects_card_fallback( $section_index, $point_index ) {
	$map = array(
		1 => array(
			'assets/images/eco-agency.jpg',
			'assets/images/eco-farmers.jpg',
			'assets/images/person-field.jpg',
		),
		2 => array(
			'assets/images/person-scientist.jpg',
			'assets/images/eco-scientist.jpg',
			'assets/images/eco-business.jpg',
		),
		3 => array(
			'assets/images/eco-business.jpg',
			'assets/images/eco-agency.jpg',
			'assets/images/person-farmer.jpg',
		),
	);

	$section_index = (int) $section_index;
	if ( ! isset( $map[ $section_index ] ) ) {
		$section_index = 1;
	}

	$list = $map[ $section_index ];
	$file = $list[ (int) $point_index % count( $list ) ];
	$path = NONGNGHIEPNHIETDOI_DIR . '/' . $file;

	return file_exists( $path ) ? ( NONGNGHIEPNHIETDOI_URI . '/' . $file ) : '';
}

/**
 * URL ảnh nền thẻ dự án: Meta trước, không có thì ảnh theme.
 *
 * @param mixed $image         Giá trị field image.
 * @param int   $section_index 1|2|3.
 * @param int   $point_index   Chỉ số thẻ.
 * @return string
 */
function nongnghiepnhietdoi_projects_card_image( $image, $section_index, $point_index = 0 ) {
	if ( function_exists( 'nongnghiepnhietdoi_about_image_url' ) ) {
		$url = nongnghiepnhietdoi_about_image_url( $image );
		if ( $url ) {
			return $url;
		}
	}

	return nongnghiepnhietdoi_projects_card_fallback( $section_index, $point_index );
}

/**
 * Map slug trang con (menu) → anchor trên trang Dự Án & Tác Động.
 *
 * @return array<string,string>
 */
function nongnghiepnhietdoi_projects_section_slugs() {
	return array(
		'du-an-tai-tro-ngo-oda'       => 'tai-tro',
		'du-an-tu-van-danh-gia'       => 'tu-van-danh-gia',
		'de-tai-dat-hang-tu-nha-nuoc' => 'de-tai-dat-hang',
	);
}

/**
 * Ba trang con trong menu chuyển về đúng mục trên trang chính.
 */
add_action(
	'template_redirect',
	static function () {
		if ( ! is_page() ) {
			return;
		}

		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$map  = nongnghiepnhietdoi_projects_section_slugs();
		if ( ! isset( $map[ $slug ] ) ) {
			return;
		}

		$parent = nongnghiepnhietdoi_projects_page_id();
		$url    = $parent ? get_permalink( $parent ) : home_url( '/du-an-tac-dong/' );
		wp_safe_redirect( trailingslashit( $url ) . '#' . $map[ $slug ], 301 );
		exit;
	}
);

/**
 * Ghi nội dung mặc định vào hộp Meta lần đầu.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_projects_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_projects_page_id();
		if ( ! $page_id ) {
			return;
		}

		$existing = get_field( 'dt_hero_title', $page_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_projects_seeded', 1, false );
			return;
		}

		foreach ( nongnghiepnhietdoi_projects_defaults() as $name => $value ) {
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

		update_option( 'nongnghiepnhietdoi_projects_seeded', 1, false );
	},
	30
);
