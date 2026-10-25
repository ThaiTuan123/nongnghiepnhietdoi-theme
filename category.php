<?php
/**
 * Archive chuyên mục.
 *
 * Thay layout "Category:" mặc định. Chuyên mục Dự án tiêu biểu dùng hero
 * và thẻ ảnh phủ, cùng hệ với trang Dự án & Tác động.
 *
 * @package NongNghiepNhietDoi
 */

get_header();

$term = get_queried_object();
if ( ! $term instanceof WP_Term ) {
	$term = null;
}

$term_id   = $term ? (int) $term->term_id : 0;
$term_name = $term ? $term->name : single_cat_title( '', false );
$paged     = max( 1, (int) get_query_var( 'paged' ) );
$found     = (int) $GLOBALS['wp_query']->found_posts;

$featured_term = function_exists( 'nongnghiepnhietdoi_featured_project_term' ) ? nongnghiepnhietdoi_featured_project_term() : null;
$is_featured   = $featured_term instanceof WP_Term && $term_id === (int) $featured_term->term_id;

$projects_url = home_url( '/du-an-tac-dong/' );
$partner_url  = home_url( '/hop-tac-du-an/' );
$contact_url  = home_url( '/lien-he/' );

$description = $term ? trim( wp_strip_all_tags( term_description( $term ) ) ) : '';
if ( '' === $description && $is_featured ) {
	$description = __( 'Các mô hình đã triển khai trên đồng: canh tác giảm phát thải, đánh giá tác động môi trường – xã hội và ứng dụng chế phẩm vi sinh cùng nông hộ, hợp tác xã.', 'nongnghiepnhietdoi' );
} elseif ( '' === $description ) {
	$description = __( 'Bài viết, mô hình và tài liệu thuộc chuyên mục này.', 'nongnghiepnhietdoi' );
}

$hero_image = '';
if ( $term_id ) {
	$hero_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 4,
			'cat'                 => $term_id,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	foreach ( $hero_query->posts as $hero_post ) {
		$candidate = get_the_post_thumbnail_url( $hero_post->ID, 'full' );
		if ( $candidate ) {
			$hero_image = $candidate;
			break;
		}
	}
	wp_reset_postdata();
}
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . ( $is_featured ? '/assets/images/about-field.jpg' : '/assets/images/hero-field.jpg' );
}

$crumbs = array(
	array(
		'label' => __( 'Trang chủ', 'nongnghiepnhietdoi' ),
		'url'   => home_url( '/' ),
	),
);
if ( $is_featured ) {
	$crumbs[] = array(
		'label' => __( 'Dự án & Tác động', 'nongnghiepnhietdoi' ),
		'url'   => $projects_url,
	);
} elseif ( $term && $term->parent ) {
	$parent = get_term( (int) $term->parent, 'category' );
	if ( $parent && ! is_wp_error( $parent ) ) {
		$crumbs[] = array(
			'label' => $parent->name,
			'url'   => get_category_link( $parent ),
		);
	}
}
$crumbs[] = array(
	'label' => $term_name,
	'url'   => '',
);

$eyebrow = __( 'Chuyên mục', 'nongnghiepnhietdoi' );
if ( $is_featured ) {
	$eyebrow = __( 'Dự án & Tác động', 'nongnghiepnhietdoi' );
} elseif ( $term && $term->parent ) {
	$parent_term = get_term( (int) $term->parent, 'category' );
	if ( $parent_term && ! is_wp_error( $parent_term ) ) {
		$eyebrow = $parent_term->name;
	}
}

$library_slugs = function_exists( 'nongnghiepnhietdoi_library_categories' )
	? wp_list_pluck( nongnghiepnhietdoi_library_categories(), 'slug' )
	: array();

$nav_terms = array();
if ( $term ) {
	$raw_terms = get_categories(
		array(
			'parent'     => (int) $term->parent,
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_category' ) ),
		)
	);
	foreach ( $raw_terms as $nav_term ) {
		if ( in_array( $nav_term->slug, $library_slugs, true ) ) {
			continue;
		}
		$nav_terms[] = $nav_term;
	}
}

$cta_title = $is_featured
	? __( 'Triển khai mô hình cùng trung tâm', 'nongnghiepnhietdoi' )
	: __( 'Cần trao đổi thêm về nội dung này?', 'nongnghiepnhietdoi' );
$cta_text  = $is_featured
	? __( 'Từ thiết kế kỹ thuật đến đo lường tác động trên đồng — VARC đồng hành với hợp tác xã, doanh nghiệp và đối tác tài trợ.', 'nongnghiepnhietdoi' )
	: __( 'Đội ngũ VARC sẵn sàng làm rõ nội dung chuyên môn và hướng hợp tác phù hợp.', 'nongnghiepnhietdoi' );
$cta_label = $is_featured
	? __( 'Hợp tác & dự án', 'nongnghiepnhietdoi' )
	: __( 'Liên hệ', 'nongnghiepnhietdoi' );
$cta_url   = $is_featured ? $partner_url : $contact_url;
?>

