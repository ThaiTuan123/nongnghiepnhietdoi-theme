<?php
/**
 * Archive Dự án (post type: du_an).
 *
 * Bố cục: Bất động sản nổi bật (slider full-width) → Đất nền biệt thự
 * → Danh sách dự án → CTA tư vấn.
 *
 * Mỗi section lấy dự án theo loại (taxonomy loai_du_an). Tiêu đề section cố định;
 * gán dự án vào đúng loại trong WP Admin → Bất động sản → Loại dự án.
 *
 *   bat-dong-san-noi-bat → Bất động sản nổi bật (slider full-width, tối đa 5)
 *   dat-nen-biet-thu     → Đất nền biệt thự (6 / trang, ?datnen=)
 *   du-an                → Danh sách dự án (6 / trang, ?duan=)
 *
 * @package NongNghiepNhietDoi
 */

get_header();

$lx_archive_url = get_post_type_archive_link( 'du_an' );
$lx_per_page    = 6;

// Phân trang độc lập cho từng section (query string).
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$lx_land_paged = isset( $_GET['datnen'] ) ? max( 1, (int) $_GET['datnen'] ) : 1;
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$lx_list_paged = isset( $_GET['duan'] ) ? max( 1, (int) $_GET['duan'] ) : max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

/**
 * Query dự án theo slug loại dự án.
 *
 * @param string $slug     Term slug (loai_du_an).
 * @param int    $n        Số bài mỗi trang.
 * @param int    $paged    Trang hiện tại (0 = không phân trang).
 * @param bool   $no_found Bỏ đếm tổng (khi không cần pagination).
 * @return WP_Query
 */
$lx_query_type = static function ( $slug, $n, $paged = 0, $no_found = true ) {
	$args = array(
		'post_type'      => 'du_an',
		'posts_per_page' => $n,
		'no_found_rows'  => $no_found,
		'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'loai_du_an',
				'field'    => 'slug',
				'terms'    => $slug,
			),
		),
	);
	if ( $paged > 0 ) {
		$args['paged'] = $paged;
	}
	return new WP_Query( $args );
};

/**
 * Render phân trang số trang cho một section (giữ param của section kia).
 *
 * @param string $param   Tên query param (datnen|duan).
 * @param int    $current Trang hiện tại.
 * @param int    $total   Tổng số trang.
 * @param string $hash    Fragment id section.
 * @param array  $keep    Param khác cần giữ (param => page).
 */
$lx_render_pagination = static function ( $param, $current, $total, $hash, $keep = array() ) use ( $lx_archive_url ) {
	if ( $total <= 1 ) {
		return;
	}

	$base = $lx_archive_url;
	foreach ( $keep as $keep_param => $keep_page ) {
		if ( (int) $keep_page > 1 ) {
			$base = add_query_arg( $keep_param, (int) $keep_page, $base );
		}
	}

	$base = add_query_arg( $param, '%#%', $base );
	if ( $hash ) {
		$base .= '#' . ltrim( $hash, '#' );
	}

	echo '<nav class="lx-pagination mt-12" aria-label="' . esc_attr__( 'Phân trang', 'nongnghiepnhietdoi' ) . '">';
	echo paginate_links(
		array(
			'base'      => esc_url_raw( $base ),
			'format'    => '',
			'type'      => 'list',
			'current'   => $current,
			'total'     => $total,
			'end_size'  => 1,
			'mid_size'  => 1,
			'prev_text' => '‹',
			'next_text' => '›',
		)
	);
	echo '</nav>';
};

$lx_featured = $lx_query_type( 'bat-dong-san-noi-bat', 5 );
$lx_land     = $lx_query_type( 'dat-nen-biet-thu', $lx_per_page, $lx_land_paged, false );
$lx_list     = $lx_query_type( 'du-an', $lx_per_page, $lx_list_paged, false );
?>

