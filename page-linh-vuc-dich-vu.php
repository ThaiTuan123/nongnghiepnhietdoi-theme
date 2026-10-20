<?php
/**
 * Template Name: Lĩnh vực & Dịch vụ
 * Trang Lĩnh vực & Dịch vụ (slug: linh-vuc-dich-vu).
 *
 * Nội dung sửa trong hộp Meta "Lĩnh vực & Dịch vụ - Nội dung trang".
 * Mỗi mục có ô "Đường dẫn bài chi tiết": dán link sau này thì nút Xem thêm mở bài đó.
 *
 * @package NongNghiepNhietDoi
 */

$page_id = get_queried_object_id();

$hero_eyebrow = (string) nongnghiepnhietdoi_services_field( 'lv_hero_eyebrow', $page_id );
$hero_title   = (string) nongnghiepnhietdoi_services_field( 'lv_hero_title', $page_id );
$hero_lead    = (string) nongnghiepnhietdoi_services_field( 'lv_hero_lead', $page_id );
$hero_image   = get_the_post_thumbnail_url( $page_id, 'full' );
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/about-field.jpg';
}

$service_ids = array(
	1 => 'nghien-cuu',
	2 => 'tu-van',
	3 => 'de-tai',
);

$services = array();
foreach ( $service_ids as $index => $anchor ) {
	$points = nongnghiepnhietdoi_services_field( 'lv_s' . $index . '_points', $page_id );
	$services[] = array(
		'id'         => $anchor,
		'index'      => $index,
		'nav'        => (string) nongnghiepnhietdoi_services_field( 'lv_s' . $index . '_nav', $page_id ),
		'title'      => (string) nongnghiepnhietdoi_services_field( 'lv_s' . $index . '_title', $page_id ),
		'intro'      => (string) nongnghiepnhietdoi_services_field( 'lv_s' . $index . '_intro', $page_id ),
		'points'     => is_array( $points ) ? $points : array(),
		'more_label' => (string) nongnghiepnhietdoi_services_field( 'lv_s' . $index . '_more_label', $page_id ),
		'more_url'   => (string) nongnghiepnhietdoi_services_field( 'lv_s' . $index . '_more_url', $page_id ),
	);
}

$cta_title = (string) nongnghiepnhietdoi_services_field( 'lv_cta_title', $page_id );
$cta_text  = (string) nongnghiepnhietdoi_services_field( 'lv_cta_text', $page_id );
$cta_label = (string) nongnghiepnhietdoi_services_field( 'lv_cta_button_label', $page_id );
$cta_url   = (string) nongnghiepnhietdoi_services_field( 'lv_cta_button_url', $page_id );

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[56vh]" data-section="lv-hero" data-dark-hero>
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

	<?php foreach ( $services as $service ) : ?>
		<?php
		$is_muted   = ( 0 === $service['index'] % 2 );
		$reversed   = $is_muted;
		$section_bg = $is_muted ? 'bg-bone' : 'bg-white';
		$card_bg    = $is_muted ? 'bg-white shadow-sm ring-1 ring-slate-100' : 'bg-bone';
		$copy_order = $reversed ? 'order-1 lg:order-2' : 'order-1';
		$card_order = $reversed ? 'order-2 lg:order-1' : 'order-2';
		?>
		<section id="<?php echo esc_attr( $service['id'] ); ?>" class="scroll-mt-28 py-14 md:py-20 <?php echo esc_attr( $section_bg ); ?>" data-section="lv-<?php echo esc_attr( $service['id'] ); ?>">
			<div class="mx-auto grid max-w-[1200px] items-center gap-8 px-4 lg:grid-cols-12 lg:gap-12">
				<div class="lg:col-span-5 <?php echo esc_attr( $copy_order ); ?>" data-reveal="<?php echo $reversed ? 'right' : 'left'; ?>">
					<p class="text-sm font-bold tracking-[0.14em] text-sun"><?php echo esc_html( str_pad( (string) $service['index'], 2, '0', STR_PAD_LEFT ) ); ?></p>
					<?php if ( $service['title'] ) : ?>
						<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $service['title'] ); ?></h2>
					<?php endif; ?>
					<?php if ( $service['intro'] ) : ?>
						<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $service['intro'] ); ?></p>
					<?php endif; ?>
					<?php if ( $service['more_label'] ) : ?>
						<?php if ( $service['more_url'] ) : ?>
							<a class="mt-6 inline-flex items-center gap-3 rounded-full bg-brand py-2 pl-5 pr-2 text-sm font-semibold text-white hover:bg-brand-700" href="<?php echo esc_url( $service['more_url'] ); ?>">
								<?php echo esc_html( $service['more_label'] ); ?>
								<span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
									<svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
								</span>
							</a>
						<?php else : ?>
							<span class="mt-6 inline-flex items-center gap-3 rounded-full bg-brand py-2 pl-5 pr-2 text-sm font-semibold text-white">
								<?php echo esc_html( $service['more_label'] ); ?>
								<span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-sun text-white" aria-hidden="true">
									<svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none"><path d="M4 12 12 4M6 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
								</span>
							</span>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<?php if ( $service['points'] ) : ?>
					<div class="grid gap-4 sm:grid-cols-2 lg:col-span-7 <?php echo esc_attr( $card_order ); ?>" data-reveal-stagger>
						<?php
						$point_count = count( $service['points'] );
						foreach ( $service['points'] as $point_index => $point ) :
							$point_title = isset( $point['title'] ) ? (string) $point['title'] : '';
							$point_text  = isset( $point['text'] ) ? (string) $point['text'] : '';
							if ( '' === $point_title && '' === $point_text ) {
								continue;
							}
							$span = ( 1 === $point_count % 2 && (int) $point_index === $point_count - 1 ) ? ' sm:col-span-2' : '';
							?>
							<article class="rounded-3xl p-6 <?php echo esc_attr( $card_bg . $span ); ?>">
								<?php if ( $point_title ) : ?>
									<h3 class="font-sans text-lg font-bold text-ink"><?php echo esc_html( $point_title ); ?></h3>
								<?php endif; ?>
								<?php if ( $point_text ) : ?>
									<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $point_text ); ?></p>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endforeach; ?>

	<?php if ( $cta_title || $cta_text ) : ?>
		<section class="bg-gradient-to-r from-brand-900 to-brand text-white" data-section="lv-cta">
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
					<a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-ink hover:bg-bone">
						<?php echo esc_html( $cta_label ); ?>
						<span aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
