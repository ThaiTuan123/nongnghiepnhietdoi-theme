<?php
/**
 * Template Name: Thư viện & Tin tức
 * Trang Thư viện & Tin tức (slug: thu-vien-tin-tuc).
 *
 * Bài viết hiện ở đây khi được gắn một trong các chuyên mục thư viện.
 *
 * @package NongNghiepNhietDoi
 */

$library_terms = nongnghiepnhietdoi_library_terms();
$term_slugs    = wp_list_pluck( $library_terms, 'slug' );
$term_ids      = array_map( 'intval', wp_list_pluck( $library_terms, 'term_id' ) );
$base_url      = nongnghiepnhietdoi_library_url();

$filter  = isset( $_GET['danh_muc'] ) ? sanitize_title( wp_unslash( $_GET['danh_muc'] ) ) : '';
$keyword = isset( $_GET['tu_khoa'] ) ? sanitize_text_field( wp_unslash( $_GET['tu_khoa'] ) ) : '';
$paged   = isset( $_GET['trang'] ) ? max( 1, (int) $_GET['trang'] ) : 1;

if ( $filter && ! in_array( $filter, $term_slugs, true ) ) {
	$filter = '';
}

$active_term = null;
foreach ( $library_terms as $library_term ) {
	if ( $filter === $library_term->slug ) {
		$active_term = $library_term;
		break;
	}
}

$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 9,
	'paged'               => $paged,
	'ignore_sticky_posts' => true,
);
if ( $active_term ) {
	$query_args['cat'] = (int) $active_term->term_id;
} elseif ( $term_ids ) {
	$query_args['category__in'] = $term_ids;
} else {
	$query_args['post__in'] = array( 0 );
}
if ( '' !== $keyword ) {
	$query_args['s'] = $keyword;
}

$library_query = new WP_Query( $query_args );

$latest_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if ( $term_ids ) {
	$latest_args['category__in'] = $term_ids;
} else {
	$latest_args['post__in'] = array( 0 );
}
$latest_query = new WP_Query( $latest_args );

$page_id    = get_queried_object_id();
$hero_image = get_the_post_thumbnail_url( $page_id, 'full' );
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/hero-field.jpg';
}

