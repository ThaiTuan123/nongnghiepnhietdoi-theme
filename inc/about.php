<?php
/**
 * Trang Về chúng tôi: nội dung mặc định, hộp Meta và tạo trang lần đầu.
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
function nongnghiepnhietdoi_about_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$company = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_company_name' ) : '';
	$short   = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_short_name' ) : 'VARC';

	if ( ! $company ) {
		$company = 'Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới';
	}
	if ( ! $short ) {
		$short = 'VARC';
	}

	$defaults = array(
		'vc_hero_eyebrow'     => 'Trung tâm nghiên cứu',
		'vc_hero_title'       => 'Về chúng tôi',
		'vc_hero_lead'        => $company . ' (' . $short . ') chuyển hóa tiến bộ khoa học thành sinh kế bền vững cho nông dân, giá trị gia tăng cho doanh nghiệp và bảo vệ môi trường sinh thái.',
		'vc_overview_label'   => 'Tổng quan và Sứ mệnh',
		'vc_overview_title'   => 'Khoa học ra đồng, vì nông hộ và hệ sinh thái',
		'vc_overview_content' => '<p>' . $short . ' là đầu mối nghiên cứu và tư vấn nông nghiệp nhiệt đới. Chúng tôi đưa công nghệ vi sinh, nông nghiệp thích ứng khí hậu và đo lường phát thải ra đồng ruộng — nơi nông hộ cần một quy trình làm được, không chỉ một báo cáo.</p><p>Mỗi mô hình có người chịu trách nhiệm khoa học và người chịu trách nhiệm hiện trường. Kết quả được nhìn bằng năng suất, sinh kế và phát thải khí nhà kính.</p>',
		'vc_overview_image'   => null,
		'vc_pillars'          => array(
			array(
				'title' => 'Tầm nhìn',
				'text'  => 'Trở thành đầu mối tin cậy về nông nghiệp nhiệt đới thích ứng khí hậu: đo được tác động và nhân rộng được từ nông hộ.',
			),
			array(
				'title' => 'Sứ mệnh',
				'text'  => 'Chuyển hóa tiến bộ khoa học thành quy trình trên ruộng, có người chịu trách nhiệm và có số liệu để đối chiếu trước — sau.',
			),
			array(
				'title' => 'Giá trị',
				'text'  => 'Hiện trường trước phòng thí nghiệm. Minh bạch về vai trò. Tôn trọng nông hộ và dữ liệu họ chia sẻ.',
			),
		),
		'vc_org_label'        => 'Tổ chức và Ban cố vấn',
		'vc_org_title'        => 'Rõ người chịu trách nhiệm, từ chiến lược tới ngoài đồng',
		'vc_org_intro'        => 'Trung tâm được tổ chức để một việc khoa học luôn có đầu mối điều phối, đầu mối phản biện và đầu mối triển khai.',
		'vc_units'            => array(
			array(
				'title' => 'Ban điều hành',
				'text'  => 'Điều phối chiến lược, đối tác và các chương trình quốc gia. Đây là nơi chốt phạm vi và tiến độ.',
				'image' => null,
			),
			array(
				'title' => 'Hội đồng khoa học',
				'text'  => 'Phản biện quy trình trước khi ra đồng và chịu trách nhiệm chất lượng nghiên cứu, hồ sơ đề tài.',
				'image' => null,
			),
			array(
				'title' => 'Ban hiện trường',
				'text'  => 'Giữ mạng lưới tỉnh, hợp tác xã và lịch triển khai theo vụ. Ghi nhận số liệu tại nông hộ.',
				'image' => null,
			),
			array(
				'title' => 'Ban đối tác',
				'text'  => 'Đầu mối với quỹ, doanh nghiệp, tổ chức xã hội và cơ quan quản lý trong cùng một chương trình.',
				'image' => null,
			),
		),
		'vc_board_label'      => 'Ban cố vấn',
		'vc_board_intro'      => 'Ban cố vấn phản biện hướng đi chuyên môn trước khi quy trình được đưa ra đồng.',
		'vc_advisors'         => array(
			array(
				'name'  => 'Cố vấn khoa học',
				'role'  => 'Vi sinh và môi trường',
				'bio'   => 'Định hướng quy trình chế phẩm, an toàn sinh học và điều kiện nhân sinh khối tại nông hộ.',
				'photo' => null,
				'image' => null,
			),
			array(
				'name'  => 'Cố vấn hiện trường',
				'role'  => 'Thích ứng khí hậu',
				'bio'   => 'Góp ý mô hình CSA theo mùa vụ, nguồn nước và quy mô hợp tác xã trước khi triển khai.',
				'photo' => null,
				'image' => null,
			),
			array(
				'name'  => 'Cố vấn đo lường',
				'role'  => 'Phát thải khí nhà kính',
				'bio'   => 'Thẩm định phương pháp đo, chỉ số theo dõi và cách báo cáo tác động sau mỗi vụ.',
				'photo' => null,
				'image' => null,
			),
			array(
				'name'  => 'Cố vấn chính sách',
				'role'  => 'Chương trình và đối tác',
				'bio'   => 'Kết nối đề tài với chương trình ngành, quỹ và yêu cầu minh bạch của đối tác tài trợ.',
				'photo' => null,
				'image' => null,
			),
		),
		'vc_network_label'    => 'Mạng lưới liên kết',
		'vc_network_title'    => $short . ' đứng giữa các nhóm cùng làm một việc',
		'vc_network_intro'    => 'Mạng lưới không phải danh sách logo. Mỗi nhóm có một việc rõ trên cùng một mô hình: làm, đo, tiêu thụ hoặc ban hành.',
		'vc_links'            => array(
			array(
				'name'  => 'Nông hộ và hợp tác xã',
				'text'  => 'Nơi mô hình được làm, đo và nhân rộng. Nông dân nòng cốt giữ quy trình sau khi được bàn giao.',
				'url'   => '',
				'logo'  => null,
				'image' => null,
			),
			array(
				'name'  => 'Nhà khoa học',
				'text'  => 'Nguồn quy trình, phản biện và đào tạo. Bảo đảm thứ ra đồng đã được kiểm tra.',
				'url'   => '',
				'logo'  => null,
				'image' => null,
			),
			array(
				'name'  => 'Doanh nghiệp',
				'text'  => 'Chuỗi tiêu thụ, chế phẩm và đồng tài trợ thử nghiệm khi mô hình đủ số liệu.',
				'url'   => '',
				'logo'  => null,
				'image' => null,
			),
			array(
				'name'  => 'Cơ quan quản lý và tổ chức quốc tế',
				'text'  => 'Chương trình ngành, đề tài khoa học công nghệ và khung đo phát thải dùng chung.',
				'url'   => '',
				'logo'  => null,
				'image' => null,
			),
		),
		'vc_gov_label'        => 'Minh bạch và quản trị',
		'vc_gov_title'        => 'Nói rõ ai quyết, ai làm, ai kiểm',
		'vc_gov_intro'        => 'Quản trị của trung tâm phục vụ việc giải trình với nông hộ, đối tác và cơ quan chủ quản — không phải một lớp thủ tục thêm.',
		'vc_principles'       => array(
			array(
				'title' => 'Phân vai trước khi ra đồng',
				'text'  => 'Mỗi mô hình ghi tên người chịu trách nhiệm khoa học và người chịu trách nhiệm hiện trường.',
			),
			array(
				'title' => 'Quy trình có hồ sơ',
				'text'  => 'Đề tài, tập huấn và số liệu theo vụ được lưu để đối chiếu, không chỉ nằm trong trao đổi miệng.',
			),
			array(
				'title' => 'Tác động đo được',
				'text'  => 'Năng suất, sinh kế và phát thải được báo cáo theo chỉ số đã thống nhất từ đầu vụ.',
			),
			array(
				'title' => 'Dữ liệu được giữ đúng việc',
				'text'  => 'Thông tin nông hộ và đối tác chỉ dùng cho hợp tác đã thỏa thuận, và có đầu mối để yêu cầu chỉnh hoặc xóa.',
			),
		),
		'vc_documents'        => array(),
		'vc_cta_title'        => 'Cùng ' . $short . ' kiến tạo nền nông nghiệp phát thải thấp',
		'vc_cta_text'         => 'Chúng tôi sẵn sàng đồng hành cùng quỹ, đại sứ quán, tổ chức xã hội, doanh nghiệp và cơ quan quản lý.',
		'vc_cta_button_label' => 'Hợp tác dự án',
		'vc_cta_button_url'   => home_url( '/#lien-he' ),
	);

	return $defaults;
}

/**
 * ID trang Về chúng tôi, tạo mới nếu chưa có.
 *
 * @return int
 */
