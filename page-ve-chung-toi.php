<?php
/**
 * Template Name: Về chúng tôi
 * Trang Về chúng tôi (slug: ve-chung-toi).
 *
 * Nội dung sửa trong hộp Meta "Về chúng tôi - Nội dung trang" khi sửa trang này.
 *
 * @package NongNghiepNhietDoi
 */

$page_id = get_queried_object_id();

$hero_eyebrow = (string) nongnghiepnhietdoi_about_field( 'vc_hero_eyebrow', $page_id );
$hero_title   = (string) nongnghiepnhietdoi_about_field( 'vc_hero_title', $page_id );
$hero_lead    = (string) nongnghiepnhietdoi_about_field( 'vc_hero_lead', $page_id );
$hero_image   = get_the_post_thumbnail_url( $page_id, 'full' );
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/hero-field.jpg';
}

$overview_label   = (string) nongnghiepnhietdoi_about_field( 'vc_overview_label', $page_id );
$overview_title   = (string) nongnghiepnhietdoi_about_field( 'vc_overview_title', $page_id );
$overview_content = (string) nongnghiepnhietdoi_about_field( 'vc_overview_content', $page_id );
$overview_image   = nongnghiepnhietdoi_about_field( 'vc_overview_image', $page_id );
$overview_src     = nongnghiepnhietdoi_about_image_url( $overview_image );
$overview_alt     = nongnghiepnhietdoi_about_image_alt( $overview_image, $overview_title );
if ( ! $overview_src ) {
	$overview_src = NONGNGHIEPNHIETDOI_URI . '/assets/images/about-field.jpg';
	$overview_alt = 'Cánh đồng trong mạng lưới đồng hành của VARC';
}
$pillars = nongnghiepnhietdoi_about_field( 'vc_pillars', $page_id );
$pillars = is_array( $pillars ) ? $pillars : array();

$org_label = (string) nongnghiepnhietdoi_about_field( 'vc_org_label', $page_id );
$org_title = (string) nongnghiepnhietdoi_about_field( 'vc_org_title', $page_id );
$org_intro = (string) nongnghiepnhietdoi_about_field( 'vc_org_intro', $page_id );
$units     = nongnghiepnhietdoi_about_field( 'vc_units', $page_id );
$units     = is_array( $units ) ? $units : array();

$board_label = (string) nongnghiepnhietdoi_about_field( 'vc_board_label', $page_id );
$board_intro = (string) nongnghiepnhietdoi_about_field( 'vc_board_intro', $page_id );
$advisors    = nongnghiepnhietdoi_about_field( 'vc_advisors', $page_id );
$advisors    = is_array( $advisors ) ? $advisors : array();

$network_label = (string) nongnghiepnhietdoi_about_field( 'vc_network_label', $page_id );
$network_title = (string) nongnghiepnhietdoi_about_field( 'vc_network_title', $page_id );
$network_intro = (string) nongnghiepnhietdoi_about_field( 'vc_network_intro', $page_id );
$links         = nongnghiepnhietdoi_about_field( 'vc_links', $page_id );
$links         = is_array( $links ) ? $links : array();

$gov_label  = (string) nongnghiepnhietdoi_about_field( 'vc_gov_label', $page_id );
$gov_title  = (string) nongnghiepnhietdoi_about_field( 'vc_gov_title', $page_id );
$gov_intro  = (string) nongnghiepnhietdoi_about_field( 'vc_gov_intro', $page_id );
$principles = nongnghiepnhietdoi_about_field( 'vc_principles', $page_id );
$principles = is_array( $principles ) ? $principles : array();
$documents  = nongnghiepnhietdoi_about_field( 'vc_documents', $page_id );
$documents  = is_array( $documents ) ? $documents : array();

$cta_title = (string) nongnghiepnhietdoi_about_field( 'vc_cta_title', $page_id );
$cta_text  = (string) nongnghiepnhietdoi_about_field( 'vc_cta_text', $page_id );
$cta_label = (string) nongnghiepnhietdoi_about_field( 'vc_cta_button_label', $page_id );
$cta_url   = (string) nongnghiepnhietdoi_about_field( 'vc_cta_button_url', $page_id );

