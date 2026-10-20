<?php
/**
 * ACF integration: local JSON sync + options page + section renderer helper.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Save ACF field groups as local JSON inside the theme (version control).
add_filter(
	'acf/settings/save_json',
	function () {
		return NONGNGHIEPNHIETDOI_DIR . '/acf-json';
	}
);

// Load ACF field groups from theme local JSON.
add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = NONGNGHIEPNHIETDOI_DIR . '/acf-json';
		return $paths;
	}
);

// Options page for global theme settings (contact info, socials...).
add_action(
	'acf/init',
	function () {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => __( 'Cài đặt Nông nghiệp nhiệt đới', 'nongnghiepnhietdoi' ),
					'menu_title' => __( 'Nông nghiệp nhiệt đới', 'nongnghiepnhietdoi' ),
					'menu_slug'  => 'nongnghiepnhietdoi-settings',
					'capability' => 'edit_theme_options',
					'icon_url'   => 'dashicons-admin-customizer',
					'position'   => 2,
				)
			);
		}
	}
);

/**
 * Giá trị dự phòng khi khách chưa lưu Cài đặt chung.
 * Khớp nội dung đang hiển thị trên site.
 *
 * @return array<string,string>
 */
function nongnghiepnhietdoi_option_defaults() {
	return array(
		'site_short_name'    => 'VARC',
		'site_company_name'  => 'Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới',
		'site_about'         => 'Trung tâm Nghiên cứu và Tư vấn Nông nghiệp Nhiệt đới (VARC) chuyển hóa tiến bộ khoa học thành sinh kế bền vững cho nông dân, giá trị gia tăng cho doanh nghiệp và bảo vệ môi trường sinh thái.',
		'contact_email'      => 'info@nongnghiepnhietdoi.org',
		'contact_address'    => '121 Nguyễn Bỉnh Khiêm, Phường Tân Định, TP. Hồ Chí Minh',
		'contact_hours'      => 'Thứ 2 – Thứ 6: 08:00 – 17:00',
	);
}

/**
 * Safe getter for a theme option field.
 * Trả về giá trị đã lưu, hoặc mặc định của theme nếu ô còn trống.
 *
 * @param string $name Field name.
 * @return mixed
 */
function nongnghiepnhietdoi_option( $name ) {
	$defaults = nongnghiepnhietdoi_option_defaults();

	if ( ! function_exists( 'get_field' ) ) {
		return isset( $defaults[ $name ] ) ? $defaults[ $name ] : '';
	}

	$value = get_field( $name, 'option' );

	// null/false = chưa từng lưu. Chuỗi rỗng = khách cố ý xoá, không đổ lại mặc định.
	if ( null === $value || false === $value ) {
		return isset( $defaults[ $name ] ) ? $defaults[ $name ] : '';
	}

	return $value;
}

/**
 * Ghi giá trị mặc định vào Cài đặt chung lần đầu, để form admin hiện đúng nội dung đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_options_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		foreach ( nongnghiepnhietdoi_option_defaults() as $name => $value ) {
			$current = get_field( $name, 'option' );
			if ( null === $current || false === $current || '' === $current ) {
				update_field( $name, $value, 'option' );
			}
		}

		update_option( 'nongnghiepnhietdoi_options_seeded', 1, false );
	},
	20
);

/**
 * In ra logo Nông nghiệp nhiệt đới từ options page.
 *
 * Ưu tiên: ảnh Logo trong "Cài đặt Nông nghiệp nhiệt đới" → custom logo của WP → tên site.
 *
 * @param string $img_class Class áp cho thẻ <img> của logo tải lên.
 * @param string $text_class Class áp cho fallback tên site.
 * @return void
 */
function nongnghiepnhietdoi_the_logo( $img_class = '', $text_class = 'text-xl font-semibold tracking-wide text-brand md:text-2xl' ) {
	$logo_id = nongnghiepnhietdoi_option( 'site_logo' );

	if ( $logo_id ) {
		echo wp_get_attachment_image(
			(int) $logo_id,
			'full',
			false,
			array(
				'class' => trim( 'lx-logo ' . $img_class ),
				'alt'   => get_bloginfo( 'name' ),
			)
		);
		return;
	}

	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	$seal = NONGNGHIEPNHIETDOI_URI . '/assets/images/logo-varc.png';
	if ( file_exists( NONGNGHIEPNHIETDOI_DIR . '/assets/images/logo-varc.png' ) ) {
		printf(
			'<img src="%s" alt="%s" class="%s" width="48" height="48">',
			esc_url( $seal ),
			esc_attr( get_bloginfo( 'name' ) ),
			esc_attr( trim( 'h-12 w-12 bg-white object-contain ' . $img_class ) )
		);
		return;
	}

	printf( '<span class="%s">%s</span>', esc_attr( $text_class ), esc_html( get_bloginfo( 'name' ) ) );
}

/**
 * CSS khống chế kích thước logo (responsive) — chèn inline để không phụ thuộc
 * bản build Tailwind trong dist/.
 */
add_action(
	'wp_head',
	function () {
		?>
<style id="nongnghiepnhietdoi-logo-inline">
	.lx-logo{display:block;width:auto;height:auto;max-width:220px;max-height:52px;object-fit:contain}
	@media (min-width:768px){.lx-logo{max-width:240px;max-height:60px}}
	@media (min-width:1024px){.lx-logo{max-width:260px;max-height:72px}}
	.site-footer .lx-logo{max-width:260px;max-height:84px}
</style>
		<?php
	},
	20
);