function nongnghiepnhietdoi_about_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_about_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 've-chung-toi',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_option( 'nongnghiepnhietdoi_about_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Về chúng tôi',
			'post_name'   => 've-chung-toi',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-ve-chung-toi.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_about_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_about_page_id();
	},
	4
);

/**
 * Đổi câu giới thiệu ban cố vấn đã gieo lần đầu, vì câu cũ hướng dẫn sửa trong quản trị.
 */
add_action(
	'acf/init',
	static function () {
		if ( get_option( 'nongnghiepnhietdoi_about_board_copy' ) || ! function_exists( 'get_field' ) ) {
			return;
		}

		$page_id = (int) get_option( 'nongnghiepnhietdoi_about_page_id' );
		if ( ! $page_id ) {
			return;
		}

		$current = (string) get_field( 'vc_board_intro', $page_id );
		$old     = 'Ban cố vấn phản biện hướng đi chuyên môn. Thêm tên, chức danh và ảnh trong hộp Meta khi đã có người phụ trách.';
		if ( $current === $old ) {
			update_field( 'vc_board_intro', 'Ban cố vấn phản biện hướng đi chuyên môn trước khi quy trình được đưa ra đồng.', $page_id );
		}

		update_option( 'nongnghiepnhietdoi_about_board_copy', 1, false );
	},
	40
);

