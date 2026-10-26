<?php
/**
 * Template Name: Liên hệ
 * Trang Liên hệ (slug: lien-he).
 *
 * Nội dung trang sửa trong hộp Meta. Địa chỉ / liên hệ lấy từ Cài đặt chung.
 *
 * @package NongNghiepNhietDoi
 */

$page_id    = get_queried_object_id();
$short_name = (string) nongnghiepnhietdoi_option( 'site_short_name' );
$company    = (string) nongnghiepnhietdoi_option( 'site_company_name' );
$about      = (string) nongnghiepnhietdoi_option( 'site_about' );
$address    = (string) nongnghiepnhietdoi_option( 'contact_address' );
$phone      = (string) nongnghiepnhietdoi_option( 'contact_phone' );
$email      = (string) nongnghiepnhietdoi_option( 'contact_email' );
$hours      = (string) nongnghiepnhietdoi_option( 'contact_hours' );
$logo_id    = (int) nongnghiepnhietdoi_option( 'site_logo' );
$map_embed  = (string) nongnghiepnhietdoi_option( 'contact_map' );
$socials    = nongnghiepnhietdoi_socials();
$phone_tel  = $phone ? preg_replace( '/[^0-9+]/', '', $phone ) : '';
$hero_image = get_the_post_thumbnail_url( $page_id, 'full' );

$hero_eyebrow = (string) nongnghiepnhietdoi_contact_field( 'lh_hero_eyebrow', $page_id );
$hero_title   = (string) nongnghiepnhietdoi_contact_field( 'lh_hero_title', $page_id );
$hero_lead    = (string) nongnghiepnhietdoi_contact_field( 'lh_hero_lead', $page_id );
$info_eyebrow = (string) nongnghiepnhietdoi_contact_field( 'lh_info_eyebrow', $page_id );
$info_title   = (string) nongnghiepnhietdoi_contact_field( 'lh_info_title', $page_id );
$form_intro   = (string) nongnghiepnhietdoi_contact_field( 'lh_form_intro', $page_id );

if ( ! $short_name ) {
	$short_name = 'TARCC';
}
if ( ! $hero_eyebrow ) {
	$hero_eyebrow = $short_name;
}
if ( ! $hero_title ) {
	$hero_title = 'Liên hệ';
}
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/hero-field.jpg';
}

$lh_fmt = static function ( $text, $insert ) {
	if ( false !== strpos( $text, '%s' ) ) {
		return sprintf( $text, $insert );
	}
	return $text;
};

$contact_rows = array();
if ( $address ) {
	$contact_rows[] = array(
		'label' => 'Địa chỉ',
		'value' => $address,
		'icon'  => 'pin',
	);
}
if ( $phone ) {
	$contact_rows[] = array(
		'label' => 'Điện thoại',
		'value' => $phone,
		'href'  => 'tel:' . $phone_tel,
		'icon'  => 'phone',
	);
}
if ( $email ) {
	$contact_rows[] = array(
		'label' => 'Email',
		'value' => $email,
		'href'  => 'mailto:' . $email,
		'icon'  => 'mail',
	);
}
if ( $hours ) {
	$contact_rows[] = array(
		'label' => 'Giờ làm việc',
		'value' => $hours,
		'icon'  => 'clock',
	);
}

