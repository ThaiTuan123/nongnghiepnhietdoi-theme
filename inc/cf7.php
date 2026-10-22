<?php
/**
 * Contact Form 7: tạo form mặc định và helper shortcode.
 *
 * Form:
 * - Liên hệ — Gửi phản hồi (trang /lien-he/ + section homepage)
 * - Footer — Đăng ký bản tin
 * - Hợp tác — Hồ sơ năng lực / Call for Proposal (trang /hop-tac-du-an/)
 *
 * Sửa nội dung / mail trong WP Admin → Contact → Contact Forms.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Định nghĩa form CF7 của theme.
 *
 * @return array<string,array{title:string,form:string,mail:array<string,mixed>}>
 */
function nongnghiepnhietdoi_cf7_definitions() {
	return array(
		'contact'  => array(
			'title' => 'Liên hệ — Gửi phản hồi',
			'form'  => trim(
				'
<label> Họ và tên <span class="required">*</span>
    [text* your-name autocomplete:name] </label>

<label> Email <span class="required">*</span>
    [email* your-email autocomplete:email] </label>

<label> Điện thoại
    [tel your-phone autocomplete:tel] </label>

<label> Nội dung <span class="required">*</span>
    [textarea* your-message] </label>

[submit "Gửi thông tin →"]
'
			),
			'mail'  => array(
				'subject'            => '[_site_title] Liên hệ mới từ [your-name]',
				'sender'             => '[_site_title] <[_site_admin_email]>',
				'recipient'          => '[_site_admin_email]',
				'body'               => "Họ tên: [your-name]\nEmail: [your-email]\nĐiện thoại: [your-phone]\n\nNội dung:\n[your-message]\n\n--\nTin này được gửi từ form liên hệ trên [_site_title] ([_site_url]).",
				'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
			),
		),
		'footer'      => array(
			'title' => 'Footer — Đăng ký bản tin',
			// Một dòng để CF7 không chèn <br> giữa email và nút.
			'form'  => '[email* your-email autocomplete:email placeholder "Email"][submit "→"]',
			'mail'  => array(
				'subject'            => '[_site_title] Đăng ký nhận bản tin',
				'sender'             => '[_site_title] <[_site_admin_email]>',
				'recipient'          => '[_site_admin_email]',
				'body'               => "Email đăng ký bản tin: [your-email]\n\n--\nTin này được gửi từ form footer trên [_site_title] ([_site_url]).",
				'additional_headers' => 'Reply-To: [your-email]',
			),
		),
		'partnership' => array(
			'title' => 'Hợp tác — Hồ sơ năng lực / CFP',
			'form'  => trim(
				'
[hidden your-audience]

<label> Họ và tên <span class="required">*</span>
    [text* your-name autocomplete:name] </label>

<label> Email <span class="required">*</span>
    [email* your-email autocomplete:email] </label>

<label> Điện thoại
    [tel your-phone autocomplete:tel] </label>

<label> Đơn vị / Tổ chức
    [text your-org autocomplete:organization] </label>

<label> Tiêu đề
    [select your-subject "Yêu cầu Hồ sơ năng lực" "Gửi Call for Proposal" "Đề xuất hợp tác — Nhà tài trợ / NGO" "Đề xuất hợp tác — Doanh nghiệp / HTX" "Đề xuất hợp tác — Chuyên gia / Nhà khoa học"] </label>

<label> Nội dung <span class="required">*</span>
    [textarea* your-message] </label>

<label> Tệp đính kèm (PDF, DOC, ZIP ≤ 20MB)
    [file your-file filetypes:pdf|doc|docx|zip limit:20mb] </label>

[submit "Gửi thông tin →"]
'
			),
			'mail'  => array(
				'subject'            => '[_site_title] Hợp tác / CFP từ [your-name]',
				'sender'             => '[_site_title] <[_site_admin_email]>',
				'recipient'          => '[_site_admin_email]',
				'body'               => "Họ tên: [your-name]\nEmail: [your-email]\nĐiện thoại: [your-phone]\nĐơn vị: [your-org]\nTiêu đề: [your-subject]\nCổng đề xuất: [your-audience]\n\nNội dung:\n[your-message]\n\n--\nTin này được gửi từ form Hợp tác & dự án trên [_site_title] ([_site_url]).",
				'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
				'attachments'        => '[your-file]',
			),
		),
	);
}

/** Version định nghĩa form — tăng khi cần sync lại nội dung CF7 đã seed. */
const NONGNGHIEPNHIETDOI_CF7_DEFS_VER = '1.2';

/**
 * ID form CF7 theo key (contact|footer|partnership). Tạo nếu chưa có.
 *
 * @param string $key contact|footer|partnership.
 * @return int
 */
