<?php
/**
 * Xử lý form liên hệ (hardcode, không phụ thuộc ACF/CF7).
 * Lưu mỗi submission vào CPT lx_lead để xem trong WP Admin.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Email nhận thông tin liên hệ. Sửa trực tiếp tại đây nếu cần.
 * Mặc định dùng email quản trị của website.
 */
if ( ! defined( 'NONGNGHIEPNHIETDOI_CONTACT_EMAIL' ) ) {
	define( 'NONGNGHIEPNHIETDOI_CONTACT_EMAIL', get_option( 'admin_email' ) );
}

/**
 * Đăng ký CPT lưu đăng ký tư vấn / liên hệ.
 */
add_action(
	'init',
	function () {
		register_post_type(
			'lx_lead',
			array(
				'labels'              => array(
					'name'               => __( 'Đăng ký tư vấn', 'nongnghiepnhietdoi' ),
					'singular_name'      => __( 'Đăng ký tư vấn', 'nongnghiepnhietdoi' ),
					'menu_name'          => __( 'Đăng ký tư vấn', 'nongnghiepnhietdoi' ),
					'all_items'          => __( 'Tất cả đăng ký', 'nongnghiepnhietdoi' ),
					'view_item'          => __( 'Xem đăng ký', 'nongnghiepnhietdoi' ),
					'search_items'       => __( 'Tìm đăng ký', 'nongnghiepnhietdoi' ),
					'not_found'          => __( 'Chưa có đăng ký nào.', 'nongnghiepnhietdoi' ),
					'not_found_in_trash' => __( 'Không có đăng ký trong thùng rác.', 'nongnghiepnhietdoi' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => false,
				'menu_icon'           => 'dashicons-email-alt',
				'menu_position'       => 26,
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'hierarchical'        => false,
				'supports'            => array( 'title' ),
				'has_archive'         => false,
				'rewrite'             => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
			)
		);
	}
);

/**
 * Lưu một lead vào CPT lx_lead.
 *
 * @param string       $name         Họ tên.
 * @param string       $email        Email.
 * @param string       $phone        Số điện thoại.
 * @param string       $message      Nội dung / nhu cầu.
 * @param string       $source       Nguồn: consult|contact.
 * @param array|string $needs        Nhu cầu tư vấn (mảng hoặc chuỗi).
 * @param string       $project_type Loại hình công trình.
 * @return int|WP_Error Post ID hoặc lỗi.
 */
function nongnghiepnhietdoi_save_lead( $name, $email, $phone, $message, $source = 'contact', $needs = array(), $project_type = '' ) {
	$post_id = wp_insert_post(
		array(
			'post_type'    => 'lx_lead',
			'post_status'  => 'private',
			'post_title'   => $name,
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}

	if ( is_array( $needs ) ) {
		$needs = array_values( array_filter( array_map( 'strval', $needs ) ) );
		$needs_str = implode( ', ', $needs );
	} else {
		$needs_str = (string) $needs;
	}

	update_post_meta( $post_id, '_lx_email', $email );
	update_post_meta( $post_id, '_lx_phone', $phone );
	update_post_meta( $post_id, '_lx_message', $message );
	update_post_meta( $post_id, '_lx_source', $source );
	update_post_meta( $post_id, '_lx_needs', $needs_str );
	update_post_meta( $post_id, '_lx_project_type', (string) $project_type );

	return $post_id;
}

/**
 * Parse nhu cầu / loại hình từ chuỗi message cũ (lead trước khi tách meta).
 *
 * @param string $message Nội dung đã lưu.
 * @return array{needs:string,project_type:string}
 */
function nongnghiepnhietdoi_parse_consult_fields_from_message( $message ) {
	$needs = '';
	$type  = '';

	if ( preg_match( '/Nhu cầu tư vấn:\s*(.+?)(?:\n|$)/u', $message, $m ) ) {
		$needs = trim( $m[1] );
	}
	if ( preg_match( '/Loại hình công trình:\s*(.+?)(?:\n|$)/u', $message, $m ) ) {
		$type = trim( $m[1] );
	}

	return array(
		'needs'         => $needs,
		'project_type'  => $type,
	);
}

/**
 * Lấy nhu cầu tư vấn của lead (meta mới hoặc parse từ message cũ).
 *
 * @param int $post_id Post ID.
 * @return string
 */
function nongnghiepnhietdoi_get_lead_needs( $post_id ) {
	$needs = (string) get_post_meta( $post_id, '_lx_needs', true );
	if ( '' !== $needs ) {
		return $needs;
	}
	$parsed = nongnghiepnhietdoi_parse_consult_fields_from_message( (string) get_post_meta( $post_id, '_lx_message', true ) );
	return $parsed['needs'];
}

/**
 * Lấy loại hình công trình của lead.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function nongnghiepnhietdoi_get_lead_project_type( $post_id ) {
	$type = (string) get_post_meta( $post_id, '_lx_project_type', true );
	if ( '' !== $type ) {
		return $type;
	}
	$parsed = nongnghiepnhietdoi_parse_consult_fields_from_message( (string) get_post_meta( $post_id, '_lx_message', true ) );
	return $parsed['project_type'];
}

/**
 * Gom nhu cầu / loại hình (form tư vấn) thành message nếu chưa có.
 *
 * @param array $request Dữ liệu request (thường là $_POST).
 * @return string
 */
function nongnghiepnhietdoi_compose_consult_message( $request ) {
	$message = isset( $request['message'] ) ? sanitize_textarea_field( wp_unslash( $request['message'] ) ) : '';
	if ( '' !== $message ) {
		return $message;
	}

	$needs = isset( $request['needs'] ) && is_array( $request['needs'] )
		? array_map( 'sanitize_text_field', wp_unslash( $request['needs'] ) )
		: array();
	$type = isset( $request['project_type'] ) ? sanitize_text_field( wp_unslash( $request['project_type'] ) ) : '';

	$parts = array();
	if ( $needs ) {
		$parts[] = 'Nhu cầu tư vấn: ' . implode( ', ', $needs );
	}
	if ( $type ) {
		$parts[] = 'Loại hình công trình: ' . $type;
	}

	return $parts ? implode( "\n", $parts ) : __( 'Đăng ký nhận tư vấn.', 'nongnghiepnhietdoi' );
}

/**
 * Xử lý một lần gửi form (dùng chung cho POST thường + AJAX).
 *
 * @param array $request Dữ liệu request.
 * @return array{status:string,message:string,old:array}
 */
function nongnghiepnhietdoi_handle_contact_request( $request ) {
	$result = array(
		'status'  => 'error',
		'message' => '',
		'old'     => array(
			'name'    => '',
			'email'   => '',
			'phone'   => '',
			'message' => '',
		),
	);

	if ( empty( $request['nongnghiepnhietdoi_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $request['nongnghiepnhietdoi_contact_nonce'] ) ), 'nongnghiepnhietdoi_contact' ) ) {
		$result['message'] = __( 'Phiên làm việc đã hết hạn, vui lòng thử lại.', 'nongnghiepnhietdoi' );
		return $result;
	}

	if ( ! empty( $request['nongnghiepnhietdoi_website'] ) ) {
		$result['message'] = __( 'Yêu cầu không hợp lệ.', 'nongnghiepnhietdoi' );
		return $result;
	}

	// lx_name — tránh field "name" (query var WP gây 404 khi POST trang).
	$name    = isset( $request['lx_name'] ) ? sanitize_text_field( wp_unslash( $request['lx_name'] ) ) : '';
	$email   = isset( $request['email'] ) ? sanitize_email( wp_unslash( $request['email'] ) ) : '';
	$phone   = isset( $request['phone'] ) ? sanitize_text_field( wp_unslash( $request['phone'] ) ) : '';
	$message = nongnghiepnhietdoi_compose_consult_message( $request );

	$result['old'] = compact( 'name', 'email', 'phone', 'message' );

	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		$result['message'] = __( 'Vui lòng nhập họ tên, email hợp lệ và nội dung.', 'nongnghiepnhietdoi' );
		return $result;
	}

	$source_raw = isset( $request['lx_form_source'] ) ? sanitize_text_field( wp_unslash( $request['lx_form_source'] ) ) : '';
	if ( in_array( $source_raw, array( 'consult', 'contact' ), true ) ) {
		$source = $source_raw;
	} else {
		$source = ( isset( $request['needs'] ) || isset( $request['project_type'] ) ) ? 'consult' : 'contact';
	}

	$needs = isset( $request['needs'] ) && is_array( $request['needs'] )
		? array_map( 'sanitize_text_field', wp_unslash( $request['needs'] ) )
		: array();
	$project_type = isset( $request['project_type'] ) ? sanitize_text_field( wp_unslash( $request['project_type'] ) ) : '';

	// Nếu message có sẵn (form liên hệ), cố parse thêm khi thiếu field riêng.
	if ( ! $needs && ! $project_type && $message ) {
		$parsed       = nongnghiepnhietdoi_parse_consult_fields_from_message( $message );
		$needs        = $parsed['needs'] ? array_map( 'trim', explode( ',', $parsed['needs'] ) ) : array();
		$project_type = $parsed['project_type'];
	}

	$saved = nongnghiepnhietdoi_save_lead( $name, $email, $phone, $message, $source, $needs, $project_type );

	if ( is_wp_error( $saved ) || ! $saved ) {
		$result['message'] = __( 'Gửi không thành công. Vui lòng gọi điện hoặc thử lại sau.', 'nongnghiepnhietdoi' );
		return $result;
	}

	$to      = NONGNGHIEPNHIETDOI_CONTACT_EMAIL;
	$subject = sprintf( '[%s] Liên hệ mới từ %s', wp_specialchars_decode( get_bloginfo( 'name' ) ), $name );
	$body    = sprintf(
		"Họ tên: %s\nEmail: %s\nĐiện thoại: %s\n\nNội dung:\n%s\n",
		$name,
		$email,
		$phone ? $phone : '(không có)',
		$message
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	wp_mail( $to, $subject, $body, $headers );

	$result['status']  = 'sent';
	$result['message'] = __( 'Cảm ơn bạn! Chúng tôi đã nhận được thông tin và sẽ liên hệ lại sớm nhất.', 'nongnghiepnhietdoi' );
	$result['old']     = array(
		'name'    => '',
		'email'   => '',
		'phone'   => '',
		'message' => '',
	);

	return $result;
}

/**
 * Xử lý dữ liệu POST của form liên hệ (fallback không JS).
 *
 * @return array{status:string,message:string,old:array}
 */
function nongnghiepnhietdoi_process_contact_form() {
	$result = array(
		'status'  => '',
		'message' => '',
		'old'     => array(
			'name'    => '',
			'email'   => '',
			'phone'   => '',
			'message' => '',
		),
	);

	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['nongnghiepnhietdoi_contact_submit'] ) ) {
		return $result;
	}

	return nongnghiepnhietdoi_handle_contact_request( $_POST );
}

/**
 * AJAX: gửi form liên hệ / đăng ký tư vấn (không reload trang).
 */
function nongnghiepnhietdoi_ajax_contact() {
	$result = nongnghiepnhietdoi_handle_contact_request( $_POST );

	if ( 'sent' === $result['status'] ) {
		wp_send_json_success(
			array(
				'message' => $result['message'],
				'title'   => __( 'Gửi thành công', 'nongnghiepnhietdoi' ),
			)
		);
	}

	wp_send_json_error(
		array(
			'message' => $result['message'] ? $result['message'] : __( 'Gửi không thành công.', 'nongnghiepnhietdoi' ),
			'title'   => __( 'Gửi không thành công', 'nongnghiepnhietdoi' ),
		),
		400
	);
}
add_action( 'wp_ajax_nongnghiepnhietdoi_contact', 'nongnghiepnhietdoi_ajax_contact' );
add_action( 'wp_ajax_nopriv_nongnghiepnhietdoi_contact', 'nongnghiepnhietdoi_ajax_contact' );

/**
 * Cột danh sách admin cho lx_lead.
 *
 * @param array $columns Cột mặc định.
 * @return array
 */
add_filter(
	'manage_lx_lead_posts_columns',
	function ( $columns ) {
		return array(
			'cb'              => $columns['cb'] ?? '<input type="checkbox" />',
			'title'           => __( 'Họ tên', 'nongnghiepnhietdoi' ),
			'lx_email'        => __( 'Email', 'nongnghiepnhietdoi' ),
			'lx_phone'        => __( 'Điện thoại', 'nongnghiepnhietdoi' ),
			'lx_message'      => __( 'Nội dung', 'nongnghiepnhietdoi' ),
			'lx_needs'        => __( 'Nhu cầu tư vấn', 'nongnghiepnhietdoi' ),
			'lx_project_type' => __( 'Loại hình công trình', 'nongnghiepnhietdoi' ),
			'lx_source'       => __( 'Nguồn', 'nongnghiepnhietdoi' ),
			'date'            => __( 'Ngày gửi', 'nongnghiepnhietdoi' ),
		);
	}
);

/**
 * Render nội dung cột custom.
 *
 * @param string $column  Tên cột.
 * @param int    $post_id Post ID.
 */
add_action(
	'manage_lx_lead_posts_custom_column',
	function ( $column, $post_id ) {
		switch ( $column ) {
			case 'lx_email':
				$email = get_post_meta( $post_id, '_lx_email', true );
				echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '—';
				break;
			case 'lx_phone':
				$phone = get_post_meta( $post_id, '_lx_phone', true );
				echo $phone ? esc_html( $phone ) : '—';
				break;
			case 'lx_message':
				$message = (string) get_post_meta( $post_id, '_lx_message', true );
				if ( '' === $message ) {
					echo '—';
					break;
				}
				$excerpt = wp_trim_words( $message, 14, '…' );
				printf(
					'<span title="%s">%s</span>',
					esc_attr( $message ),
					esc_html( $excerpt )
				);
				break;
			case 'lx_needs':
				$needs = nongnghiepnhietdoi_get_lead_needs( $post_id );
				echo $needs ? esc_html( $needs ) : '—';
				break;
			case 'lx_project_type':
				$type = nongnghiepnhietdoi_get_lead_project_type( $post_id );
				echo $type ? esc_html( $type ) : '—';
				break;
			case 'lx_source':
				$source = get_post_meta( $post_id, '_lx_source', true );
				if ( 'consult' === $source ) {
					esc_html_e( 'Đăng ký tư vấn', 'nongnghiepnhietdoi' );
				} elseif ( 'contact' === $source ) {
					esc_html_e( 'Liên hệ', 'nongnghiepnhietdoi' );
				} else {
					echo '—';
				}
				break;
		}
	},
	10,
	2
);

/**
 * Metabox xem chi tiết lead (readonly).
 */
add_action(
	'add_meta_boxes',
	function () {
		add_meta_box(
			'lx_lead_details',
			__( 'Thông tin đăng ký', 'nongnghiepnhietdoi' ),
			'nongnghiepnhietdoi_render_lead_metabox',
			'lx_lead',
			'normal',
			'high'
		);
	}
);

/**
 * Render metabox chi tiết lead.
 *
 * @param WP_Post $post Post hiện tại.
 */
function nongnghiepnhietdoi_render_lead_metabox( $post ) {
	$email        = get_post_meta( $post->ID, '_lx_email', true );
	$phone        = get_post_meta( $post->ID, '_lx_phone', true );
	$message      = get_post_meta( $post->ID, '_lx_message', true );
	$source       = get_post_meta( $post->ID, '_lx_source', true );
	$needs        = nongnghiepnhietdoi_get_lead_needs( $post->ID );
	$project_type = nongnghiepnhietdoi_get_lead_project_type( $post->ID );

	$source_label = 'consult' === $source
		? __( 'Đăng ký tư vấn', 'nongnghiepnhietdoi' )
		: ( 'contact' === $source ? __( 'Liên hệ', 'nongnghiepnhietdoi' ) : '—' );
	?>
	<style>
		.lx-lead-meta { margin: 0; }
		.lx-lead-meta dt { font-weight: 600; margin: 12px 0 4px; color: #1d2327; }
		.lx-lead-meta dt:first-child { margin-top: 0; }
		.lx-lead-meta dd { margin: 0; padding: 8px 12px; background: #f6f7f7; border: 1px solid #dcdcde; border-radius: 4px; white-space: pre-wrap; }
	</style>
	<dl class="lx-lead-meta">
		<dt><?php esc_html_e( 'Họ tên', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo esc_html( $post->post_title ); ?></dd>

		<dt><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '—'; ?></dd>

		<dt><?php esc_html_e( 'Điện thoại', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo $phone ? esc_html( $phone ) : '—'; ?></dd>

		<dt><?php esc_html_e( 'Nhu cầu tư vấn', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo $needs ? esc_html( $needs ) : '—'; ?></dd>

		<dt><?php esc_html_e( 'Loại hình công trình', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo $project_type ? esc_html( $project_type ) : '—'; ?></dd>

		<dt><?php esc_html_e( 'Nguồn', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo esc_html( $source_label ); ?></dd>

		<dt><?php esc_html_e( 'Nội dung', 'nongnghiepnhietdoi' ); ?></dt>
		<dd><?php echo $message ? esc_html( $message ) : '—'; ?></dd>
	</dl>
	<?php
}

/**
 * Ẩn hộp "Xuất bản" phức tạp — lead chỉ xem, không cần chỉnh nhiều.
 * Giữ nguyên UI mặc định WP để xóa/chuyển thùng rác vẫn hoạt động.
 */
add_action(
	'admin_head-edit.php',
	function () {
		$screen = get_current_screen();
		if ( ! $screen || 'edit-lx_lead' !== $screen->id ) {
			return;
		}
		echo '<style>.page-title-action{display:none!important;}</style>';
	}
);

add_action(
	'admin_head-post.php',
	function () {
		$screen = get_current_screen();
		if ( ! $screen || 'lx_lead' !== $screen->id ) {
			return;
		}
		echo '<style>#edit-slug-box,.page-title-action{display:none!important;}#titlediv input{pointer-events:none;background:#f6f7f7;}</style>';
	}
);

/**
 * Bỏ nút "Thêm mới" trên menu/list vì lead chỉ tạo từ frontend.
 */
add_filter(
	'post_row_actions',
	function ( $actions, $post ) {
		if ( 'lx_lead' === $post->post_type ) {
			unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
	},
	10,
	2
);