/**
 * Lấy một ô nội dung: giá trị đã lưu, hoặc mặc định nếu chưa từng lưu.
 *
 * @param string $name Tên field.
 * @return mixed
 */
function nongnghiepnhietdoi_about_field( $name, $post_id = 0 ) {
	$defaults = nongnghiepnhietdoi_about_defaults();
	$default  = array_key_exists( $name, $defaults ) ? $defaults[ $name ] : '';
	$page_id  = $post_id ? (int) $post_id : nongnghiepnhietdoi_about_page_id();

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
 * URL ảnh ACF (mảng hoặc ID). Chuỗi rỗng nếu không có ảnh.
 *
 * @param mixed $image Giá trị field image.
 * @return string
 */
function nongnghiepnhietdoi_about_image_url( $image ) {
	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return (string) $image['url'];
	}

	if ( is_numeric( $image ) && (int) $image > 0 ) {
		$url = wp_get_attachment_image_url( (int) $image, 'large' );
		return $url ? $url : '';
	}

	if ( is_string( $image ) && '' !== $image ) {
		if ( 0 === strpos( $image, 'http://' ) || 0 === strpos( $image, 'https://' ) || 0 === strpos( $image, '//' ) ) {
			return $image;
		}
		$relative = ltrim( $image, '/' );
		$path     = NONGNGHIEPNHIETDOI_DIR . '/' . $relative;
		if ( file_exists( $path ) ) {
			return NONGNGHIEPNHIETDOI_URI . '/' . $relative;
		}
	}

	return '';
}

/**
 * Ảnh nền mặc định cho thẻ Về chúng tôi (khi chưa chọn trong Meta).
 *
 * @param string $group units|advisors|links.
 * @param int    $index Chỉ số thẻ (0-based).
 * @return string URL ảnh theme, hoặc rỗng.
 */
function nongnghiepnhietdoi_about_card_fallback( $group, $index ) {
	$map = array(
		'units'    => array(
			'assets/images/person-field.jpg',
			'assets/images/person-scientist.jpg',
			'assets/images/eco-farmers.jpg',
			'assets/images/eco-business.jpg',
		),
		'advisors' => array(
			'assets/images/person-scientist.jpg',
			'assets/images/person-field.jpg',
			'assets/images/eco-agency.jpg',
			'assets/images/eco-business.jpg',
		),
		'links'    => array(
			'assets/images/eco-farmers.jpg',
			'assets/images/eco-scientist.jpg',
			'assets/images/eco-business.jpg',
			'assets/images/eco-agency.jpg',
		),
	);

	if ( ! isset( $map[ $group ] ) || ! $map[ $group ] ) {
		return '';
	}

	$list = $map[ $group ];
	$file = $list[ $index % count( $list ) ];
	$path = NONGNGHIEPNHIETDOI_DIR . '/' . $file;

	return file_exists( $path ) ? ( NONGNGHIEPNHIETDOI_URI . '/' . $file ) : '';
}

/**
 * URL ảnh nền thẻ: ưu tiên Meta (ACF), không có thì ảnh theme theo nhóm/vị trí.
 *
 * @param mixed  $image Giá trị field image.
 * @param string $group units|advisors|links.
 * @param int    $index Chỉ số thẻ.
 * @return string
 */
function nongnghiepnhietdoi_about_card_image( $image, $group, $index = 0 ) {
	$url = nongnghiepnhietdoi_about_image_url( $image );
	if ( $url ) {
		return $url;
	}

	return nongnghiepnhietdoi_about_card_fallback( $group, (int) $index );
}

/**
 * Alt của ảnh ACF.
 *
 * @param mixed  $image   Giá trị field image.
 * @param string $fallback Alt dự phòng.
 * @return string
 */
function nongnghiepnhietdoi_about_image_alt( $image, $fallback ) {
	if ( is_array( $image ) && ! empty( $image['alt'] ) ) {
		return (string) $image['alt'];
	}

	return $fallback;
}

/**
 * Ghi nội dung mặc định vào hộp Meta lần đầu, để form quản trị hiện đúng chữ đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_about_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$page_id = nongnghiepnhietdoi_about_page_id();
		if ( ! $page_id ) {
			return;
		}

		$existing = get_field( 'vc_hero_title', $page_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_about_seeded', 1, false );
			return;
		}

		$skip = array( 'vc_overview_image', 'vc_documents' );

		foreach ( nongnghiepnhietdoi_about_defaults() as $name => $value ) {
			if ( in_array( $name, $skip, true ) || null === $value || '' === $value || array() === $value ) {
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

		update_option( 'nongnghiepnhietdoi_about_seeded', 1, false );
	},
	30
);