<main id="main" class="site-main cat-archive">

	<section class="relative flex min-h-[42vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-section="category-hero" data-dark-hero>
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="h-full w-full object-cover" fetchpriority="high">
			<div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/70 to-ink/40"></div>
		</div>
		<div class="relative z-10 mx-auto w-full max-w-[1200px] px-4 pb-10 text-white md:pb-14">
			<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.18em] text-white/75" aria-label="<?php esc_attr_e( 'Đường dẫn', 'nongnghiepnhietdoi' ); ?>" data-reveal>
				<?php foreach ( $crumbs as $crumb_index => $crumb ) : ?>
					<?php if ( $crumb_index > 0 ) : ?>
						<span aria-hidden="true" class="text-sun">/</span>
					<?php endif; ?>
					<?php if ( $crumb['url'] ) : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="transition-colors hover:text-white"><?php echo esc_html( $crumb['label'] ); ?></a>
					<?php else : ?>
						<span><?php echo esc_html( $crumb['label'] ); ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun" data-reveal><?php echo esc_html( $eyebrow ); ?></p>
			<h1 class="mt-3 max-w-3xl font-sans text-4xl font-bold leading-tight tracking-tight md:text-5xl" data-reveal><?php echo esc_html( $term_name ); ?></h1>
			<p class="mt-4 max-w-2xl text-base leading-relaxed text-white/85 md:text-lg" data-reveal><?php echo esc_html( $description ); ?></p>
			<p class="mt-5 text-sm font-semibold text-white/80" data-reveal>
				<?php
				echo esc_html(
					sprintf(
						/* translators: %d: number of posts */
						_n( '%d bài viết', '%d bài viết', $found, 'nongnghiepnhietdoi' ),
						$found
					)
				);
				?>
			</p>
		</div>
	</section>

	<section class="bg-bone py-10 md:py-14" data-section="category-list">
		<div class="mx-auto max-w-[1200px] px-4">
			<?php if ( count( $nav_terms ) > 1 ) : ?>
				<nav class="mb-8 flex gap-2 overflow-x-auto pb-1" aria-label="<?php esc_attr_e( 'Chuyên mục', 'nongnghiepnhietdoi' ); ?>" data-reveal>
					<?php
					$pill = 'inline-flex h-10 shrink-0 items-center whitespace-nowrap rounded-full px-4 text-sm font-semibold transition-colors';
					foreach ( $nav_terms as $nav_term ) :
						$is_active = $term_id === (int) $nav_term->term_id;
						?>
						<a href="<?php echo esc_url( get_category_link( $nav_term ) ); ?>" class="<?php echo esc_attr( $pill ); ?> <?php echo $is_active ? 'bg-brand text-white' : 'bg-white text-ink ring-1 ring-slate-200 hover:text-brand'; ?>" <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
							<?php echo esc_html( $nav_term->name ); ?>
						</a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<div class="grid gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3" data-reveal-stagger>
					<?php
					$card_index = 0;
					while ( have_posts() ) :
						the_post();
						get_template_part(
							'template-parts/content',
							'category-card',
							array(
								'lead'  => ( 1 === $paged && 0 === $card_index && $found > 3 ),
								'index' => $card_index,
							)
						);
						++$card_index;
					endwhile;
					?>
				</div>

				<?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
					<nav class="lx-pagination mt-10" aria-label="<?php esc_attr_e( 'Phân trang', 'nongnghiepnhietdoi' ); ?>">
						<?php
						echo paginate_links(
							array(
								'type'      => 'list',
								'current'   => $paged,
								'total'     => (int) $GLOBALS['wp_query']->max_num_pages,
								'end_size'  => 1,
								'mid_size'  => 1,
								'prev_text' => '‹',
								'next_text' => '›',
							)
						);
						?>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<div class="rounded-2xl bg-white px-6 py-12 text-center ring-1 ring-slate-100" data-reveal>
					<p class="font-sans text-lg font-bold text-ink"><?php esc_html_e( 'Chưa có bài viết', 'nongnghiepnhietdoi' ); ?></p>
					<p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600">
						<?php esc_html_e( 'Gắn chuyên mục này cho bài viết trong WP Admin để bài hiện tại đây.', 'nongnghiepnhietdoi' ); ?>
					</p>
					<?php if ( $is_featured ) : ?>
						<a href="<?php echo esc_url( $projects_url ); ?>" class="mt-6 inline-flex h-11 items-center rounded-full bg-brand px-5 text-sm font-semibold text-white transition hover:bg-brand-700">
							<?php esc_html_e( 'Về Dự án & Tác động', 'nongnghiepnhietdoi' ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="bg-gradient-to-r from-brand-900 to-brand text-white" data-section="category-cta">
		<div class="mx-auto flex max-w-[1200px] flex-col items-start justify-between gap-6 px-4 py-10 md:flex-row md:items-center md:py-12" data-reveal>
			<div>
				<h2 class="font-sans text-2xl font-bold md:text-3xl"><?php echo esc_html( $cta_title ); ?></h2>
				<p class="mt-2 max-w-2xl text-sm leading-relaxed text-white/80 md:text-base"><?php echo esc_html( $cta_text ); ?></p>
			</div>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="lx-band-cta">
				<?php echo esc_html( $cta_label ); ?>
				<span class="lx-band-cta__arrow" aria-hidden="true">→</span>
			</a>
		</div>
	</section>

</main>

<?php
get_footer();
