<?php
/**
 * Template Name: Hội đồng Cố vấn & Ban Điều hành
 * Trang Hội đồng Cố vấn & Ban Điều hành (slug: hoi-dong-co-van-ban-dieu-hanh).
 *
 * Sửa tên, chức danh, giới thiệu và ảnh trong hộp Meta khi sửa trang này.
 *
 * @package NongNghiepNhietDoi
 */

$page_id = get_queried_object_id();

$hero_eyebrow = (string) nongnghiepnhietdoi_board_field( 'hd_hero_eyebrow', $page_id );
$hero_title   = (string) nongnghiepnhietdoi_board_field( 'hd_hero_title', $page_id );
$hero_lead    = (string) nongnghiepnhietdoi_board_field( 'hd_hero_lead', $page_id );
$hero_image   = get_the_post_thumbnail_url( $page_id, 'full' );
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/hero-field.jpg';
}

$advisors_label = (string) nongnghiepnhietdoi_board_field( 'hd_advisors_label', $page_id );
$advisors_intro = (string) nongnghiepnhietdoi_board_field( 'hd_advisors_intro', $page_id );
$advisors       = nongnghiepnhietdoi_board_field( 'hd_advisors', $page_id );
$advisors       = is_array( $advisors ) ? $advisors : array();

$board_label = (string) nongnghiepnhietdoi_board_field( 'hd_board_label', $page_id );
$board_intro = (string) nongnghiepnhietdoi_board_field( 'hd_board_intro', $page_id );
$board       = nongnghiepnhietdoi_board_field( 'hd_board', $page_id );
$board       = is_array( $board ) ? $board : array();

/**
 * Chuẩn hóa một thành viên từ repeater.
 *
 * @param mixed $row Dòng repeater.
 * @return array{name:string,role:string,bio:string,src:string,alt:string,initial:string}|null
 */
$hd_person = static function ( $row ) {
	if ( ! is_array( $row ) ) {
		return null;
	}
	$name = isset( $row['name'] ) ? trim( (string) $row['name'] ) : '';
	$role = isset( $row['role'] ) ? trim( (string) $row['role'] ) : '';
	$bio  = isset( $row['bio'] ) ? trim( (string) $row['bio'] ) : '';
	if ( '' === $name && '' === $role && '' === $bio ) {
		return null;
	}
	$photo = $row['photo'] ?? null;
	return array(
		'name'    => $name,
		'role'    => $role,
		'bio'     => $bio,
		'src'     => nongnghiepnhietdoi_about_image_url( $photo ),
		'alt'     => nongnghiepnhietdoi_about_image_alt( $photo, $name ),
		'initial' => nongnghiepnhietdoi_board_initial( $name, isset( $row['monogram'] ) ? (string) $row['monogram'] : '' ),
	);
};

