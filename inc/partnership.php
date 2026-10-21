<?php
/**
 * Trang Hợp tác & dự án: tạo trang và nhận hồ sơ / Call for Proposal.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tiêu đề form gửi thông tin.
 *
 * @return array<string,string>
 */
function nongnghiepnhietdoi_partnership_subjects() {
	return array(
		'capability' => 'Yêu cầu Hồ sơ năng lực',
		'cfp'        => 'Gửi Call for Proposal',
		'ngo'        => 'Đề xuất hợp tác — Nhà tài trợ / NGO',
		'business'   => 'Đề xuất hợp tác — Doanh nghiệp / HTX',
		'expert'     => 'Đề xuất hợp tác — Chuyên gia / Nhà khoa học',
	);
}

/**
 * Ba cổng đề xuất trên trang.
 *
 * @return array<string,array{title:string,text:string,subject:string}>
 */
function nongnghiepnhietdoi_partnership_audiences() {
	return array(
		'ngo'      => array(
			'title'   => 'Nhà tài trợ / NGO',
			'text'    => 'Tài trợ chương trình, nhận hồ sơ năng lực hoặc gửi Call for Proposal.',
			'subject' => 'ngo',
		),
		'business' => array(
			'title'   => 'Doanh nghiệp / HTX',
			'text'    => 'Hợp tác chuyển giao công nghệ, thử nghiệm và chuỗi giá trị nông sản.',
			'subject' => 'business',
		),
		'expert'   => array(
			'title'   => 'Chuyên gia / Nhà khoa học',
			'text'    => 'Tham gia nghiên cứu, phản biện kỹ thuật và mạng lưới chuyên môn.',
			'subject' => 'expert',
		),
	);
}

/**
 * ID trang Hợp tác & dự án. Tạo trang nếu chưa có.
 *
 * @return int
 */
function nongnghiepnhietdoi_partnership_page_id() {
	static $page_id = null;

	if ( null !== $page_id ) {
		return $page_id;
	}

	$stored = (int) get_option( 'nongnghiepnhietdoi_partnership_page_id' );
	$status = $stored ? get_post_status( $stored ) : false;
	if ( $stored && $status && 'trash' !== $status && 'page' === get_post_type( $stored ) ) {
		if ( 'page-hop-tac-du-an.php' !== get_page_template_slug( $stored ) ) {
			update_post_meta( $stored, '_wp_page_template', 'page-hop-tac-du-an.php' );
		}
		$page_id = $stored;
		return $page_id;
	}

	$found = get_posts(
		array(
			'name'           => 'hop-tac-du-an',
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$page_id = (int) $found[0];
		update_post_meta( $page_id, '_wp_page_template', 'page-hop-tac-du-an.php' );
		if ( 'publish' !== get_post_status( $page_id ) ) {
			wp_update_post(
				array(
					'ID'          => $page_id,
					'post_status' => 'publish',
				)
			);
		}
		update_option( 'nongnghiepnhietdoi_partnership_page_id', $page_id, false );
		return $page_id;
	}

	$created = wp_insert_post(
		array(
			'post_title'  => 'Hợp tác & dự án',
			'post_name'   => 'hop-tac-du-an',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $created ) || ! $created ) {
		$page_id = 0;
		return $page_id;
	}

	update_post_meta( (int) $created, '_wp_page_template', 'page-hop-tac-du-an.php' );
	$page_id = (int) $created;
	update_option( 'nongnghiepnhietdoi_partnership_page_id', $page_id, false );
	return $page_id;
}

add_action(
	'init',
	static function () {
		nongnghiepnhietdoi_partnership_page_id();
	},
	4
);

/**
 * Kiểm tra tệp đính kèm trước khi lưu lead.
 *
 * @return string Thông báo lỗi, hoặc chuỗi rỗng nếu hợp lệ / không có tệp.
 */
function nongnghiepnhietdoi_partnership_file_error() {
	if ( empty( $_FILES['lx_attachment'] ) || empty( $_FILES['lx_attachment']['name'] ) ) {
		return '';
	}

	$file  = $_FILES['lx_attachment'];
	$error = isset( $file['error'] ) ? (int) $file['error'] : UPLOAD_ERR_NO_FILE;

	if ( UPLOAD_ERR_NO_FILE === $error ) {
		return '';
	}
	if ( UPLOAD_ERR_INI_SIZE === $error || UPLOAD_ERR_FORM_SIZE === $error || ( ! empty( $file['size'] ) && (int) $file['size'] > 20 * MB_IN_BYTES ) ) {
		return __( 'Tệp đính kèm vượt quá dung lượng cho phép (tối đa 20MB).', 'nongnghiepnhietdoi' );
	}
	if ( UPLOAD_ERR_OK !== $error || empty( $file['tmp_name'] ) ) {
		return __( 'Không tải được tệp đính kèm. Vui lòng thử lại.', 'nongnghiepnhietdoi' );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';

	$allowed = nongnghiepnhietdoi_partnership_mimes();
	$check   = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'], $allowed );
	$ext     = isset( $check['ext'] ) ? strtolower( (string) $check['ext'] ) : '';

	if ( ! isset( $allowed[ $ext ] ) ) {
		return __( 'Chỉ nhận tệp PDF, DOC, DOCX hoặc ZIP.', 'nongnghiepnhietdoi' );
	}

	return '';
}

/**
 * MIME được phép cho hồ sơ hợp tác.
 *
 * @return array<string,string>
 */
function nongnghiepnhietdoi_partnership_mimes() {
	return array(
		'pdf'  => 'application/pdf',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'zip'  => 'application/zip',
	);
}

/**
 * Lưu tệp đính kèm vào thư viện, gắn với lead.
 *
 * @param int $post_id ID lead.
 * @return int|WP_Error 0 nếu không có tệp.
 */
function nongnghiepnhietdoi_partnership_store_file( $post_id ) {
	if ( empty( $_FILES['lx_attachment']['name'] ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$allow = static function ( $mimes ) {
		return array_merge( $mimes, nongnghiepnhietdoi_partnership_mimes() );
	};

	add_filter( 'upload_mimes', $allow );
	$attachment_id = media_handle_upload( 'lx_attachment', $post_id );
	remove_filter( 'upload_mimes', $allow );

	return $attachment_id;
}
