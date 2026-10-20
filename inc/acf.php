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
 * Safe getter for a theme option field. Returns '' if ACF is not active.
 *
 * @param string $name Field name.
 * @return mixed
 */
function nongnghiepnhietdoi_option( $name ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}
	return get_field( $name, 'option' );
}

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
