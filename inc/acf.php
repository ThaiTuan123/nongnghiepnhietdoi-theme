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
	img.lx-logo,img.varc-logo{display:block;width:auto;height:auto;max-width:220px;max-height:84px;object-fit:contain;background-color:transparent}
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
 * ID ảnh trong thư viện theo tiêu đề, hoặc nhập từ theme nếu chưa có.
 *
 * @param string $relative Path tương đối từ thư mục theme.
 * @param string $title    Tiêu đề attachment.
 * @return int
 */
function nongnghiepnhietdoi_theme_image_id( $relative, $title ) {
	global $wpdb;

	$existing = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_status = 'inherit' AND post_title = %s ORDER BY ID ASC LIMIT 1",
			$title
		)
	);
	if ( $existing ) {
		return $existing;
	}

	return nongnghiepnhietdoi_import_theme_image( $relative, $title );
}

/**
 * Ghi số liệu và khối Về VARC lần đầu để hộp Meta hiện đúng nội dung đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_home_mid_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$post_id = (int) get_option( 'page_on_front' );
		if ( ! $post_id ) {
			return;
		}

		$existing = get_field( 'home_about_title', $post_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_home_mid_seeded', 1, false );
			return;
		}

		$stats_saved = update_field(
			'home_stats',
			array(
				array(
					'number'  => '25',
					'suffix'  => '+',
					'label'   => 'Chuyên gia & nhà khoa học cố vấn',
					'grouped' => 0,
				),
				array(
					'number'  => '10000',
					'suffix'  => '+',
					'label'   => 'Hợp tác xã & nông dân trong mạng lưới',
					'grouped' => 1,
				),
				array(
					'number'  => '40',
					'suffix'  => '+',
					'label'   => 'Mô hình vi sinh & CSA đã triển khai',
					'grouped' => 0,
				),
				array(
					'number'  => '15',
					'suffix'  => '+',
					'label'   => 'Tỉnh/thành có hoạt động triển khai',
					'grouped' => 0,
				),
			),
			$post_id
		);

		update_field( 'home_about_eyebrow', 'Về VARC', $post_id );
		$title_saved = update_field( 'home_about_title', 'Trung tâm nghiên cứu khoa học', $post_id );
		if ( ! $stats_saved || ! $title_saved ) {
			return;
		}
		update_field( 'home_about_text', 'VARC là đầu mối nghiên cứu và tư vấn nông nghiệp nhiệt đới: đưa công nghệ vi sinh, nông nghiệp thích ứng khí hậu và đo lường phát thải ra đồng ruộng, để nông hộ có sinh kế ổn định hơn và doanh nghiệp có chuỗi cung ứng sạch hơn.', $post_id );
		update_field(
			'home_about_points',
			array(
				array( 'text' => 'Nghiên cứu ứng dụng gắn với hiện trường, không dừng ở phòng thí nghiệm.' ),
				array( 'text' => 'Đồng hành hợp tác xã, doanh nghiệp và cơ quan quản lý trong cùng một mạng lưới.' ),
				array( 'text' => 'Đo được tác động: năng suất, sinh kế và phát thải khí nhà kính.' ),
			),
			$post_id
		);

		$about_image = nongnghiepnhietdoi_theme_image_id( 'assets/images/about-field.jpg', 'Nông sản tươi' );
		if ( $about_image ) {
			update_field( 'home_about_image', $about_image, $post_id );
		}

		update_option( 'nongnghiepnhietdoi_home_mid_seeded', 1, false );
	},
	31
);

/**
 * Ghi năng lực và lĩnh vực lần đầu để hộp Meta hiện đúng nội dung đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_home_blocks_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$post_id = (int) get_option( 'page_on_front' );
		if ( ! $post_id ) {
			return;
		}

		$existing = get_field( 'home_nl_title', $post_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_home_blocks_seeded', 1, false );
			return;
		}

		update_field( 'home_nl_eyebrow', 'Năng lực khác biệt', $post_id );
		$nl_saved = update_field( 'home_nl_title', 'Khoa học ra đồng, đo được kết quả', $post_id );
		update_field( 'home_nl_lead', 'Bốn giai đoạn từ phòng lab ra đồng ruộng', $post_id );
		update_field( 'home_lv_eyebrow', 'Lĩnh vực hoạt động', $post_id );
		$lv_saved = update_field( 'home_lv_title', 'Sáu nhóm việc VARC đang làm', $post_id );
		if ( ! $nl_saved || ! $lv_saved ) {
			return;
		}

		update_field(
			'home_nl_items',
			array(
				array(
					'number' => '01',
					'title'  => 'Vi sinh bản địa',
					'text'   => 'Phân lập, nhân sinh khối và chuyển giao chế phẩm IMO phù hợp đất và cây của từng vùng.',
				),
				array(
					'number' => '02',
					'title'  => 'Hiện trường CSA',
					'text'   => 'Thiết kế mô hình nông nghiệp thông minh với khí hậu, theo mùa vụ và quy mô hợp tác xã.',
				),
				array(
					'number' => '03',
					'title'  => 'Đo phát thải',
					'text'   => 'Phương pháp đo lường phát thải khí nhà kính để đối chiếu trước và sau can thiệp.',
				),
				array(
					'number' => '04',
					'title'  => 'Chuyển giao',
					'text'   => 'Tập huấn nông hộ, sổ tay kỹ thuật và đồng hành sau khi mô hình được bàn giao.',
				),
			),
			$post_id
		);
		update_field(
			'home_lv_items',
			array(
				array(
					'title' => 'Công nghệ vi sinh',
					'text'  => 'Chế phẩm xử lý phụ phẩm, cải tạo đất và tăng sức chống chịu của cây trồng.',
				),
				array(
					'title' => 'Thích ứng khí hậu',
					'text'  => 'Mô hình CSA cho vùng nhiệt đới: nước, giống, lịch mùa và rủi ro thời tiết.',
				),
				array(
					'title' => 'Xử lý môi trường',
					'text'  => 'Ủ phân hữu cơ, giảm đốt phụ phẩm và xử lý ô nhiễm tại nông hộ.',
				),
				array(
					'title' => 'Phát thải khí nhà kính',
					'text'  => 'Đo, báo cáo và đề xuất biện pháp giảm phát thải trên đồng ruộng.',
				),
				array(
					'title' => 'Đào tạo chuyển giao',
					'text'  => 'Cẩm nang, tập huấn hiện trường và mạng lưới khuyến nông cộng đồng.',
				),
				array(
					'title' => 'Tư vấn độc lập',
					'text'  => 'Đánh giá dự án, đề tài khoa học công nghệ và chương trình quốc gia.',
				),
			),
			$post_id
		);

		update_option( 'nongnghiepnhietdoi_home_blocks_seeded', 1, false );
	},
	32
);

/**
 * Bổ sung dòng phụ + đảm bảo 4 giai đoạn hiện trong Meta Boxes (một lần).
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_home_nl_stages_seeded' ) || ! function_exists( 'update_field' ) || ! function_exists( 'get_field' ) ) {
			return;
		}

		$post_id = (int) get_option( 'page_on_front' );
		if ( ! $post_id ) {
			return;
		}

		$lead = get_field( 'home_nl_lead', $post_id );
		if ( ! is_string( $lead ) || '' === $lead ) {
			update_field( 'home_nl_lead', 'Bốn giai đoạn từ phòng lab ra đồng ruộng', $post_id );
		}

		$items = get_field( 'home_nl_items', $post_id );
		$valid = 0;
		if ( is_array( $items ) ) {
			foreach ( $items as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$title = isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
				$text  = isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';
				if ( '' !== $title || '' !== $text ) {
					++$valid;
				}
			}
		}

		if ( $valid < 4 ) {
			update_field(
				'home_nl_items',
				array(
					array(
						'number' => '01',
						'title'  => 'Vi sinh bản địa',
						'text'   => 'Phân lập, nhân sinh khối và chuyển giao chế phẩm IMO phù hợp đất và cây của từng vùng.',
					),
					array(
						'number' => '02',
						'title'  => 'Hiện trường CSA',
						'text'   => 'Thiết kế mô hình nông nghiệp thông minh với khí hậu, theo mùa vụ và quy mô hợp tác xã.',
					),
					array(
						'number' => '03',
						'title'  => 'Đo phát thải',
						'text'   => 'Phương pháp đo lường phát thải khí nhà kính để đối chiếu trước và sau can thiệp.',
					),
					array(
						'number' => '04',
						'title'  => 'Chuyển giao',
						'text'   => 'Tập huấn nông hộ, sổ tay kỹ thuật và đồng hành sau khi mô hình được bàn giao.',
					),
				),
				$post_id
			);
		}

		update_option( 'nongnghiepnhietdoi_home_nl_stages_seeded', 1, false );
	},
	33
);

/**
 * Ghi khối Con người lần đầu để hộp Meta hiện đúng chữ và ảnh đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_home_people_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$post_id = (int) get_option( 'page_on_front' );
		if ( ! $post_id ) {
			return;
		}

		$existing = get_field( 'home_people_title', $post_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_home_people_seeded', 1, false );
			return;
		}

		update_field( 'home_people_eyebrow', 'Con người VARC', $post_id );
		$title_saved = update_field( 'home_people_title', 'Nhà khoa học, kỹ thuật viên và người đứng trên ruộng', $post_id );
		if ( ! $title_saved ) {
			return;
		}

		update_field( 'home_people_text', 'Đội ngũ VARC gồm chuyên gia cố vấn, cán bộ hiện trường và mạng lưới nông dân nòng cốt. Mỗi mô hình có người chịu trách nhiệm khoa học và người chịu trách nhiệm ngoài đồng.', $post_id );

		$scientist = nongnghiepnhietdoi_theme_image_id( 'assets/images/person-scientist.jpg', 'Nhà khoa học cố vấn VARC' );
		$field     = nongnghiepnhietdoi_theme_image_id( 'assets/images/person-field.jpg', 'Cán bộ hiện trường VARC' );
		$farmer    = nongnghiepnhietdoi_theme_image_id( 'assets/images/person-farmer.jpg', 'Nông dân nòng cốt VARC' );

		$rows = array(
			array(
				'title' => 'Nhà khoa học cố vấn',
				'text'  => 'Định hướng đề tài vi sinh, môi trường và phát thải; phản biện quy trình trước khi ra đồng.',
				'image' => $scientist,
			),
			array(
				'title' => 'Cán bộ hiện trường',
				'text'  => 'Lắp đặt mô hình, tập huấn nông hộ và ghi nhận số liệu theo vụ.',
				'image' => $field,
			),
			array(
				'title' => 'Nông dân nòng cốt',
				'text'  => 'Nhân chế phẩm, duy trì mô hình và lan tỏa trong hợp tác xã.',
				'image' => $farmer,
			),
		);

		$saved = update_field( 'home_people_items', $rows, $post_id );
		if ( ! $saved ) {
			return;
		}

		update_option( 'nongnghiepnhietdoi_home_people_seeded', 1, false );
	},
	33
);

/**
 * Ghi khối Hệ sinh thái lần đầu để hộp Meta hiện đúng chữ và ảnh đang chạy.
 */
