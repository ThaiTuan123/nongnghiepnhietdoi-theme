<?php
/**
 * Template Name: Dự Án & Tác Động
 * Trang Dự Án & Tác Động (slug: du-an-tac-dong).
 *
 * Nội dung sửa trong hộp Meta "Dự Án & Tác Động - Nội dung trang".
 * Ba mục khớp menu: Tài trợ NGO/ODA · Tư vấn & đánh giá · Đề tài nhà nước.
 * Khối dự án tiêu biểu lấy bài thuộc chuyên mục "Dự án tiêu biểu".
 *
 * @package NongNghiepNhietDoi
 */

$page_id = get_queried_object_id();

$hero_eyebrow = (string) nongnghiepnhietdoi_projects_field( 'dt_hero_eyebrow', $page_id );
$hero_title   = (string) nongnghiepnhietdoi_projects_field( 'dt_hero_title', $page_id );
$hero_lead    = (string) nongnghiepnhietdoi_projects_field( 'dt_hero_lead', $page_id );
$hero_image   = get_the_post_thumbnail_url( $page_id, 'full' );
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/about-field.jpg';
}

$section_ids = array(
	1 => 'tai-tro',
	2 => 'tu-van-danh-gia',
	3 => 'de-tai-dat-hang',
);

$sections = array();
foreach ( $section_ids as $index => $anchor ) {
	$points     = nongnghiepnhietdoi_projects_field( 'dt_s' . $index . '_points', $page_id );
	$sections[] = array(
		'id'         => $anchor,
		'index'      => $index,
		'nav'        => (string) nongnghiepnhietdoi_projects_field( 'dt_s' . $index . '_nav', $page_id ),
		'title'      => (string) nongnghiepnhietdoi_projects_field( 'dt_s' . $index . '_title', $page_id ),
		'intro'      => (string) nongnghiepnhietdoi_projects_field( 'dt_s' . $index . '_intro', $page_id ),
		'points'     => is_array( $points ) ? $points : array(),
		'more_label' => (string) nongnghiepnhietdoi_projects_field( 'dt_s' . $index . '_more_label', $page_id ),
		'more_url'   => (string) nongnghiepnhietdoi_projects_field( 'dt_s' . $index . '_more_url', $page_id ),
	);
}

$featured_label = (string) nongnghiepnhietdoi_projects_field( 'dt_featured_label', $page_id );
$featured_title = (string) nongnghiepnhietdoi_projects_field( 'dt_featured_title', $page_id );
$featured_intro = (string) nongnghiepnhietdoi_projects_field( 'dt_featured_intro', $page_id );

$cta_title = (string) nongnghiepnhietdoi_projects_field( 'dt_cta_title', $page_id );
$cta_text  = (string) nongnghiepnhietdoi_projects_field( 'dt_cta_text', $page_id );
$cta_label = (string) nongnghiepnhietdoi_projects_field( 'dt_cta_button_label', $page_id );
$cta_url   = (string) nongnghiepnhietdoi_projects_field( 'dt_cta_button_url', $page_id );

$featured_term = function_exists( 'nongnghiepnhietdoi_featured_project_term' ) ? nongnghiepnhietdoi_featured_project_term() : null;
$featured_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 6,
	'orderby'             => 'date',
	'order'               => 'DESC',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if ( $featured_term instanceof WP_Term ) {
	$featured_args['cat'] = (int) $featured_term->term_id;
} else {
	// Không có chuyên mục → không hiện bài nào (tránh lộ toàn bộ post).
	$featured_args['post__in'] = array( 0 );
}
$featured_q = new WP_Query( $featured_args );