$advisor_people = array_values( array_filter( array_map( $hd_person, $advisors ) ) );
$board_people   = array_values( array_filter( array_map( $hd_person, $board ) ) );
$lead           = $board_people ? $board_people[0] : null;
$deputies       = $board_people ? array_slice( $board_people, 1 ) : array();

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[56vh]" data-section="hd-hero" data-dark-hero>
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

	<nav class="sticky top-[76px] z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur sm:top-[88px]" aria-label="<?php esc_attr_e( 'Mục lục trang', 'nongnghiepnhietdoi' ); ?>">
		<div class="mx-auto flex max-w-[1200px] gap-2 overflow-x-auto px-4 py-3">
			<?php if ( $advisors_label ) : ?>
				<a class="shrink-0 rounded-full bg-bone px-4 py-2 text-sm font-semibold text-ink transition-colors hover:bg-brand hover:text-white" href="#hoi-dong"><?php echo esc_html( $advisors_label ); ?></a>
			<?php endif; ?>
			<?php if ( $board_label ) : ?>
				<a class="shrink-0 rounded-full bg-bone px-4 py-2 text-sm font-semibold text-ink transition-colors hover:bg-brand hover:text-white" href="#ban-dieu-hanh"><?php echo esc_html( $board_label ); ?></a>
			<?php endif; ?>
		</div>
	</nav>

	<section id="hoi-dong" class="scroll-mt-36 bg-bone py-14 md:scroll-mt-40 md:py-20" data-section="hd-advisors">
		<div class="mx-auto max-w-[1200px] px-4">
			<div class="max-w-2xl" data-reveal>
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php esc_html_e( 'Phản biện chuyên môn', 'nongnghiepnhietdoi' ); ?></p>
				<?php if ( $advisors_label ) : ?>
					<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight text-ink md:text-4xl"><?php echo esc_html( $advisors_label ); ?></h2>
				<?php endif; ?>
				<span class="mt-4 block h-1 w-16 origin-left rounded-full bg-brand" data-reveal-line></span>
				<?php if ( $advisors_intro ) : ?>
					<p class="mt-4 text-base leading-relaxed text-slate-600"><?php echo wp_kses_post( $advisors_intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $advisor_people ) : ?>
				<div class="mt-10 grid gap-5 md:grid-cols-3" data-reveal-stagger>
					<?php foreach ( $advisor_people as $index => $person ) : ?>
						<div class="h-full">
						<article class="hd-card relative flex h-full flex-col overflow-hidden rounded-[28px] bg-white p-6 shadow-sm ring-1 ring-slate-100">
							<div class="flex items-start justify-between gap-4">
								<div class="hd-avatar" aria-hidden="<?php echo $person['src'] ? 'false' : 'true'; ?>">
									<span class="hd-ring"></span>
									<span class="hd-face">
										<?php if ( $person['src'] ) : ?>
											<img src="<?php echo esc_url( $person['src'] ); ?>" alt="<?php echo esc_attr( $person['alt'] ); ?>">
										<?php else : ?>
											<?php echo esc_html( $person['initial'] ); ?>
										<?php endif; ?>
									</span>
								</div>
								<span class="font-sans text-sm font-bold tracking-[0.16em] text-sun"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							</div>
							<?php if ( $person['name'] ) : ?>
								<h3 class="mt-6 font-sans text-xl font-bold leading-snug text-ink"><?php echo esc_html( $person['name'] ); ?></h3>
							<?php endif; ?>
							<?php if ( $person['role'] ) : ?>
								<p class="mt-2 text-sm font-semibold leading-snug text-brand"><?php echo esc_html( $person['role'] ); ?></p>
							<?php endif; ?>
							<?php if ( $person['bio'] ) : ?>
								<p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $person['bio'] ); ?></p>
							<?php endif; ?>
							<span class="hd-card__bar mt-6 block h-1 w-full rounded-full bg-gradient-to-r from-brand to-sun"></span>
						</article>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="ban-dieu-hanh" class="scroll-mt-36 bg-ink py-14 text-white md:scroll-mt-40 md:py-20" data-section="hd-board">
		<div class="mx-auto max-w-[1200px] px-4">
			<div class="max-w-2xl" data-reveal>
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun"><?php esc_html_e( 'Vận hành', 'nongnghiepnhietdoi' ); ?></p>
				<?php if ( $board_label ) : ?>
					<h2 class="mt-3 font-sans text-3xl font-bold tracking-tight md:text-4xl"><?php echo esc_html( $board_label ); ?></h2>
				<?php endif; ?>
				<span class="mt-4 block h-1 w-16 origin-left rounded-full bg-sun" data-reveal-line></span>
				<?php if ( $board_intro ) : ?>
					<p class="mt-4 text-base leading-relaxed text-white/75"><?php echo wp_kses_post( $board_intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $lead ) : ?>
				<div class="mt-10" data-reveal="left">
				<article class="hd-card flex flex-col gap-6 rounded-[32px] bg-white/5 p-6 ring-1 ring-white/10 sm:flex-row sm:items-center sm:p-8">
					<div class="hd-avatar hd-avatar--dark shrink-0">
						<span class="hd-ring"></span>
						<span class="hd-face">
							<?php if ( $lead['src'] ) : ?>
								<img src="<?php echo esc_url( $lead['src'] ); ?>" alt="<?php echo esc_attr( $lead['alt'] ); ?>">
							<?php else : ?>
								<?php echo esc_html( $lead['initial'] ); ?>
							<?php endif; ?>
						</span>
					</div>
					<div>
						<p class="text-xs font-bold uppercase tracking-[0.16em] text-sun"><?php esc_html_e( 'Người đứng đầu', 'nongnghiepnhietdoi' ); ?></p>
						<?php if ( $lead['name'] ) : ?>
							<h3 class="mt-2 font-sans text-2xl font-bold md:text-3xl"><?php echo esc_html( $lead['name'] ); ?></h3>
						<?php endif; ?>
						<?php if ( $lead['role'] ) : ?>
							<p class="mt-2 text-sm font-semibold text-brand-200"><?php echo esc_html( $lead['role'] ); ?></p>
						<?php endif; ?>
						<?php if ( $lead['bio'] ) : ?>
							<p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/75 md:text-base"><?php echo esc_html( $lead['bio'] ); ?></p>
						<?php endif; ?>
					</div>
				</article>
				</div>
			<?php endif; ?>

			<?php if ( $deputies ) : ?>
				<div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
					<?php foreach ( $deputies as $person ) : ?>
						<div class="h-full">
						<article class="hd-card flex h-full flex-col rounded-[28px] bg-white p-5 text-ink">
							<div class="hd-avatar">
								<span class="hd-ring"></span>
								<span class="hd-face">
									<?php if ( $person['src'] ) : ?>
										<img src="<?php echo esc_url( $person['src'] ); ?>" alt="<?php echo esc_attr( $person['alt'] ); ?>">
									<?php else : ?>
										<?php echo esc_html( $person['initial'] ); ?>
									<?php endif; ?>
								</span>
							</div>
							<?php if ( $person['name'] ) : ?>
								<h3 class="mt-5 font-sans text-lg font-bold leading-snug"><?php echo esc_html( $person['name'] ); ?></h3>
							<?php endif; ?>
							<?php if ( $person['role'] ) : ?>
								<p class="mt-2 text-sm font-semibold leading-snug text-brand"><?php echo esc_html( $person['role'] ); ?></p>
							<?php endif; ?>
							<?php if ( $person['bio'] ) : ?>
								<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $person['bio'] ); ?></p>
							<?php endif; ?>
							<span class="hd-card__bar mt-6 block h-1 w-full rounded-full bg-gradient-to-r from-brand to-sun"></span>
						</article>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