add_action(
	'acf/init',
	function () {
		if ( get_option( 'nongnghiepnhietdoi_home_eco_seeded' ) || ! function_exists( 'update_field' ) ) {
			return;
		}

		$post_id = (int) get_option( 'page_on_front' );
		if ( ! $post_id ) {
			return;
		}

		$existing = get_field( 'home_eco_title', $post_id );
		if ( is_string( $existing ) && '' !== $existing ) {
			update_option( 'nongnghiepnhietdoi_home_eco_seeded', 1, false );
			return;
		}

		update_field( 'home_eco_eyebrow', 'Hệ sinh thái', $post_id );
		$title_saved = update_field( 'home_eco_title', 'VARC đứng giữa bốn nhóm đối tác', $post_id );
		if ( ! $title_saved ) {
			return;
		}

		$farmers  = nongnghiepnhietdoi_theme_image_id( 'assets/images/eco-farmers.jpg', 'Nông hộ và HTX VARC' );
		$science  = nongnghiepnhietdoi_theme_image_id( 'assets/images/eco-scientist.jpg', 'Nhà khoa học đối tác VARC' );
		$business = nongnghiepnhietdoi_theme_image_id( 'assets/images/eco-business.jpg', 'Doanh nghiệp đối tác VARC' );
		$agency   = nongnghiepnhietdoi_theme_image_id( 'assets/images/eco-agency.jpg', 'Cơ quan quản lý VARC' );

		$rows = array(
			array(
				'title' => 'Nông hộ & HTX',
				'text'  => 'Nơi mô hình được làm, đo và nhân rộng.',
				'image' => $farmers,
			),
			array(
				'title' => 'Nhà khoa học',
				'text'  => 'Nguồn quy trình, phản biện và đào tạo.',
				'image' => $science,
			),
			array(
				'title' => 'Doanh nghiệp',
				'text'  => 'Chuỗi tiêu thụ, chế phẩm và đồng tài trợ thử nghiệm.',
				'image' => $business,
			),
			array(
				'title' => 'Cơ quan quản lý',
				'text'  => 'Chương trình ngành, đề tài và khung đo phát thải.',
				'image' => $agency,
			),
		);

		$saved = update_field( 'home_eco_items', $rows, $post_id );
		if ( ! $saved ) {
			return;
		}

		update_option( 'nongnghiepnhietdoi_home_eco_seeded', 1, false );
	},
	34
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
