<?php
/**
 * Search results.
 *
 * @package NongNghiepNhietDoi
 */

get_header();

$query       = get_search_query();
$found       = (int) $GLOBALS['wp_query']->found_posts;
$library_url = function_exists( 'nongnghiepnhietdoi_library_url' ) ? nongnghiepnhietdoi_library_url() : home_url( '/thu-vien-tin-tuc/' );
$has_results = have_posts();
?>

<main id="main" class="site-main">

	<section class="lx-utility-hero relative overflow-hidden border-b border-slate-200/80 pt-28 pb-10 md:pt-36 md:pb-14">
		<?php get_template_part( 'template-parts/ui/ambient', 'bg', array( 'variant' => 'default' ) ); ?>
		<div class="relative mx-auto max-w-[1200px] px-4" data-reveal-stagger>
			<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.18em] text-slate-400" aria-label="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-brand"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
				<span aria-hidden="true" class="text-brand">/</span>
				<span class="text-ink"><?php esc_html_e( 'Tìm kiếm', 'nongnghiepnhietdoi' ); ?></span>
			</nav>

			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php esc_html_e( 'Tìm kiếm', 'nongnghiepnhietdoi' ); ?></p>
			<h1 class="mt-2 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl">
				<?php
				if ( '' !== $query ) {
					printf(
						/* translators: %s: search keyword */
						esc_html__( 'Kết quả cho “%s”', 'nongnghiepnhietdoi' ),
						esc_html( $query )
					);
				} else {
					esc_html_e( 'Tìm kiếm', 'nongnghiepnhietdoi' );
				}
				?>
			</h1>
			<p class="mt-2 text-sm text-slate-500">
				<?php
				if ( '' !== $query ) {
					echo esc_html(
						sprintf(
							/* translators: %d: number of results */
							_n( '%d kết quả', '%d kết quả', $found, 'nongnghiepnhietdoi' ),
							$found
						)
					);
				} else {
					esc_html_e( 'Nhập từ khóa để tìm bài viết, dự án và tài liệu.', 'nongnghiepnhietdoi' );
				}
				?>
			</p>

			<form class="mt-6 max-w-xl" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="sr-only" for="lx-search-q"><?php esc_html_e( 'Từ khóa tìm kiếm', 'nongnghiepnhietdoi' ); ?></label>
				<div class="flex h-12 overflow-hidden rounded-full bg-white/80 ring-1 ring-slate-200 backdrop-blur-sm focus-within:bg-white focus-within:ring-2 focus-within:ring-brand">
					<input
						id="lx-search-q"
						class="min-w-0 flex-1 bg-transparent px-5 text-sm text-ink outline-none placeholder:text-slate-400"
						type="search"
						name="s"
						value="<?php echo esc_attr( $query ); ?>"
						placeholder="<?php esc_attr_e( 'Tìm lại với từ khóa khác…', 'nongnghiepnhietdoi' ); ?>"
						autocomplete="off"
					>
					<button type="submit" class="m-1.5 rounded-full bg-brand px-5 text-sm font-semibold text-white transition hover:bg-brand-700">
						<?php esc_html_e( 'Tìm', 'nongnghiepnhietdoi' ); ?>
					</button>
				</div>
			</form>
		</div>
	</section>

	<section class="lx-utility-panel relative overflow-hidden py-10 md:py-14">
		<?php get_template_part( 'template-parts/ui/ambient', 'bg', array( 'variant' => $has_results ? 'default' : 'empty' ) ); ?>
		<div class="relative mx-auto max-w-[1200px] px-4">
			<?php if ( $has_results ) : ?>
				<div class="grid gap-4" data-reveal-stagger>
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'search-card' );
					endwhile;
					?>
				</div>

				<?php
				global $wp_query;
				if ( $wp_query->max_num_pages > 1 ) :
					?>
					<nav class="lx-pagination mt-10" aria-label="<?php esc_attr_e( 'Phân trang', 'nongnghiepnhietdoi' ); ?>">
						<?php
						echo paginate_links(
							array(
								'type'      => 'list',
								'mid_size'  => 1,
								'end_size'  => 1,
								'prev_text' => '‹',
								'next_text' => '›',
							)
						);
						?>
					</nav>
				<?php endif; ?>

			<?php else : ?>
				<div class="mx-auto max-w-lg rounded-2xl bg-white/95 px-6 py-12 text-center shadow-sm ring-1 ring-slate-100 backdrop-blur-sm" data-reveal>
					<div class="lx-empty-icon mx-auto" aria-hidden="true">
						<span class="lx-empty-icon__ring"></span>
						<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
							<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
						</svg>
					</div>
					<h2 class="mt-5 font-sans text-xl font-bold text-ink">
						<?php esc_html_e( 'Không tìm thấy kết quả', 'nongnghiepnhietdoi' ); ?>
					</h2>
					<p class="mt-2 text-sm leading-relaxed text-slate-500">
						<?php
						if ( '' !== $query ) {
							printf(
								/* translators: %s: search keyword */
								esc_html__( 'Không có bài viết nào khớp với “%s”. Thử từ khóa ngắn hơn hoặc duyệt thư viện.', 'nongnghiepnhietdoi' ),
								esc_html( $query )
							);
						} else {
							esc_html_e( 'Hãy nhập từ khóa vào ô tìm kiếm phía trên.', 'nongnghiepnhietdoi' );
						}
						?>
					</p>
					<a href="<?php echo esc_url( $library_url ); ?>" class="mt-6 inline-flex h-11 items-center rounded-full bg-brand px-5 text-sm font-semibold text-white transition hover:bg-brand-700">
						<?php esc_html_e( 'Xem Thư viện & Tin tức', 'nongnghiepnhietdoi' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
get_footer();
