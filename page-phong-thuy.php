<?php
/**
 * Template Name: Trang Phong thuỷ
 *
 * Bố cục: Hero → Phong thuỷ nổi bật (1 lớn + 2 phụ) → Tin tức & sự kiện
 * → Kiến thức phong thuỷ → CTA tư vấn.
 *
 * Mỗi section lấy bài theo chuyên mục (category) tương ứng. Tiêu đề section
 * cố định; gán bài vào đúng category trong WP Admin → Bài viết.
 *
 *   phong-thuy-noi-bat   → Phong thuỷ nổi bật (tối đa 3 bài)
 *   tin-tuc-su-kien      → Tin tức & sự kiện (6 / trang, ?tintuc=)
 *   kien-thuc-phong-thuy → Kiến thức phong thuỷ (6 / trang, ?kienthuc=)
 *
 * @package NongNghiepNhietDoi
 */

get_header();

$lx_page_url = get_permalink();
$lx_per_page = 6;

// Phân trang độc lập cho từng section.
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$lx_news_paged = isset( $_GET['tintuc'] ) ? max( 1, (int) $_GET['tintuc'] ) : 1;
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$lx_knowledge_paged = isset( $_GET['kienthuc'] ) ? max( 1, (int) $_GET['kienthuc'] ) : 1;

/**
 * Query bài theo slug chuyên mục.
 *
 * @param string $slug     Category slug.
 * @param int    $n        Số bài mỗi trang.
 * @param int    $paged    Trang hiện tại (0 = không phân trang).
 * @param bool   $no_found Bỏ đếm tổng (khi không cần pagination).
 * @return WP_Query
 */
$lx_query_cat = static function ( $slug, $n, $paged = 0, $no_found = true ) {
	$args = array(
		'post_type'      => 'post',
		'category_name'  => $slug,
		'posts_per_page' => $n,
		'no_found_rows'  => $no_found,
	);
	if ( $paged > 0 ) {
		$args['paged'] = $paged;
	}
	return new WP_Query( $args );
};

/**
 * Render phân trang số trang cho một section (giữ param của section kia).
 *
 * @param string $param   Tên query param (tintuc|kienthuc).
 * @param int    $current Trang hiện tại.
 * @param int    $total   Tổng số trang.
 * @param string $hash    Fragment id section.
 * @param array  $keep    Param khác cần giữ (param => page).
 */
