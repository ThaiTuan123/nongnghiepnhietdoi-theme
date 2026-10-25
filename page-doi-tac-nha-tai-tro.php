<?php
/**
 * Template Name: Đối tác & Nhà tài trợ
 * Trang Đối tác & Nhà tài trợ (slug: doi-tac-nha-tai-tro).
 *
 * Sửa tên, logo và đường dẫn trong hộp Meta khi sửa trang này.
 *
 * @package NongNghiepNhietDoi
 */

$page_id = get_queried_object_id();

$hero_eyebrow = (string) nongnghiepnhietdoi_partners_field( 'pt_hero_eyebrow', $page_id );
$hero_title   = (string) nongnghiepnhietdoi_partners_field( 'pt_hero_title', $page_id );
$hero_lead    = (string) nongnghiepnhietdoi_partners_field( 'pt_hero_lead', $page_id );
$hero_image   = get_the_post_thumbnail_url( $page_id, 'full' );
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/hero-field.jpg';
}

$groups = array(
	array(
		'id'    => 'quy-quoc-te',
		'label' => (string) nongnghiepnhietdoi_partners_field( 'pt_funds_label', $page_id ),
		'intro' => (string) nongnghiepnhietdoi_partners_field( 'pt_funds_intro', $page_id ),
		'items' => nongnghiepnhietdoi_partners_field( 'pt_funds', $page_id ),
		'style' => 'tiles',
		'tone'  => 'bg-white',
	),
	array(
		'id'    => 'co-quan-nha-nuoc',
		'label' => (string) nongnghiepnhietdoi_partners_field( 'pt_gov_label', $page_id ),
		'intro' => (string) nongnghiepnhietdoi_partners_field( 'pt_gov_intro', $page_id ),
		'items' => nongnghiepnhietdoi_partners_field( 'pt_gov', $page_id ),
		'style' => 'rows',
		'tone'  => 'bg-bone',
	),
	array(
		'id'    => 'doanh-nghiep',
		'label' => (string) nongnghiepnhietdoi_partners_field( 'pt_biz_label', $page_id ),
		'intro' => (string) nongnghiepnhietdoi_partners_field( 'pt_biz_intro', $page_id ),
		'items' => nongnghiepnhietdoi_partners_field( 'pt_biz', $page_id ),
		'style' => 'wide',
		'tone'  => 'bg-white',
	),
);

/**
 * Chuẩn hóa một đối tác.
 *
 * @param mixed $row Dòng repeater.
 * @return array{name:string,note:string,url:string,src:string,alt:string}|null
 */
$pt_partner = static function ( $row ) {
	if ( ! is_array( $row ) ) {
		return null;
	}
	$name = isset( $row['name'] ) ? trim( (string) $row['name'] ) : '';
	$note = isset( $row['note'] ) ? trim( (string) $row['note'] ) : '';
	$url  = isset( $row['url'] ) ? trim( (string) $row['url'] ) : '';
	if ( '' === $name && '' === $note ) {
		return null;
	}
	$logo = $row['logo'] ?? null;
	return array(
		'name' => $name,
		'note' => $note,
		'url'  => $url,
		'src'  => nongnghiepnhietdoi_about_image_url( $logo ),
		'alt'  => nongnghiepnhietdoi_about_image_alt( $logo, $name ),
	);
};