function nongnghiepnhietdoi_cf7_form_id( $key ) {
	static $cache = array();

	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}

	$defs = nongnghiepnhietdoi_cf7_definitions();
	if ( ! isset( $defs[ $key ] ) ) {
		$cache[ $key ] = 0;
		return 0;
	}

	$option_key = 'nongnghiepnhietdoi_cf7_' . $key . '_id';
	$stored     = (int) get_option( $option_key );
	if ( $stored && 'publish' === get_post_status( $stored ) && 'wpcf7_contact_form' === get_post_type( $stored ) ) {
		$cache[ $key ] = $stored;
		return $stored;
	}

	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		$cache[ $key ] = 0;
		return 0;
	}

	$title = $defs[ $key ]['title'];
	$found = get_posts(
		array(
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'publish',
			'title'          => $title,
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( $found ) {
		$id = (int) $found[0];
		update_option( $option_key, $id, false );
		$cache[ $key ] = $id;
		return $id;
	}

	$contact_form = WPCF7_ContactForm::get_template(
		array(
			'title' => $title,
		)
	);

	$props         = $contact_form->get_properties();
	$props['form'] = $defs[ $key ]['form'];

	foreach ( $defs[ $key ]['mail'] as $mail_key => $mail_val ) {
		$props['mail'][ $mail_key ] = $mail_val;
	}
	$props['mail']['use_html']      = false;
	$props['mail']['exclude_blank'] = false;

	$messages = isset( $props['messages'] ) && is_array( $props['messages'] ) ? $props['messages'] : array();
	$messages['mail_sent_ok'] = 'Cảm ơn bạn! Chúng tôi đã nhận được thông tin và sẽ liên hệ lại sớm nhất.';
	$props['messages']        = $messages;

	$contact_form->set_properties( $props );
	$id = (int) $contact_form->save();

	if ( $id ) {
		update_option( $option_key, $id, false );
	}

	$cache[ $key ] = $id;
	return $id;
}

/**
 * Đồng bộ form/mail từ định nghĩa theme vào form CF7 đã seed.
 *
 * @param string $key contact|footer|partnership.
 * @return void
 */
function nongnghiepnhietdoi_cf7_sync_form( $key ) {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$id = nongnghiepnhietdoi_cf7_form_id( $key );
	if ( ! $id ) {
		return;
	}

	$defs = nongnghiepnhietdoi_cf7_definitions();
	if ( ! isset( $defs[ $key ] ) ) {
		return;
	}

	$contact_form = WPCF7_ContactForm::get_instance( $id );
	if ( ! $contact_form ) {
		return;
	}

	$props         = $contact_form->get_properties();
	$props['form'] = $defs[ $key ]['form'];

	foreach ( $defs[ $key ]['mail'] as $mail_key => $mail_val ) {
		$props['mail'][ $mail_key ] = $mail_val;
	}

	$messages = isset( $props['messages'] ) && is_array( $props['messages'] ) ? $props['messages'] : array();
	$messages['mail_sent_ok'] = 'Cảm ơn bạn! Chúng tôi đã nhận được thông tin và sẽ liên hệ lại sớm nhất.';
	$props['messages']        = $messages;

	$contact_form->set_properties( $props );
	$contact_form->save();
}

/**
 * Shortcode CF7 theo key.
 *
 * @param string $key contact|footer|partnership.
 * @return string
 */
function nongnghiepnhietdoi_cf7_shortcode( $key ) {
	$id = nongnghiepnhietdoi_cf7_form_id( $key );
	if ( ! $id ) {
		return '';
	}
	return '[contact-form-7 id="' . absint( $id ) . '"]';
}

/**
 * In form CF7 (hoặc thông báo nếu plugin chưa bật).
 *
 * @param string               $key     contact|footer|partnership.
 * @param array<string,string> $classes class wrapper.
 * @return void
 */
function nongnghiepnhietdoi_cf7_render( $key, $classes = array() ) {
	$shortcode = nongnghiepnhietdoi_cf7_shortcode( $key );
	$wrap      = isset( $classes['wrap'] ) ? $classes['wrap'] : '';

	if ( ! $shortcode || ! shortcode_exists( 'contact-form-7' ) ) {
		if ( current_user_can( 'manage_options' ) ) {
			echo '<p class="text-sm text-red-600">';
			esc_html_e( 'Cần kích hoạt plugin Contact Form 7 để hiện form.', 'nongnghiepnhietdoi' );
			echo '</p>';
		}
		return;
	}

	if ( $wrap ) {
		echo '<div class="' . esc_attr( $wrap ) . '">';
	}
	echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	if ( $wrap ) {
		echo '</div>';
	}
}

/**
 * Seed + sync form khi CF7 sẵn sàng.
 */
add_action(
	'init',
	static function () {
		if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
			return;
		}
		nongnghiepnhietdoi_cf7_form_id( 'contact' );
		nongnghiepnhietdoi_cf7_form_id( 'footer' );
		nongnghiepnhietdoi_cf7_form_id( 'partnership' );

		$ver = (string) get_option( 'nongnghiepnhietdoi_cf7_defs_ver', '' );
		if ( $ver === NONGNGHIEPNHIETDOI_CF7_DEFS_VER ) {
			return;
		}
		nongnghiepnhietdoi_cf7_sync_form( 'contact' );
		nongnghiepnhietdoi_cf7_sync_form( 'footer' );
		nongnghiepnhietdoi_cf7_sync_form( 'partnership' );
		update_option( 'nongnghiepnhietdoi_cf7_defs_ver', NONGNGHIEPNHIETDOI_CF7_DEFS_VER, false );
	},
	20
);

/**
 * Email nhận CF7: ưu tiên Email liên hệ trong Cài đặt theme.
 *
 * @param array             $components Mail components.
 * @param WPCF7_ContactForm $contact_form Form.
 * @param WPCF7_Mail        $mail Mail object.
 * @return array
 */
add_filter(
	'wpcf7_mail_components',
	static function ( $components, $contact_form, $mail ) {
		unset( $contact_form, $mail );
		if ( ! function_exists( 'nongnghiepnhietdoi_option' ) ) {
			return $components;
		}
		$email = nongnghiepnhietdoi_option( 'contact_email' );
		if ( is_email( $email ) ) {
			$components['recipient'] = $email;
		}
		return $components;
	},
	10,
	3
);