$filter_url = $base_url;
if ( $filter ) {
	$filter_url = add_query_arg( 'danh_muc', $filter, $base_url );
}
if ( '' !== $keyword ) {
	$filter_url = add_query_arg( 'tu_khoa', $keyword, $filter_url );
}

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[42vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-section="tv-hero" data-dark-hero>
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="h-full w-full object-cover" fetchpriority="high">
			<div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/70 to-ink/40"></div>
		</div>
		<div class="relative z-10 mx-auto w-full max-w-[1200px] px-4 pb-10 text-white md:pb-14">
			<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.18em] text-white/75" aria-label="breadcrumb" data-reveal>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-white"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
				<span aria-hidden="true" class="text-sun">/</span>
				<span><?php esc_html_e( 'Thư viện & Tin tức', 'nongnghiepnhietdoi' ); ?></span>
			</nav>
			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun" data-reveal><?php esc_html_e( 'Tài liệu & hoạt động', 'nongnghiepnhietdoi' ); ?></p>
			<h1 class="mt-3 max-w-3xl font-sans text-4xl font-bold leading-tight tracking-tight md:text-5xl" data-reveal><?php esc_html_e( 'Thư viện & Tin tức', 'nongnghiepnhietdoi' ); ?></h1>
			<p class="mt-4 max-w-2xl text-base leading-relaxed text-white/85 md:text-lg" data-reveal><?php esc_html_e( 'Công trình nghiên cứu, cẩm nang kỹ thuật và video để nông hộ, nhà khoa học và đối tác dùng chung.', 'nongnghiepnhietdoi' ); ?></p>
		</div>
	</section>

	<section class="bg-bone py-10 md:py-14" data-section="thu-vien">
		<div class="mx-auto max-w-[1200px] px-4">

			<div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
				<div>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php esc_html_e( 'Thư viện', 'nongnghiepnhietdoi' ); ?></p>
					<h2 class="mt-1 font-sans text-2xl font-bold tracking-tight text-ink md:text-3xl">
						<?php
						if ( $active_term ) {
							echo esc_html( $active_term->name );
						} else {
							esc_html_e( 'Tất cả danh mục', 'nongnghiepnhietdoi' );
						}
						?>
					</h2>
					<p class="mt-2 text-sm text-slate-500">
						<?php
						if ( '' !== $keyword ) {
							echo esc_html(
								sprintf(
									/* translators: 1: result count, 2: search keyword */
									__( '%1$d bài viết cho “%2$s”', 'nongnghiepnhietdoi' ),
									(int) $library_query->found_posts,
									$keyword
								)
							);
						} else {
							echo esc_html(
								sprintf(
									/* translators: %d: number of posts */
									_n( '%d bài viết', '%d bài viết', (int) $library_query->found_posts, 'nongnghiepnhietdoi' ),
									(int) $library_query->found_posts
								)
							);
						}
						?>
					</p>
				</div>

				<form class="w-full lg:w-[340px]" method="get" action="<?php echo esc_url( $base_url ); ?>" role="search">
					<label class="sr-only" for="tu-khoa"><?php esc_html_e( 'Tìm kiếm', 'nongnghiepnhietdoi' ); ?></label>
					<div class="flex h-11 overflow-hidden rounded-full bg-white ring-1 ring-slate-200 focus-within:ring-2 focus-within:ring-brand">
						<input id="tu-khoa" class="min-w-0 flex-1 bg-transparent px-4 text-sm text-ink outline-none placeholder:text-slate-400" type="search" name="tu_khoa" value="<?php echo esc_attr( $keyword ); ?>" placeholder="<?php esc_attr_e( 'Tìm kiếm tài liệu, tin tức…', 'nongnghiepnhietdoi' ); ?>">
						<?php if ( $filter ) : ?>
							<input type="hidden" name="danh_muc" value="<?php echo esc_attr( $filter ); ?>">
						<?php endif; ?>
						<button type="submit" class="m-1 rounded-full bg-brand px-4 text-sm font-semibold text-white hover:bg-brand-700"><?php esc_html_e( 'Tìm', 'nongnghiepnhietdoi' ); ?></button>
					</div>
				</form>
			</div>

			<nav class="mt-6 flex gap-2 overflow-x-auto pb-1" aria-label="<?php esc_attr_e( 'Danh mục thư viện', 'nongnghiepnhietdoi' ); ?>">
				<?php
				$all_href = $base_url;
				if ( '' !== $keyword ) {
					$all_href = add_query_arg( 'tu_khoa', $keyword, $base_url );
				}
				$pill = 'inline-flex h-10 shrink-0 items-center whitespace-nowrap rounded-full px-4 text-sm font-semibold transition-colors';
				?>
				<a href="<?php echo esc_url( $all_href ); ?>" class="<?php echo esc_attr( $pill ); ?> <?php echo '' === $filter ? 'bg-brand text-white' : 'bg-white text-ink ring-1 ring-slate-200 hover:text-brand'; ?>">
					<?php esc_html_e( 'Tất cả danh mục', 'nongnghiepnhietdoi' ); ?>
				</a>
				<?php foreach ( $library_terms as $library_term ) : ?>
					<?php
					$term_href = nongnghiepnhietdoi_library_url( $library_term->slug );
					if ( '' !== $keyword ) {
						$term_href = add_query_arg( 'tu_khoa', $keyword, $term_href );
					}
					$is_active = $filter === $library_term->slug;
					?>
					<a href="<?php echo esc_url( $term_href ); ?>" class="<?php echo esc_attr( $pill ); ?> <?php echo $is_active ? 'bg-brand text-white' : 'bg-white text-ink ring-1 ring-slate-200 hover:text-brand'; ?>">
						<?php echo esc_html( $library_term->name ); ?>
					</a>
				<?php endforeach; ?>
			</nav>

			<div class="mt-8 grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">
			<div>
				<?php if ( $library_query->have_posts() ) : ?>
					<div class="grid gap-4">
						<?php
						while ( $library_query->have_posts() ) :
							$library_query->the_post();
							get_template_part(
								'template-parts/content',
								'library-card',
								array( 'terms' => $library_terms )
							);
						endwhile;
						wp_reset_postdata();
						?>
					</div>

					<?php if ( $library_query->max_num_pages > 1 ) : ?>
						<nav class="lx-pagination mt-10" aria-label="<?php esc_attr_e( 'Phân trang', 'nongnghiepnhietdoi' ); ?>">
							<?php
							echo paginate_links(
								array(
									'type'      => 'list',
									'current'   => $paged,
									'total'     => $library_query->max_num_pages,
									'end_size'  => 1,
									'mid_size'  => 1,
									'prev_text' => '‹',
									'next_text' => '›',
									'base'      => add_query_arg( 'trang', '%#%', $filter_url ),
									'format'    => '',
								)
							);
							?>
						</nav>
					<?php endif; ?>
				<?php else : ?>
					<div class="rounded-2xl bg-white px-6 py-12 text-center ring-1 ring-slate-100">
						<p class="font-sans text-lg font-bold text-ink"><?php esc_html_e( 'Chưa có bài viết', 'nongnghiepnhietdoi' ); ?></p>
						<p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600">
							<?php esc_html_e( 'Tạo bài viết và gắn một trong các chuyên mục thư viện. Bài sẽ xuất hiện tại đây.', 'nongnghiepnhietdoi' ); ?>
						</p>
					</div>
				<?php endif; ?>
			</div>

			<aside class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100 lg:sticky lg:top-28" data-reveal>
				<h2 class="font-sans text-base font-bold text-ink"><?php esc_html_e( 'Tin mới nhất', 'nongnghiepnhietdoi' ); ?></h2>
				<?php if ( $latest_query->have_posts() ) : ?>
					<ul class="mt-4 divide-y divide-slate-100">
						<?php
						while ( $latest_query->have_posts() ) :
							$latest_query->the_post();
							$latest_cats = get_the_category();
							$latest_cat  = ! empty( $latest_cats ) ? $latest_cats[0]->name : '';
							?>
							<li class="py-3 first:pt-0 last:pb-0">
								<a class="block" href="<?php the_permalink(); ?>">
									<p class="text-sm font-semibold leading-snug text-ink hover:text-brand"><?php the_title(); ?></p>
									<p class="mt-1 text-xs leading-relaxed text-slate-400">
										<?php echo esc_html( get_the_date() ); ?>
										<?php if ( $latest_cat ) : ?>
											<span class="mt-0.5 block text-slate-500"><?php echo esc_html( $latest_cat ); ?></span>
										<?php endif; ?>
									</p>
								</a>
							</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				<?php else : ?>
					<p class="mt-4 text-sm text-slate-500"><?php esc_html_e( 'Chưa có tin mới.', 'nongnghiepnhietdoi' ); ?></p>
				<?php endif; ?>
			</aside>
			</div>

		</div>
	</section>

</main>

<?php
get_footer();