$fallback_img = NONGNGHIEPNHIETDOI_URI . '/assets/images';

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[56vh]" data-section="dt-hero" data-dark-hero>
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="h-full w-full object-cover" fetchpriority="high">
			<div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/70 to-ink/35"></div>
		</div>
		<div class="relative z-10 mx-auto w-full max-w-[1200px] px-4 pb-10 text-white md:pb-14">
			<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs uppercase tracking-[0.18em] text-white/75" aria-label="breadcrumb" data-reveal>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-white"><?php esc_html_e( 'Trang chủ', 'nongnghiepnhietdoi' ); ?></a>
				<span aria-hidden="true" class="text-sun">/</span>
				<span><?php echo esc_html( $hero_title ); ?></span>
			</nav>
			<?php if ( $hero_eyebrow ) : ?>
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun" data-reveal><?php echo esc_html( $hero_eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( $hero_title ) : ?>
				<h1 class="mt-3 max-w-3xl font-sans text-4xl font-bold leading-tight tracking-tight md:text-5xl" data-reveal><?php echo esc_html( $hero_title ); ?></h1>
			<?php endif; ?>
			<?php if ( $hero_lead ) : ?>
				<p class="mt-4 max-w-2xl text-base leading-relaxed text-white/85 md:text-lg" data-reveal><?php echo wp_kses_post( $hero_lead ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<nav class="sticky top-[76px] z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur sm:top-[88px]" aria-label="<?php esc_attr_e( 'Mục lục trang', 'nongnghiepnhietdoi' ); ?>">
		<div class="mx-auto flex max-w-[1200px] gap-2 overflow-x-auto px-4 py-3">
			<?php foreach ( $sections as $section ) : ?>
				<?php if ( ! $section['nav'] ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<a class="shrink-0 rounded-full bg-bone px-4 py-2 text-sm font-semibold text-ink transition-colors hover:bg-brand hover:text-white" href="#<?php echo esc_attr( $section['id'] ); ?>">
					<?php echo esc_html( $section['nav'] ); ?>
				</a>
			<?php endforeach; ?>
			<?php if ( $featured_title ) : ?>
				<a class="shrink-0 rounded-full bg-bone px-4 py-2 text-sm font-semibold text-ink transition-colors hover:bg-brand hover:text-white" href="#du-an-tieu-bieu">
					<?php echo esc_html( $featured_title ); ?>
				</a>
			<?php endif; ?>
		</div>
	</nav>

	<?php foreach ( $sections as $section ) : ?>
		<?php
		$is_muted   = ( 0 === $section['index'] % 2 );
		$reversed   = $is_muted;
		$section_bg = $is_muted ? 'bg-bone' : 'bg-white';
		$copy_order = $reversed ? 'order-1 lg:order-2' : 'order-1';
		$card_order = $reversed ? 'order-2 lg:order-1' : 'order-2';
		?>
		<section id="<?php echo esc_attr( $section['id'] ); ?>" class="scroll-mt-28 py-14 md:py-20 <?php echo esc_attr( $section_bg ); ?>" data-section="dt-<?php echo esc_attr( $section['id'] ); ?>">
			<div class="mx-auto grid max-w-[1200px] items-center gap-8 px-4 lg:grid-cols-12 lg:gap-12">
				<div class="lg:col-span-5 <?php echo esc_attr( $copy_order ); ?>" data-reveal="<?php echo $reversed ? 'right' : 'left'; ?>">
					<p class="text-sm font-bold tracking-[0.14em] text-sun"><?php echo esc_html( str_pad( (string) $section['index'], 2, '0', STR_PAD_LEFT ) ); ?></p>
					<?php if ( $section['title'] ) : ?>
						<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $section['title'] ); ?></h2>
					<?php endif; ?>
					<?php if ( $section['intro'] ) : ?>
						<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $section['intro'] ); ?></p>
					<?php endif; ?>
					<?php if ( $section['more_label'] ) : ?>
						<?php if ( $section['more_url'] ) : ?>
							<a class="mt-6 inline-flex items-center gap-3 rounded-full bg-brand py-2 pl-5 pr-2 text-sm font-semibold text-white hover:bg-brand-700" href="<?php echo esc_url( $section['more_url'] ); ?>">
								<?php echo esc_html( $section['more_label'] ); ?>
								<span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
									<svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
								</span>
							</a>
						<?php else : ?>
							<span class="mt-6 inline-flex items-center gap-3 rounded-full bg-brand py-2 pl-5 pr-2 text-sm font-semibold text-white">
								<?php echo esc_html( $section['more_label'] ); ?>
								<span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
									<svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
								</span>
							</span>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<?php if ( $section['points'] ) : ?>
					<div class="grid gap-4 sm:grid-cols-2 lg:col-span-7 <?php echo esc_attr( $card_order ); ?>" data-reveal-stagger>
						<?php
						$point_count = count( $section['points'] );
						foreach ( $section['points'] as $point_index => $point ) :
							$point_title = isset( $point['title'] ) ? (string) $point['title'] : '';
							$point_text  = isset( $point['text'] ) ? (string) $point['text'] : '';
							$point_bg    = nongnghiepnhietdoi_projects_card_image( $point['image'] ?? null, (int) $section['index'], (int) $point_index );
							if ( '' === $point_title && '' === $point_text ) {
								continue;
							}
							$span = ( 1 === $point_count % 2 && (int) $point_index === $point_count - 1 ) ? ' sm:col-span-2' : '';
							?>
							<article class="vc-media-card vc-media-card--service group<?php echo esc_attr( $span ); ?>">
								<?php if ( $point_bg ) : ?>
									<img class="vc-media-card__bg" src="<?php echo esc_url( $point_bg ); ?>" alt="" loading="lazy" decoding="async">
								<?php endif; ?>
								<span class="vc-media-card__scrim" aria-hidden="true"></span>
								<div class="vc-media-card__body">
									<p class="vc-media-card__index"><?php echo esc_html( str_pad( (string) ( $point_index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
									<?php if ( $point_title ) : ?>
										<h3 class="vc-media-card__title"><?php echo esc_html( $point_title ); ?></h3>
									<?php endif; ?>
									<?php if ( $point_text ) : ?>
										<p class="vc-media-card__text"><?php echo esc_html( $point_text ); ?></p>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endforeach; ?>

	<section id="du-an-tieu-bieu" class="scroll-mt-28 bg-white py-14 md:py-20" data-section="dt-featured">
		<div class="mx-auto max-w-[1200px] px-4">
			<?php if ( $featured_label ) : ?>
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $featured_label ); ?></p>
			<?php endif; ?>
			<?php if ( $featured_title ) : ?>
				<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl" data-reveal><?php echo esc_html( $featured_title ); ?></h2>
			<?php endif; ?>
			<?php if ( $featured_intro ) : ?>
				<p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600" data-reveal><?php echo esc_html( $featured_intro ); ?></p>
			<?php endif; ?>

			<div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3" data-reveal-stagger>
				<?php if ( $featured_q->have_posts() ) : ?>
					<?php
					$i = 0;
					while ( $featured_q->have_posts() ) :
						$featured_q->the_post();
						$image = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
						if ( ! $image ) {
							$image = $fallback_img . ( 1 === $i % 3 ? '/about-field.jpg' : '/hero-field.jpg' );
						}
						$excerpt = wp_strip_all_tags( get_the_excerpt() );
						?>
						<a href="<?php the_permalink(); ?>" class="vc-media-card vc-media-card--featured vc-media-card--link group">
							<img class="vc-media-card__bg" src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy" decoding="async">
							<span class="vc-media-card__scrim" aria-hidden="true"></span>
							<div class="vc-media-card__body">
								<p class="vc-media-card__index"><?php echo esc_html( get_the_date() ); ?></p>
								<h3 class="vc-media-card__title"><?php the_title(); ?></h3>
								<?php if ( $excerpt ) : ?>
									<p class="vc-media-card__text"><?php echo esc_html( wp_trim_words( $excerpt, 18, '…' ) ); ?></p>
								<?php endif; ?>
							</div>
						</a>
						<?php
						++$i;
					endwhile;
					wp_reset_postdata();
					?>
				<?php else : ?>
					<p class="text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
						<?php esc_html_e( 'Chưa có dự án tiêu biểu. Gắn chuyên mục «Dự án tiêu biểu» cho bài viết cần hiện ở đây.', 'nongnghiepnhietdoi' ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( $cta_title || $cta_text ) : ?>
		<section class="bg-gradient-to-r from-brand-900 to-brand text-white" data-section="dt-cta">
			<div class="mx-auto flex max-w-[1200px] flex-col items-start justify-between gap-6 px-4 py-10 md:flex-row md:items-center md:py-12" data-reveal>
				<div>
					<?php if ( $cta_title ) : ?>
						<h2 class="font-sans text-2xl font-bold md:text-3xl"><?php echo esc_html( $cta_title ); ?></h2>
					<?php endif; ?>
					<?php if ( $cta_text ) : ?>
						<p class="mt-2 max-w-2xl text-sm leading-relaxed text-white/80 md:text-base"><?php echo wp_kses_post( $cta_text ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $cta_url && $cta_label ) : ?>
					<a href="<?php echo esc_url( $cta_url ); ?>" class="lx-band-cta">
						<?php echo esc_html( $cta_label ); ?>
						<span class="lx-band-cta__arrow" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