$lh_icon = static function ( $name ) {
	$icons = array(
		'pin'   => '<path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.2"/>',
		'phone' => '<path d="M7.2 3.8h2.1l1.2 3-1.6 1a12.2 12.2 0 0 0 5.3 5.3l1-1.6 3 1.2v2.1c0 .7-.5 1.3-1.2 1.4A14.6 14.6 0 0 1 5.8 5c.1-.7.7-1.2 1.4-1.2Z"/>',
		'mail'  => '<rect x="3.5" y="5.5" width="17" height="13" rx="2"/><path d="m4.5 7 7.5 6L19.5 7"/>',
		'clock' => '<circle cx="12" cy="12" r="8"/><path d="M12 8v4.5l3 1.5"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return;
	}
	echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icons[ $name ] . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
};

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-section="lh-hero" data-dark-hero>
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
			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun" data-reveal><?php echo esc_html( $hero_eyebrow ); ?></p>
			<h1 class="mt-3 font-sans text-4xl font-bold leading-tight tracking-tight md:text-5xl" data-reveal><?php echo esc_html( $hero_title ); ?></h1>
			<?php if ( $hero_lead ) : ?>
				<p class="mt-4 max-w-2xl text-base leading-relaxed text-white/85 md:text-lg" data-reveal><?php echo esc_html( $lh_fmt( $hero_lead, $company ? $company : $short_name ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="bg-bone py-14 md:py-20" data-section="lien-he">
		<div class="mx-auto grid max-w-[1200px] items-start gap-8 px-4 lg:grid-cols-2 lg:gap-10">

			<article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 md:p-8" data-reveal="left">
				<?php if ( $info_eyebrow ) : ?>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $info_eyebrow ); ?></p>
				<?php endif; ?>
				<?php if ( $info_title ) : ?>
					<h2 class="mt-2 font-sans text-2xl font-bold tracking-tight text-ink md:text-3xl"><?php echo esc_html( $info_title ); ?></h2>
				<?php endif; ?>

				<div class="mt-6 flex items-center gap-4">
					<?php if ( $logo_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$logo_id,
							'medium',
							false,
							array(
								'class' => 'h-20 w-20 shrink-0 rounded-2xl bg-bone object-contain p-1.5',
								'alt'   => $company ? $company : $short_name,
							)
						);
						?>
					<?php else : ?>
						<img src="<?php echo esc_url( NONGNGHIEPNHIETDOI_URI . '/assets/images/logo-varc.png' ); ?>" alt="" class="h-20 w-20 shrink-0 rounded-2xl bg-bone object-contain p-1.5" width="80" height="80">
					<?php endif; ?>
					<div>
						<?php if ( $short_name ) : ?>
							<p class="text-xs font-bold uppercase tracking-[0.16em] text-brand"><?php echo esc_html( $short_name ); ?></p>
						<?php endif; ?>
						<?php if ( $company ) : ?>
							<p class="mt-1 font-sans text-lg font-bold uppercase leading-snug tracking-wide text-ink"><?php echo esc_html( $company ); ?></p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $about ) : ?>
					<p class="mt-5 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $about ); ?></p>
				<?php endif; ?>

				<?php if ( $contact_rows ) : ?>
					<ul class="mt-6 space-y-3 border-t border-slate-100 pt-6">
						<?php foreach ( $contact_rows as $row ) : ?>
							<li class="flex gap-3">
								<span class="mt-0.5 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand/10 text-brand [&>svg]:h-5 [&>svg]:w-5">
									<?php $lh_icon( $row['icon'] ); ?>
								</span>
								<span class="min-w-0">
									<span class="block text-xs font-semibold uppercase tracking-[0.12em] text-slate-400"><?php echo esc_html( $row['label'] ); ?></span>
									<?php if ( ! empty( $row['href'] ) ) : ?>
										<a class="mt-0.5 block break-all text-sm font-semibold text-ink hover:text-brand" href="<?php echo esc_url( $row['href'] ); ?>"><?php echo esc_html( $row['value'] ); ?></a>
									<?php else : ?>
										<span class="mt-0.5 block text-sm font-semibold leading-relaxed text-ink"><?php echo nl2br( esc_html( $row['value'] ) ); ?></span>
									<?php endif; ?>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $socials ) : ?>
					<ul class="mt-6 flex flex-wrap gap-2">
						<?php foreach ( $socials as $key => $social ) : ?>
							<li>
								<a class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-bone text-ink hover:bg-brand hover:text-white" href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
									<span class="inline-flex h-4 w-4 [&>svg]:h-full [&>svg]:w-full"><?php nongnghiepnhietdoi_social_icon( $key ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</article>

			<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8" data-reveal="right">
				<?php if ( $form_intro ) : ?>
					<p class="text-sm text-slate-500"><?php echo esc_html( $lh_fmt( $form_intro, $short_name ) ); ?></p>
				<?php endif; ?>
				<div class="lh-cf7 mt-6">
					<?php
					if ( function_exists( 'nongnghiepnhietdoi_cf7_render' ) ) {
						nongnghiepnhietdoi_cf7_render( 'contact' );
					}
					?>
				</div>
			</div>
		</div>

		<?php if ( $map_embed ) : ?>
			<div class="mx-auto mt-10 max-w-[1200px] px-4 md:mt-14">
				<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm [&_iframe]:block [&_iframe]:h-[320px] [&_iframe]:w-full [&_iframe]:md:h-[420px]" data-reveal>
					<?php
					echo wp_kses(
						$map_embed,
						array(
							'iframe' => array(
								'src'             => true,
								'width'           => true,
								'height'          => true,
								'style'           => true,
								'loading'         => true,
								'allowfullscreen' => true,
								'referrerpolicy'  => true,
								'frameborder'     => true,
								'title'           => true,
							),
						)
					);
					?>
				</div>
			</div>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer();