$lx_render_pagination = static function ( $param, $current, $total, $hash, $keep = array() ) use ( $lx_page_url ) {
	if ( $total <= 1 ) {
		return;
	}

	$base = $lx_page_url;
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

$lx_featured  = $lx_query_cat( 'phong-thuy-noi-bat', 3 );
$lx_news      = $lx_query_cat( 'tin-tuc-su-kien', $lx_per_page, $lx_news_paged, false );
$lx_knowledge = $lx_query_cat( 'kien-thuc-phong-thuy', $lx_per_page, $lx_knowledge_paged, false );
?>

<main id="main" class="site-main">

	<!-- ============ Hero banner ============ -->
	<section class="relative flex min-h-[42vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-dark-hero>
		<div class="absolute inset-0">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'nongnghiepnhietdoi-wide', array( 'class' => 'h-full w-full object-cover' ) ); ?>
			<?php else : ?>
				<div class="h-full w-full bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500"></div>
			<?php endif; ?>
			<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/45 to-black/45"></div>
		</div>
		<div class="container-lx relative z-10 pb-10 text-white md:pb-14" data-reveal>
			<h1 class="text-3xl font-bold leading-tight md:text-4xl lg:text-5xl"><?php the_title(); ?></h1>
		</div>
	</section>

	<!-- ============ Phong thuỷ nổi bật (3 bài, layout tin nổi bật) ============ -->
	<section class="py-14 md:py-20" data-section="phong-thuy-noi-bat">
		<div class="container-lx">
			<div class="mb-8 flex items-center gap-4" data-reveal>
				<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Phong thuỷ nổi bật', 'nongnghiepnhietdoi' ); ?></h2>
				<span class="h-px flex-1 bg-neutral-200"></span>
			</div>

			<?php if ( $lx_featured->have_posts() ) : ?>
				<?php
				$lx_feat_posts = $lx_featured->posts;
				$lx_feat_main  = array_shift( $lx_feat_posts );
				?>
				<div class="grid grid-cols-1 gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					$GLOBALS['post'] = $lx_feat_main; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
					setup_postdata( $lx_feat_main );
					$lx_cats = get_the_category();
					$lx_cat  = ! empty( $lx_cats ) ? $lx_cats[0] : null;
					?>
					<article class="group relative col-span-1 overflow-hidden rounded-2xl border border-neutral-200 bg-white lg:col-span-2" data-reveal>
						<a href="<?php the_permalink(); ?>" class="block">
							<div class="aspect-[16/10] w-full lg:aspect-[16/9]">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'nongnghiepnhietdoi-wide', array( 'class' => 'h-full w-full object-cover transition duration-700 group-hover:scale-105' ) ); ?>
								<?php endif; ?>
								<div class="absolute inset-0 bg-gradient-to-t from-white/90 via-white/40 to-transparent"></div>
							</div>
							<div class="absolute inset-x-0 bottom-0 p-6 text-neutral-900 md:p-8">
								<?php if ( $lx_cat ) : ?>
									<span class="mb-3 inline-block rounded-full bg-brand px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-white"><?php echo esc_html( $lx_cat->name ); ?></span>
								<?php endif; ?>
								<h3 class="line-clamp-2 text-xl font-bold leading-snug md:text-2xl lg:text-3xl"><?php the_title(); ?></h3>
								<p class="mt-3 line-clamp-2 max-w-2xl text-sm text-neutral-600 md:text-base"><?php echo esc_html( get_the_excerpt() ); ?></p>
								<div class="mt-4 text-xs uppercase tracking-widest text-neutral-500"><?php echo esc_html( get_the_date() ); ?></div>
							</div>
						</a>
					</article>

					<?php if ( ! empty( $lx_feat_posts ) ) : ?>
						<div class="flex flex-col gap-6">
							<?php
							foreach ( $lx_feat_posts as $lx_feat_post ) :
								$GLOBALS['post'] = $lx_feat_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
								setup_postdata( $lx_feat_post );
								get_template_part( 'template-parts/content', 'news-card' );
							endforeach;
							?>
						</div>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có bài viết trong chuyên mục Phong thủy nổi bật.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- ============ Tin tức & sự kiện ============ -->
	<section id="tin-tuc-su-kien" class="bg-neutral-50 py-14 md:py-20" data-section="tin-tuc-su-kien">
		<div class="container-lx">
			<div class="mb-8 flex items-center gap-4" data-reveal>
				<h2 class="whitespace-nowrap text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Tin tức &amp; sự kiện', 'nongnghiepnhietdoi' ); ?></h2>
				<span class="hidden h-px flex-1 bg-neutral-200 md:block"></span>
			</div>

			<?php if ( $lx_news->have_posts() ) : ?>
				<div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					while ( $lx_news->have_posts() ) :
						$lx_news->the_post();
						get_template_part( 'template-parts/content', 'news-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<?php
				$lx_render_pagination(
					'tintuc',
					$lx_news_paged,
					(int) $lx_news->max_num_pages,
					'tin-tuc-su-kien',
					array( 'kienthuc' => $lx_knowledge_paged )
				);
				?>
			<?php else : ?>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có bài viết trong chuyên mục Tin tức & sự kiện.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- ============ Kiến thức phong thuỷ ============ -->
	<section id="kien-thuc-phong-thuy" class="py-14 md:py-20" data-section="kien-thuc-phong-thuy">
		<div class="container-lx">
			<div class="mb-8 flex items-center gap-4" data-reveal>
				<h2 class="whitespace-nowrap text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Kiến thức phong thuỷ', 'nongnghiepnhietdoi' ); ?></h2>
				<span class="hidden h-px flex-1 bg-neutral-200 md:block"></span>
			</div>

			<?php if ( $lx_knowledge->have_posts() ) : ?>
				<div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					while ( $lx_knowledge->have_posts() ) :
						$lx_knowledge->the_post();
						get_template_part( 'template-parts/content', 'news-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<?php
				$lx_render_pagination(
					'kienthuc',
					$lx_knowledge_paged,
					(int) $lx_knowledge->max_num_pages,
					'kien-thuc-phong-thuy',
					array( 'tintuc' => $lx_news_paged )
				);
				?>
			<?php else : ?>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có bài viết trong chuyên mục Kiến thức phong thủy.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/consult', 'cta' ); ?>

</main>

<?php
get_footer();
