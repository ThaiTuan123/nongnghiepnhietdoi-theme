<?php
/**
 * SEO: meta description, keywords, canonical, Open Graph, Twitter Card, JSON-LD.
 *
 * Theme tự xử lý SEO (không dùng plugin). Ưu tiên giá trị khách nhập qua ACF,
 * sau đó tới nội dung bài viết, cuối cùng là giá trị mặc định của theme.
 *
 * @package NongNghiepNhietDoi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mô tả (meta description) mặc định toàn site khi khách chưa nhập trong
 * "Cài đặt Nông nghiệp nhiệt đới → SEO". Có thể ghi đè qua ACF nên không phải nội dung cứng.
 */
define(
	'NONGNGHIEPNHIETDOI_DEFAULT_DESCRIPTION',
	'Giúp cho các doanh nghiệp phát triển trường tồn bằng các giải pháp toàn diện, trở thành Nông nghiệp nhiệt đới.'
);

/**
 * Lấy option SEO an toàn (rỗng nếu ACF chưa bật).
 *
 * @param string $name Tên field.
 * @return mixed
 */
function nongnghiepnhietdoi_seo_option( $name ) {
	return function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( $name ) : '';
}

/**
 * Chuẩn hoá 1 đoạn text để dùng làm meta: bỏ HTML, gộp khoảng trắng, cắt độ dài.
 *
 * @param string $text  Nội dung thô.
 * @param int    $limit Số ký tự tối đa.
 * @return string
 */
function nongnghiepnhietdoi_seo_clean( $text, $limit = 160 ) {
	$text = wp_strip_all_tags( (string) $text, true );
	$text = trim( preg_replace( '/\s+/', ' ', $text ) );

	if ( function_exists( 'mb_strlen' ) && mb_strlen( $text ) > $limit ) {
		$text = rtrim( mb_substr( $text, 0, $limit - 1 ) ) . '…';
	}

	return $text;
}

/**
 * Meta description cho ngữ cảnh hiện tại.
 *
 * @return string
 */
function nongnghiepnhietdoi_meta_description() {
	$desc = '';

	if ( is_singular() ) {
		$seo_desc = function_exists( 'get_field' ) ? get_field( 'seo_description' ) : '';

		if ( $seo_desc ) {
			$desc = $seo_desc;
		} elseif ( has_excerpt() ) {
			$desc = get_the_excerpt();
		} else {
			$desc = get_post_field( 'post_content', get_queried_object_id() );
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$desc = term_description();
	} elseif ( is_post_type_archive() || is_home() ) {
		$desc = get_the_archive_description();
	} elseif ( is_search() ) {
		/* translators: %s: search query. */
		$desc = sprintf( __( 'Kết quả tìm kiếm cho "%s" trên Nông nghiệp nhiệt đới.', 'nongnghiepnhietdoi' ), get_search_query() );
	}

	if ( ! $desc ) {
		$desc = nongnghiepnhietdoi_seo_option( 'seo_default_description' );
	}

	if ( ! $desc ) {
		$desc = NONGNGHIEPNHIETDOI_DEFAULT_DESCRIPTION;
	}

	return nongnghiepnhietdoi_seo_clean( $desc, 300 );
}

/**
 * Tiêu đề (title) cho ngữ cảnh hiện tại, ưu tiên field seo_title.
 *
 * @return string
 */
function nongnghiepnhietdoi_seo_title() {
	if ( is_singular() ) {
		$seo_title = function_exists( 'get_field' ) ? get_field( 'seo_title' ) : '';
		if ( $seo_title ) {
			return $seo_title;
		}
	}

	return wp_get_document_title();
}

/**
 * Ảnh chia sẻ (og:image). Ưu tiên ảnh SEO của bài → thumbnail → ảnh mặc định.
 *
 * @return string URL ảnh hoặc '' nếu không có.
 */
function nongnghiepnhietdoi_seo_image() {
	$image_id = 0;

	if ( is_singular() ) {
		if ( function_exists( 'get_field' ) ) {
			$field = get_field( 'seo_image' );
			if ( $field ) {
				$image_id = (int) $field;
			}
		}
		if ( ! $image_id && has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
		}
	}

	if ( ! $image_id ) {
		$default = nongnghiepnhietdoi_seo_option( 'seo_share_image' );
		if ( $default ) {
			$image_id = (int) $default;
		}
	}

	if ( $image_id ) {
		$src = wp_get_attachment_image_url( $image_id, 'nongnghiepnhietdoi-wide' );
		if ( $src ) {
			return $src;
		}
	}

	return '';
}

/**
 * URL chính tắc (canonical) cho ngữ cảnh hiện tại.
 *
 * @return string
 */
function nongnghiepnhietdoi_seo_canonical() {
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_front_page() || is_home() ) {
		return home_url( '/' );
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$link = get_term_link( get_queried_object() );
		return is_wp_error( $link ) ? home_url( '/' ) : $link;
	}
	if ( is_post_type_archive() ) {
		$link = get_post_type_archive_link( get_post_type() );
		return $link ? $link : home_url( '/' );
	}

	global $wp;
	return home_url( add_query_arg( array(), $wp->request ) );
}