$nav = array(
	array(
		'id'    => 'tong-quan',
		'label' => $overview_label,
	),
	array(
		'id'    => 'to-chuc',
		'label' => $org_label,
	),
	array(
		'id'    => 'mang-luoi',
		'label' => $network_label,
	),
	array(
		'id'    => 'minh-bach',
		'label' => $gov_label,
	),
);

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[56vh]" data-section="vc-hero" data-dark-hero>
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
			<?php foreach ( $nav as $item ) : ?>
				<?php if ( ! $item['label'] ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<a class="shrink-0 rounded-full bg-bone px-4 py-2 text-sm font-semibold text-ink transition-colors hover:bg-brand hover:text-white" href="#<?php echo esc_attr( $item['id'] ); ?>">
					<?php echo esc_html( $item['label'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</nav>

	<section id="tong-quan" class="scroll-mt-36 bg-white py-14 md:scroll-mt-40 md:py-20" data-section="vc-overview">
		<div class="mx-auto grid max-w-[1200px] items-center gap-8 px-4 lg:grid-cols-2 lg:gap-14">
			<div class="order-2 overflow-hidden rounded-3xl lg:order-1" data-reveal="image">
				<div data-reveal-frame>
					<img src="<?php echo esc_url( $overview_src ); ?>" alt="<?php echo esc_attr( $overview_alt ); ?>" class="aspect-[4/3] w-full object-cover" width="1400" height="1050">
				</div>
			</div>
			<div class="order-1 lg:order-2" data-reveal="right">
				<?php if ( $overview_label ) : ?>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $overview_label ); ?></p>
				<?php endif; ?>
				<?php if ( $overview_title ) : ?>
					<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $overview_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $overview_content ) : ?>
					<div class="mt-4 space-y-4 text-base leading-relaxed text-slate-600 [&_p]:mb-4 [&_p:last-child]:mb-0">
						<?php echo wp_kses_post( $overview_content ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $pillars ) : ?>
			<div class="mx-auto mt-10 grid max-w-[1200px] gap-4 px-4 md:mt-14 md:grid-cols-3" data-reveal-stagger>
				<?php foreach ( $pillars as $pillar ) : ?>
					<?php
					$pillar_title = isset( $pillar['title'] ) ? (string) $pillar['title'] : '';
					$pillar_text  = isset( $pillar['text'] ) ? (string) $pillar['text'] : '';
					if ( '' === $pillar_title && '' === $pillar_text ) {
						continue;
					}
					?>
					<article class="rounded-3xl bg-bone p-6 md:p-7">
						<div class="h-1.5 w-10 rounded-full bg-sun"></div>
						<?php if ( $pillar_title ) : ?>
							<h3 class="mt-4 font-sans text-xl font-bold text-ink"><?php echo esc_html( $pillar_title ); ?></h3>
						<?php endif; ?>
						<?php if ( $pillar_text ) : ?>
							<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $pillar_text ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>

	<section id="to-chuc" class="scroll-mt-36 bg-bone py-14 md:scroll-mt-40 md:py-20" data-section="vc-org">
		<div class="mx-auto max-w-[1200px] px-4">
			<div class="max-w-2xl" data-reveal>
				<?php if ( $org_label ) : ?>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $org_label ); ?></p>
				<?php endif; ?>
				<?php if ( $org_title ) : ?>
					<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $org_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $org_intro ) : ?>
					<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $org_intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $units ) : ?>
				<div class="mt-8 grid gap-4 sm:grid-cols-2" data-reveal-stagger>
					<?php foreach ( $units as $index => $unit ) : ?>
						<?php
						$unit_title = isset( $unit['title'] ) ? (string) $unit['title'] : '';
						$unit_text  = isset( $unit['text'] ) ? (string) $unit['text'] : '';
						$unit_bg    = nongnghiepnhietdoi_about_card_image( $unit['image'] ?? null, 'units', (int) $index );
						if ( '' === $unit_title && '' === $unit_text ) {
							continue;
						}
						?>
						<article class="vc-media-card group">
							<?php if ( $unit_bg ) : ?>
								<img class="vc-media-card__bg" src="<?php echo esc_url( $unit_bg ); ?>" alt="" loading="lazy" decoding="async">
							<?php endif; ?>
							<span class="vc-media-card__scrim" aria-hidden="true"></span>
							<div class="vc-media-card__body">
								<p class="vc-media-card__index"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
								<?php if ( $unit_title ) : ?>
									<h3 class="vc-media-card__title"><?php echo esc_html( $unit_title ); ?></h3>
								<?php endif; ?>
								<?php if ( $unit_text ) : ?>
									<p class="vc-media-card__text"><?php echo esc_html( $unit_text ); ?></p>
								<?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $board_label || $advisors ) : ?>
				<div class="mt-14 md:mt-16">
					<div class="max-w-2xl" data-reveal>
						<?php if ( $board_label ) : ?>
							<h3 class="font-sans text-2xl font-bold tracking-tight text-ink md:text-3xl"><?php echo esc_html( $board_label ); ?></h3>
						<?php endif; ?>
						<?php if ( $board_intro ) : ?>
							<p class="mt-3 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $board_intro ); ?></p>
						<?php endif; ?>
					</div>

					<?php if ( $advisors ) : ?>
						<div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
							<?php foreach ( $advisors as $index => $advisor ) : ?>
								<?php
								$name  = isset( $advisor['name'] ) ? (string) $advisor['name'] : '';
								$role  = isset( $advisor['role'] ) ? (string) $advisor['role'] : '';
								$bio   = isset( $advisor['bio'] ) ? (string) $advisor['bio'] : '';
								$photo = $advisor['photo'] ?? null;
								$src   = nongnghiepnhietdoi_about_image_url( $photo );
								$alt   = nongnghiepnhietdoi_about_image_alt( $photo, $name );
								$bg    = nongnghiepnhietdoi_about_card_image( $advisor['image'] ?? null, 'advisors', (int) $index );
								if ( '' === $name && '' === $role && '' === $bio ) {
									continue;
								}
								$initial = $name ? mb_substr( $name, 0, 1 ) : '•';
								?>
								<article class="vc-media-card vc-media-card--advisor group">
									<?php if ( $bg ) : ?>
										<img class="vc-media-card__bg" src="<?php echo esc_url( $bg ); ?>" alt="" loading="lazy" decoding="async">
									<?php endif; ?>
									<span class="vc-media-card__scrim" aria-hidden="true"></span>
									<div class="vc-media-card__body">
										<?php if ( $src ) : ?>
											<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="vc-media-card__avatar" width="64" height="64">
										<?php else : ?>
											<span class="vc-media-card__avatar vc-media-card__avatar--fallback" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
										<?php endif; ?>
										<?php if ( $name ) : ?>
											<h4 class="vc-media-card__title"><?php echo esc_html( $name ); ?></h4>
										<?php endif; ?>
										<?php if ( $role ) : ?>
											<p class="vc-media-card__role"><?php echo esc_html( $role ); ?></p>
										<?php endif; ?>
										<?php if ( $bio ) : ?>
											<p class="vc-media-card__text"><?php echo esc_html( $bio ); ?></p>
										<?php endif; ?>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="mang-luoi" class="scroll-mt-36 bg-ink py-14 text-white md:scroll-mt-40 md:py-20" data-section="vc-network">
		<div class="mx-auto max-w-[1200px] px-4">
			<div class="max-w-2xl" data-reveal>
				<?php if ( $network_label ) : ?>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun"><?php echo esc_html( $network_label ); ?></p>
				<?php endif; ?>
				<?php if ( $network_title ) : ?>
					<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight md:text-4xl"><?php echo esc_html( $network_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $network_intro ) : ?>
					<p class="mt-4 text-base leading-relaxed text-white/75"><?php echo wp_kses_post( $network_intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $links ) : ?>
				<div class="mt-8 grid gap-4 sm:grid-cols-2" data-reveal-stagger>
					<?php foreach ( $links as $index => $link ) : ?>
						<?php
						$name = isset( $link['name'] ) ? (string) $link['name'] : '';
						$text = isset( $link['text'] ) ? (string) $link['text'] : '';
						$url  = isset( $link['url'] ) ? (string) $link['url'] : '';
						$logo = nongnghiepnhietdoi_about_image_url( $link['logo'] ?? null );
						$alt  = nongnghiepnhietdoi_about_image_alt( $link['logo'] ?? null, $name );
						$bg   = nongnghiepnhietdoi_about_card_image( $link['image'] ?? null, 'links', (int) $index );
						if ( '' === $name && '' === $text ) {
							continue;
						}
						$tag = $url ? 'a' : 'article';
						?>
						<<?php echo esc_attr( $tag ); ?>
							class="vc-media-card vc-media-card--network group<?php echo $url ? ' vc-media-card--link' : ''; ?>"
							<?php echo $url ? ' href="' . esc_url( $url ) . '"' : ''; ?>
						>
							<?php if ( $bg ) : ?>
								<img class="vc-media-card__bg" src="<?php echo esc_url( $bg ); ?>" alt="" loading="lazy" decoding="async">
							<?php endif; ?>
							<span class="vc-media-card__scrim" aria-hidden="true"></span>
							<div class="vc-media-card__body vc-media-card__body--row">
								<?php if ( $logo ) : ?>
									<span class="vc-media-card__logo">
										<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
									</span>
								<?php else : ?>
									<span class="vc-media-card__dot" aria-hidden="true"></span>
								<?php endif; ?>
								<span class="min-w-0">
									<?php if ( $name ) : ?>
										<span class="vc-media-card__title"><?php echo esc_html( $name ); ?></span>
									<?php endif; ?>
									<?php if ( $text ) : ?>
										<span class="vc-media-card__text"><?php echo esc_html( $text ); ?></span>
									<?php endif; ?>
								</span>
							</div>
						</<?php echo esc_attr( $tag ); ?>>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="minh-bach" class="scroll-mt-36 bg-white py-14 md:scroll-mt-40 md:py-20" data-section="vc-governance">
		<div class="mx-auto grid max-w-[1200px] gap-10 px-4 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:gap-16">
			<div data-reveal>
				<?php if ( $gov_label ) : ?>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $gov_label ); ?></p>
				<?php endif; ?>
				<?php if ( $gov_title ) : ?>
					<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $gov_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $gov_intro ) : ?>
					<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $gov_intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $principles ) : ?>
				<ol class="space-y-4" data-reveal-stagger>
					<?php foreach ( $principles as $index => $principle ) : ?>
						<?php
						$principle_title = isset( $principle['title'] ) ? (string) $principle['title'] : '';
						$principle_text  = isset( $principle['text'] ) ? (string) $principle['text'] : '';
						if ( '' === $principle_title && '' === $principle_text ) {
							continue;
						}
						?>
						<li class="flex gap-4 rounded-3xl bg-bone p-5 md:p-6">
							<span class="font-sans text-sm font-bold text-brand"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span>
								<?php if ( $principle_title ) : ?>
									<span class="block font-sans text-lg font-bold text-ink"><?php echo esc_html( $principle_title ); ?></span>
								<?php endif; ?>
								<?php if ( $principle_text ) : ?>
									<span class="mt-1 block text-sm leading-relaxed text-slate-600"><?php echo esc_html( $principle_text ); ?></span>
								<?php endif; ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php endif; ?>
		</div>

		<?php
		$public_docs = array();
		foreach ( $documents as $document ) {
			$title = isset( $document['title'] ) ? trim( (string) $document['title'] ) : '';
			$file  = ( isset( $document['file'] ) && is_array( $document['file'] ) ) ? $document['file'] : array();
			$url   = ! empty( $file['url'] ) ? (string) $file['url'] : '';
			if ( '' === $title && '' === $url ) {
				continue;
			}
			$public_docs[] = array(
				'title' => $title ? $title : __( 'Tài liệu', 'nongnghiepnhietdoi' ),
				'note'  => isset( $document['note'] ) ? (string) $document['note'] : '',
				'url'   => $url,
			);
		}
		?>
		<?php if ( $public_docs ) : ?>
			<div class="mx-auto mt-12 max-w-[1200px] px-4 md:mt-16">
				<h3 class="font-sans text-xl font-bold text-ink"><?php esc_html_e( 'Tài liệu công khai', 'nongnghiepnhietdoi' ); ?></h3>
				<ul class="mt-5 grid gap-4 sm:grid-cols-2" data-reveal-stagger>
					<?php foreach ( $public_docs as $doc ) : ?>
						<li>
							<?php if ( $doc['url'] ) : ?>
								<a class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white px-5 py-4 transition hover:border-brand" href="<?php echo esc_url( $doc['url'] ); ?>" target="_blank" rel="noopener">
									<span>
										<span class="block font-semibold text-ink"><?php echo esc_html( $doc['title'] ); ?></span>
										<?php if ( $doc['note'] ) : ?>
											<span class="mt-1 block text-sm text-slate-500"><?php echo esc_html( $doc['note'] ); ?></span>
										<?php endif; ?>
									</span>
									<span class="shrink-0 text-sm font-semibold text-brand"><?php esc_html_e( 'Tải về', 'nongnghiepnhietdoi' ); ?></span>
								</a>
							<?php else : ?>
								<div class="rounded-2xl border border-slate-200 px-5 py-4">
									<p class="font-semibold text-ink"><?php echo esc_html( $doc['title'] ); ?></p>
									<?php if ( $doc['note'] ) : ?>
										<p class="mt-1 text-sm text-slate-500"><?php echo esc_html( $doc['note'] ); ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</section>

	<?php if ( $cta_title || $cta_text ) : ?>
		<section class="bg-gradient-to-r from-brand-900 to-brand text-white" data-section="vc-cta">
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