/**
 * Trả về danh sách mạng xã hội đã cấu hình (chỉ những link có giá trị).
 *
 * @return array<string,array{label:string,url:string}>
 */
function nongnghiepnhietdoi_socials() {
	$config = array(
		'facebook' => array(
			'label' => 'Facebook',
			'url'   => nongnghiepnhietdoi_option( 'social_facebook' ),
		),
		'tiktok'   => array(
			'label' => 'TikTok',
			'url'   => nongnghiepnhietdoi_option( 'social_tiktok' ),
		),
		'youtube'  => array(
			'label' => 'YouTube',
			'url'   => nongnghiepnhietdoi_option( 'social_youtube' ),
		),
	);

	return array_filter(
		$config,
		static function ( $social ) {
			return ! empty( $social['url'] );
		}
	);
}

/**
 * Đưa một ảnh trong theme vào thư viện để khách thay trong admin.
 *
 * @param string $relative Path tương đối từ thư mục theme.
 * @param string $title    Tiêu đề attachment.
 * @return int Attachment ID, hoặc 0 nếu lỗi.
 */
function nongnghiepnhietdoi_import_theme_image( $relative, $title ) {
	$path = NONGNGHIEPNHIETDOI_DIR . '/' . ltrim( $relative, '/' );
	if ( ! file_exists( $path ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$filename = wp_unique_filename( wp_upload_dir()['path'], basename( $path ) );
	$upload   = wp_upload_bits( $filename, null, file_get_contents( $path ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$filetype   = wp_check_filetype( $filename, null );
	$attachment = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => $title,
		'post_status'    => 'inherit',
	);
	$id = wp_insert_attachment( $attachment, $upload['file'] );
	if ( is_wp_error( $id ) || ! $id ) {
		return 0;
	}

	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	return (int) $id;
}

/**
 * Ghi nội dung hero trang chủ lần đầu để form admin hiện đúng chữ và ảnh đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_home_hero_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$post_id = (int) get_option( 'page_on_front' );
		if ( ! $post_id ) {
			return;
		}

		$existing = get_field( 'home_hero_title', $post_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_home_hero_seeded', 1, false );
			return;
		}

		update_field( 'home_hero_eyebrow', 'Nghiên cứu & tư vấn', $post_id );
		update_field( 'home_hero_title', 'Tiên phong nông nghiệp thích ứng khí hậu', $post_id );
		update_field( 'home_hero_description', 'Chuyển hóa công nghệ vi sinh, xử lý môi trường và đo lường phát thải thành sinh kế bền vững cho nông dân Việt Nam.', $post_id );
		update_field(
			'home_hero_cta',
			array(
				'title'  => 'Hợp tác dự án',
				'url'    => '#lien-he',
				'target' => '',
			),
			$post_id
		);

		$rows    = array();
		$hero_id = nongnghiepnhietdoi_import_theme_image( 'assets/images/hero-field.jpg', 'Cánh đồng lúa lúc bình minh' );
		$about_id = nongnghiepnhietdoi_import_theme_image( 'assets/images/about-field.jpg', 'Nông sản tươi' );
		if ( $hero_id ) {
			$rows[] = array(
				'media_type' => 'image',
				'image'      => $hero_id,
			);
		}
		if ( $about_id ) {
			$rows[] = array(
				'media_type' => 'image',
				'image'      => $about_id,
			);
		}
		if ( $rows ) {
			update_field( 'home_hero_slides', $rows, $post_id );
		}

		update_option( 'nongnghiepnhietdoi_home_hero_seeded', 1, false );
	},
	30
);

/**
 * ACF location: hiện field group khi trang có slug "gioi-thieu"
 * (dùng kèm page_template để chắc chắn hiện form khi edit trang Giới thiệu).
 */
add_filter(
	'acf/location/rule_types',
	function ( $choices ) {
		$choices[ __( 'Page', 'acf' ) ]['page_slug'] = __( 'Page slug', 'nongnghiepnhietdoi' );
		return $choices;
	}
);

add_filter(
	'acf/location/rule_values/page_slug',
	function ( $choices ) {
		$pages = get_pages( array( 'sort_column' => 'post_title' ) );
		foreach ( $pages as $page ) {
			$choices[ $page->post_name ] = $page->post_title . ' (' . $page->post_name . ')';
		}
		return $choices;
	}
);

add_filter(
	'acf/location/rule_match/page_slug',
	function ( $match, $rule, $screen ) {
		if ( empty( $screen['post_id'] ) ) {
			return $match;
		}
		$post = get_post( (int) $screen['post_id'] );
		if ( ! $post || 'page' !== $post->post_type ) {
			return false;
		}
		$result = ( $post->post_name === $rule['value'] );
		return ( '!=' === $rule['operator'] ) ? ! $result : $result;
	},
	10,
	3
);

/**
 * Render the ACF Flexible Content "page_sections" for the current post.
 * Falls back to nothing when ACF is not active.
 *
 * @param int|null $post_id Optional post ID.
 */
function nongnghiepnhietdoi_render_sections( $post_id = null ) {
	if ( ! function_exists( 'have_rows' ) ) {
		return;
	}

	if ( have_rows( 'page_sections', $post_id ) ) {
		$index = 0;
		while ( have_rows( 'page_sections', $post_id ) ) {
			the_row();
			$layout = get_row_layout();
			set_query_var( 'lx_section_index', $index );
			set_query_var( 'lx_section_is_first', 0 === $index );
			get_template_part( 'template-parts/sections/' . $layout );
			++$index;
		}
		set_query_var( 'lx_section_index', null );
		set_query_var( 'lx_section_is_first', null );
	}
}