// Tự in canonical riêng nên gỡ canonical mặc định của WP để tránh trùng lặp.
remove_action( 'wp_head', 'rel_canonical' );

/**
 * In toàn bộ thẻ SEO vào <head>.
 */
add_action(
	'wp_head',
	function () {
		$title       = nongnghiepnhietdoi_seo_title();
		$description = nongnghiepnhietdoi_meta_description();
		$canonical   = nongnghiepnhietdoi_seo_canonical();
		$image       = nongnghiepnhietdoi_seo_image();
		$site_name   = get_bloginfo( 'name' );
		$keywords    = nongnghiepnhietdoi_seo_option( 'seo_keywords' );
		$og_type     = is_singular( array( 'post' ) ) ? 'article' : 'website';

		echo "\n\t<!-- SEO Nông nghiệp nhiệt đới -->\n";

		printf( "\t<meta name=\"description\" content=\"%s\">\n", esc_attr( $description ) );

		if ( $keywords ) {
			printf( "\t<meta name=\"keywords\" content=\"%s\">\n", esc_attr( $keywords ) );
		}

		printf( "\t<link rel=\"canonical\" href=\"%s\">\n", esc_url( $canonical ) );

		// Open Graph.
		printf( "\t<meta property=\"og:type\" content=\"%s\">\n", esc_attr( $og_type ) );
		printf( "\t<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( $site_name ) );
		printf( "\t<meta property=\"og:locale\" content=\"%s\">\n", esc_attr( get_locale() ) );
		printf( "\t<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
		printf( "\t<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $description ) );
		printf( "\t<meta property=\"og:url\" content=\"%s\">\n", esc_url( $canonical ) );

		if ( $image ) {
			printf( "\t<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image ) );
		}

		// Twitter Card.
		printf( "\t<meta name=\"twitter:card\" content=\"%s\">\n", esc_attr( $image ? 'summary_large_image' : 'summary' ) );
		printf( "\t<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $title ) );
		printf( "\t<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $description ) );
		if ( $image ) {
			printf( "\t<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $image ) );
		}

		echo "\t<!-- /SEO Nông nghiệp nhiệt đới -->\n";
	},
	1
);

/**
 * JSON-LD Organization schema (dùng thông tin từ "Cài đặt Nông nghiệp nhiệt đới").
 */
add_action(
	'wp_head',
	function () {
		if ( ! ( is_front_page() || is_home() ) ) {
			return;
		}

		$data = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Organization',
			'name'        => get_bloginfo( 'name' ),
			'url'         => home_url( '/' ),
			'description' => nongnghiepnhietdoi_meta_description(),
		);

		$logo_id = function_exists( 'nongnghiepnhietdoi_option' ) ? nongnghiepnhietdoi_option( 'site_logo' ) : '';
		if ( $logo_id ) {
			$logo_url = wp_get_attachment_image_url( (int) $logo_id, 'full' );
			if ( $logo_url ) {
				$data['logo'] = $logo_url;
			}
		}

		$phone   = nongnghiepnhietdoi_seo_option( 'contact_phone' );
		$email   = nongnghiepnhietdoi_seo_option( 'contact_email' );
		$address = nongnghiepnhietdoi_seo_option( 'contact_address' );

		if ( $phone || $email ) {
			$contact = array(
				'@type'       => 'ContactPoint',
				'contactType' => 'customer service',
			);
			if ( $phone ) {
				$contact['telephone'] = $phone;
			}
			if ( $email ) {
				$contact['email'] = $email;
			}
			$data['contactPoint'] = $contact;
		}

		if ( $address ) {
			$data['address'] = array(
				'@type'         => 'PostalAddress',
				'streetAddress' => nongnghiepnhietdoi_seo_clean( $address, 300 ),
			);
		}

		if ( function_exists( 'nongnghiepnhietdoi_socials' ) ) {
			$same_as = array_values(
				array_map(
					static function ( $social ) {
						return $social['url'];
					},
					nongnghiepnhietdoi_socials()
				)
			);
			if ( $same_as ) {
				$data['sameAs'] = $same_as;
			}
		}

		printf(
			"\t<script type=\"application/ld+json\">%s</script>\n",
			wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
	},
	5
);

/**
 * Cho phép field seo_title ghi đè tiêu đề tài liệu.
 */
add_filter(
	'document_title_parts',
	function ( $parts ) {
		if ( is_singular() && function_exists( 'get_field' ) ) {
			$seo_title = get_field( 'seo_title' );
			if ( $seo_title ) {
				$parts['title'] = $seo_title;
			}
		}
		return $parts;
	}
);

/**
 * Dấu phân cách tiêu đề theo phong cách thương hiệu.
 */
add_filter(
	'document_title_separator',
	function () {
		return '–';
	}
);