<main id="main" class="site-main">

	<h1 class="sr-only"><?php esc_html_e( 'Bất động sản', 'nongnghiepnhietdoi' ); ?></h1>

	<!-- ============ Bất động sản nổi bật (full-width slider) ============ -->
	<?php if ( $lx_featured->have_posts() ) : ?>
		<?php
		$lx_slider_slides = array();
		foreach ( $lx_featured->posts as $lx_slide_post ) {
			$GLOBALS['post'] = $lx_slide_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
			setup_postdata( $lx_slide_post );

			$lx_terms = get_the_terms( get_the_ID(), 'loai_du_an' );
			$lx_term  = ( ! is_wp_error( $lx_terms ) && ! empty( $lx_terms ) ) ? $lx_terms[0] : null;
			$lx_gia   = get_field( 'gia' );
			$lx_meta  = array();
			$lx_pn    = get_field( 'phong_ngu' );
			$lx_dt    = get_field( 'dien_tich' );
			if ( '' !== $lx_pn && null !== $lx_pn ) {
				$lx_meta[] = $lx_pn . ' PN';
			}
			if ( '' !== $lx_dt && null !== $lx_dt ) {
				$lx_meta[] = $lx_dt . ' m²';
			}

			$lx_excerpt = get_field( 'dia_chi' );
			if ( ! $lx_excerpt ) {
				$lx_excerpt = get_the_excerpt();
			}

			$lx_slider_slides[] = array(
				'image'    => get_the_post_thumbnail_url( get_the_ID(), 'nongnghiepnhietdoi-wide' ) ?: '',
				'thumb'    => get_the_post_thumbnail_url( get_the_ID(), 'nongnghiepnhietdoi-card' ) ?: '',
				'title'    => get_the_title(),
				'category' => $lx_term ? $lx_term->name : '',
				'excerpt'  => $lx_excerpt ? wp_strip_all_tags( $lx_excerpt ) : '',
				'url'      => get_permalink(),
				'price'    => $lx_gia ? (string) $lx_gia : '',
				'meta'     => implode( ' · ', $lx_meta ),
			);
		}
		wp_reset_postdata();

		$lx_slider_props = wp_json_encode(
			array(
				'slides'   => $lx_slider_slides,
				'interval' => 5000,
			),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		);
		$lx_first_slide = $lx_slider_slides[0] ?? null;
		?>
		<section
			class="relative min-h-[70vh] w-full overflow-hidden pt-24 md:min-h-[78vh] lg:min-h-[85vh]"
			data-section="bat-dong-san-noi-bat"
			data-dark-hero
		>
			<div
				class="absolute inset-0"
				data-vue="FeaturedProjectSlider"
				data-props="<?php echo esc_attr( $lx_slider_props ); ?>"
			>
				<?php if ( ! empty( $lx_first_slide['image'] ) ) : ?>
					<img
						src="<?php echo esc_url( $lx_first_slide['image'] ); ?>"
						alt="<?php echo esc_attr( $lx_first_slide['title'] ); ?>"
						class="h-full w-full object-cover"
						fetchpriority="high"
					>
					<div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/25"></div>
					<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/30"></div>
					<div class="absolute inset-0 flex flex-col justify-center px-5 py-16 text-white sm:px-8 md:px-12 lg:max-w-[58%] lg:px-16">
						<?php if ( ! empty( $lx_first_slide['category'] ) ) : ?>
							<p class="mb-3 text-xs font-medium uppercase tracking-[0.18em] text-white/80"><?php echo esc_html( $lx_first_slide['category'] ); ?></p>
						<?php endif; ?>
						<h2 class="text-2xl font-bold leading-tight sm:text-3xl md:text-4xl lg:text-5xl"><?php echo esc_html( $lx_first_slide['title'] ); ?></h2>
					</div>
				<?php else : ?>
					<div class="h-full w-full bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500"></div>
				<?php endif; ?>
			</div>
		</section>
	<?php else : ?>
		<section class="bg-white py-14 pt-28 md:py-20 md:pt-36" data-section="bat-dong-san-noi-bat">
			<div class="container-lx">
				<div class="mb-4 flex items-center gap-4">
					<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Bất động sản nổi bật', 'nongnghiepnhietdoi' ); ?></h2>
					<span class="h-px flex-1 bg-neutral-200"></span>
				</div>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có dự án trong loại Bất động sản nổi bật.', 'nongnghiepnhietdoi' ); ?></p>
			</div>
		</section>
	<?php endif; ?>

	<!-- ============ Đất nền biệt thự ============ -->
	<section id="dat-nen-biet-thu" class="bg-neutral-50 py-14 md:py-20" data-section="dat-nen-biet-thu">
		<div class="container-lx">
			<div class="mb-8 flex items-center gap-4" data-reveal>
				<h2 class="whitespace-nowrap text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Đất nền biệt thự', 'nongnghiepnhietdoi' ); ?></h2>
				<span class="hidden h-px flex-1 bg-neutral-200 md:block"></span>
			</div>

			<?php if ( $lx_land->have_posts() ) : ?>
				<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					while ( $lx_land->have_posts() ) :
						$lx_land->the_post();
						get_template_part( 'template-parts/content-project', 'card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<?php
				$lx_render_pagination(
					'datnen',
					$lx_land_paged,
					(int) $lx_land->max_num_pages,
					'dat-nen-biet-thu',
					array( 'duan' => $lx_list_paged )
				);
				?>
			<?php else : ?>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có dự án trong loại Đất nền biệt thự.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- ============ Danh sách dự án ============ -->
	<section id="du-an-list" class="py-14 md:py-20" data-section="du-an-list">
		<div class="container-lx">
			<div class="mb-8 flex items-center gap-4" data-reveal>
				<h2 class="whitespace-nowrap text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Danh sách dự án', 'nongnghiepnhietdoi' ); ?></h2>
				<span class="hidden h-px flex-1 bg-neutral-200 md:block"></span>
			</div>

			<?php if ( $lx_list->have_posts() ) : ?>
				<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					while ( $lx_list->have_posts() ) :
						$lx_list->the_post();
						get_template_part( 'template-parts/content-project', 'card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<?php
				$lx_render_pagination(
					'duan',
					$lx_list_paged,
					(int) $lx_list->max_num_pages,
					'du-an-list',
					array( 'datnen' => $lx_land_paged )
				);
				?>
			<?php else : ?>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có dự án trong loại Dự án.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/consult', 'cta' ); ?>

</main>

<?php
get_footer();
