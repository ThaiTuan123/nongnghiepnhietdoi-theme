<?php
/**
 * Template Name: Trang Tin tức
 *
 * Bố cục: Hero banner → "Tin nổi bật" (1 bài lớn + 2 bài phụ) →
 * "Tin tức & sự kiện" (bộ lọc chuyên mục + lưới bài viết + phân trang).
 *
 * Bộ lọc chuyên mục: chọn trong WP Admin → trang Tin tức →
 * "Chuyên mục hiển thị trên bộ lọc" (ACF). Nếu để trống thì lấy tất cả
 * chuyên mục có bài, trừ Uncategorized.
 *
 * @package NongNghiepNhietDoi
 */

get_header();

// Phân trang qua query param để tránh xung đột rewrite trên trang tĩnh.
$lx_paged  = isset( $_GET['trang'] ) ? max( 1, (int) $_GET['trang'] ) : 1;
$lx_filter = isset( $_GET['chuyen_muc'] ) ? sanitize_title( wp_unslash( $_GET['chuyen_muc'] ) ) : '';

$lx_base_url = get_permalink();

/**
 * Chuyên mục cho bộ lọc: ưu tiên ACF trên trang; fallback = chuyên mục có bài
 * (bỏ Uncategorized).
 *
 * @return WP_Term[]
 */
$lx_terms = array();
if ( function_exists( 'get_field' ) ) {
	$lx_picked = get_field( 'tt_filter_categories' );
	if ( ! empty( $lx_picked ) && is_array( $lx_picked ) ) {
		foreach ( $lx_picked as $lx_item ) {
			if ( $lx_item instanceof WP_Term ) {
				$lx_terms[] = $lx_item;
			} elseif ( is_numeric( $lx_item ) ) {
				$lx_term_obj = get_term( (int) $lx_item, 'category' );
				if ( $lx_term_obj && ! is_wp_error( $lx_term_obj ) ) {
					$lx_terms[] = $lx_term_obj;
				}
			}
		}
	}
}
if ( empty( $lx_terms ) ) {
	$lx_terms = get_categories(
		array(
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_category' ) ),
		)
	);
}

$lx_term_slugs = wp_list_pluck( $lx_terms, 'slug' );
$lx_term_ids   = wp_list_pluck( $lx_terms, 'term_id' );

// Bỏ lọc nếu slug không nằm trong danh sách đã chọn.
if ( $lx_filter && ! in_array( $lx_filter, $lx_term_slugs, true ) ) {
	$lx_filter = '';
}

$lx_show_featured = ( 1 === $lx_paged && '' === $lx_filter );

// --- Bài nổi bật: 3 bài mới nhất (trong các chuyên mục đã chọn, nếu có) ----.
$lx_featured_ids = array();
if ( $lx_show_featured ) {
	$lx_feat_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	);
	if ( ! empty( $lx_term_ids ) ) {
		$lx_feat_args['category__in'] = $lx_term_ids;
	}
	$lx_featured     = new WP_Query( $lx_feat_args );
	$lx_featured_ids = wp_list_pluck( $lx_featured->posts, 'ID' );
}