foreach ( $groups as $index => $group ) {
	$rows = is_array( $group['items'] ) ? $group['items'] : array();
	$groups[ $index ]['people'] = array_values( array_filter( array_map( $pt_partner, $rows ) ) );
}

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[54vh]" data-section="pt-hero" data-dark-hero>
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="h-full w-full object-cover" fetchpriority="high">
			<div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/75 to-ink/30"></div>
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

	<nav class="sticky top-[100px] z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur" aria-label="<?php esc_attr_e( 'Mục lục trang', 'nongnghiepnhietdoi' ); ?>">
		<div class="mx-auto flex max-w-[1200px] gap-2 overflow-x-auto px-4 py-3">
			<?php foreach ( $groups as $group ) : ?>
				<?php if ( ! $group['label'] ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<a class="shrink-0 rounded-full bg-bone px-4 py-2 text-sm font-semibold text-ink transition-colors hover:bg-brand hover:text-white" href="#<?php echo esc_attr( $group['id'] ); ?>">
					<?php echo esc_html( $group['label'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</nav>

	<?php foreach ( $groups as $group ) : ?>
		<section id="<?php echo esc_attr( $group['id'] ); ?>" class="scroll-mt-36 py-14 md:scroll-mt-40 md:py-20 <?php echo esc_attr( $group['tone'] ); ?>">
			<div class="mx-auto max-w-[1200px] px-4">
				<div class="max-w-2xl" data-reveal>
					<?php if ( $group['label'] ) : ?>
						<h2 class="font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $group['label'] ); ?></h2>
					<?php endif; ?>
					<span class="mt-4 block h-1 w-16 origin-left rounded-full bg-brand" data-reveal-line></span>
					<?php if ( $group['intro'] ) : ?>
						<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $group['intro'] ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $group['people'] ) : ?>
					<?php
					$grid = 'mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3';
					if ( 'wide' === $group['style'] ) {
						$grid = 'mt-10 grid gap-4 md:grid-cols-2';
					}
					?>
					<div class="<?php echo esc_attr( $grid ); ?>" data-reveal-stagger>
						<?php foreach ( $group['people'] as $partner ) : ?>
							<div class="h-full">
								<?php
								$tag   = $partner['url'] ? 'a' : 'article';
								$attrs = $partner['url'] ? ' href="' . esc_url( $partner['url'] ) . '" target="_blank" rel="noopener"' : '';
								$wide  = 'tiles' !== $group['style'];
								$layout = $wide ? 'flex-row items-center gap-5 text-left' : 'flex-col items-center justify-center px-4 py-8 text-center';
								?>
								<<?php echo esc_attr( $tag ); ?> class="pt-tile flex h-full rounded-[28px] border border-slate-200 bg-white shadow-sm hover:border-brand/40 hover:shadow-md <?php echo esc_attr( $layout ); ?> <?php echo $wide ? 'p-5' : 'p-6'; ?>"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
									<span class="pt-mark relative grid h-16 w-16 shrink-0 place-items-center">
										<svg class="pt-orbit absolute inset-0 h-full w-full text-brand/70" viewBox="0 0 64 64" fill="none" aria-hidden="true">
											<circle cx="32" cy="32" r="29" stroke="currentColor" stroke-width="1.5" stroke-dasharray="8 10" />
										</svg>
										<span class="relative grid h-12 w-12 place-items-center overflow-hidden rounded-2xl bg-brand/10 text-brand">
											<?php if ( $partner['src'] ) : ?>
												<img src="<?php echo esc_url( $partner['src'] ); ?>" alt="<?php echo esc_attr( $partner['alt'] ); ?>" class="h-full w-full object-contain p-1.5">
											<?php else : ?>
												<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M4 12h16M12 4c2.2 2.4 3.3 5.1 3.3 8S14.2 17.6 12 20c-2.2-2.4-3.3-5.1-3.3-8S9.8 6.4 12 4Z"/></svg>
											<?php endif; ?>
										</span>
									</span>
									<span class="min-w-0 <?php echo $wide ? '' : 'mt-4'; ?>">
										<?php if ( $partner['name'] ) : ?>
											<span class="block font-sans text-lg font-bold leading-snug text-ink"><?php echo esc_html( $partner['name'] ); ?></span>
										<?php endif; ?>
										<?php if ( $partner['note'] ) : ?>
											<span class="mt-1 block text-sm leading-relaxed text-slate-600"><?php echo esc_html( $partner['note'] ); ?></span>
										<?php endif; ?>
									</span>
								</<?php echo esc_attr( $tag ); ?>>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endforeach; ?>
</main>

<?php
get_footer();