// --- Lưới bài viết chính ----------------------------------------------------.
$lx_main_args = array(
	'post_type'      => 'post',
	'posts_per_page' => 9,
	'paged'          => $lx_paged,
);
if ( $lx_filter ) {
	$lx_main_args['category_name'] = $lx_filter;
} else {
	if ( ! empty( $lx_term_ids ) ) {
		$lx_main_args['category__in'] = $lx_term_ids;
	}
	if ( ! empty( $lx_featured_ids ) ) {
		$lx_main_args['post__not_in'] = $lx_featured_ids;
	}
}
$lx_main = new WP_Query( $lx_main_args );
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

	<?php if ( $lx_show_featured && ! empty( $lx_featured ) && $lx_featured->have_posts() ) : ?>
	<!-- ============ Tin nổi bật ============ -->
	<section class="py-14 md:py-20" data-section="tin-noi-bat">
		<div class="container-lx">
			<div class="mb-8 flex items-center gap-4" data-reveal>
				<h2 class="text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Tin nổi bật', 'nongnghiepnhietdoi' ); ?></h2>
				<span class="h-px flex-1 bg-neutral-200"></span>
			</div>

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
							<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/45 to-black/25"></div>
						</div>
						<div class="absolute inset-x-0 bottom-0 p-6 text-white md:p-8">
							<?php if ( $lx_cat ) : ?>
								<span class="mb-3 inline-block rounded-full bg-brand px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-white"><?php echo esc_html( $lx_cat->name ); ?></span>
							<?php endif; ?>
							<h3 class="line-clamp-2 text-xl font-bold leading-snug md:text-2xl lg:text-3xl"><?php the_title(); ?></h3>
							<p class="mt-3 line-clamp-2 max-w-2xl text-sm text-white/80 md:text-base"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<div class="mt-4 text-xs uppercase tracking-widest text-white/70"><?php echo esc_html( get_the_date() ); ?></div>
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
		</div>
	</section>
	<?php endif; ?>

	<!-- ============ Tin tức & sự kiện ============ -->
	<section class="bg-neutral-50 py-14 md:py-20" data-section="hoat-dong">
		<div class="container-lx">
			<div class="mb-8 flex flex-col gap-6 md:flex-row md:items-end md:justify-between" data-reveal>
				<div class="flex items-center gap-4 md:flex-1">
					<h2 class="whitespace-nowrap text-2xl font-bold text-neutral-900 md:text-3xl"><?php esc_html_e( 'Tin tức &amp; sự kiện', 'nongnghiepnhietdoi' ); ?></h2>
					<span class="hidden h-px flex-1 bg-neutral-200 md:block"></span>
				</div>
			</div>

			<?php if ( ! empty( $lx_terms ) ) : ?>
				<div class="mb-8 flex flex-wrap gap-2" data-reveal>
					<a href="<?php echo esc_url( $lx_base_url ); ?>" class="lx-filter-pill<?php echo '' === $lx_filter ? ' is-active' : ''; ?>"><?php esc_html_e( 'Tất cả', 'nongnghiepnhietdoi' ); ?></a>
					<?php foreach ( $lx_terms as $lx_term ) : ?>
						<a href="<?php echo esc_url( add_query_arg( 'chuyen_muc', $lx_term->slug, $lx_base_url ) ); ?>" class="lx-filter-pill<?php echo $lx_filter === $lx_term->slug ? ' is-active' : ''; ?>">
							<?php echo esc_html( $lx_term->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $lx_main->have_posts() ) : ?>
				<div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-3" data-reveal-stagger>
					<?php
					while ( $lx_main->have_posts() ) :
						$lx_main->the_post();
						get_template_part( 'template-parts/content', 'news-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<?php if ( $lx_main->max_num_pages > 1 ) : ?>
					<nav class="lx-pagination mt-12" aria-label="<?php esc_attr_e( 'Phân trang', 'nongnghiepnhietdoi' ); ?>">
						<?php
						$lx_paginate_args = array(
							'type'      => 'list',
							'current'   => $lx_paged,
							'total'     => $lx_main->max_num_pages,
							'end_size'  => 1,
							'mid_size'  => 1,
							'prev_text' => '‹',
							'next_text' => '›',
						);
						$lx_page_base = $lx_base_url;
						if ( $lx_filter ) {
							$lx_page_base = add_query_arg( 'chuyen_muc', $lx_filter, $lx_base_url );
						}
						$lx_paginate_args['base']   = add_query_arg( 'trang', '%#%', $lx_page_base );
						$lx_paginate_args['format'] = '';
						echo paginate_links( $lx_paginate_args );
						?>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<p class="text-neutral-500"><?php esc_html_e( 'Chưa có bài viết trong chuyên mục này.', 'nongnghiepnhietdoi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/consult', 'cta' ); ?>

</main>

<?php
get_footer();
