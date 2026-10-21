<?php
/**
 * Template Name: Hợp tác & dự án
 * Trang Hợp tác & dự án (slug: hop-tac-du-an).
 *
 * Thông tin pháp lý và liên hệ lấy từ Cài đặt Nông nghiệp nhiệt đới.
 *
 * @package NongNghiepNhietDoi
 */

$page_id     = get_queried_object_id();
$short_name  = (string) nongnghiepnhietdoi_option( 'site_short_name' );
$company     = (string) nongnghiepnhietdoi_option( 'site_company_name' );
$about       = (string) nongnghiepnhietdoi_option( 'site_about' );
$address     = (string) nongnghiepnhietdoi_option( 'contact_address' );
$phone       = (string) nongnghiepnhietdoi_option( 'contact_phone' );
$email       = (string) nongnghiepnhietdoi_option( 'contact_email' );
$hours       = (string) nongnghiepnhietdoi_option( 'contact_hours' );
$logo_id     = (int) nongnghiepnhietdoi_option( 'site_logo' );
$socials     = nongnghiepnhietdoi_socials();
$phone_tel   = $phone ? preg_replace( '/[^0-9+]/', '', $phone ) : '';
$subjects    = nongnghiepnhietdoi_partnership_subjects();
$audiences   = nongnghiepnhietdoi_partnership_audiences();
$hero_image  = get_the_post_thumbnail_url( $page_id, 'full' );
$hero_title  = 'Hợp tác & dự án';

if ( ! $short_name ) {
	$short_name = 'VARC';
}
if ( ! $hero_image ) {
	$hero_image = NONGNGHIEPNHIETDOI_URI . '/assets/images/hero-field.jpg';
}

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

/**
 * Icon nét cho trang hợp tác.
 *
 * @param string $name pin|phone|mail|clock|ngo|business|expert.
 * @return void
 */
$ht_icon = static function ( $name ) {
	$icons = array(
		'pin'      => '<path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.2"/>',
		'phone'    => '<path d="M7.2 3.8h2.1l1.2 3-1.6 1a12.2 12.2 0 0 0 5.3 5.3l1-1.6 3 1.2v2.1c0 .7-.5 1.3-1.2 1.4A14.6 14.6 0 0 1 5.8 5c.1-.7.7-1.2 1.4-1.2Z"/>',
		'mail'     => '<rect x="3.5" y="5.5" width="17" height="13" rx="2"/><path d="m4.5 7 7.5 6L19.5 7"/>',
		'clock'    => '<circle cx="12" cy="12" r="8"/><path d="M12 8v4.5l3 1.5"/>',
		'ngo'      => '<path d="M16.5 19.2v-1.2a3.2 3.2 0 0 0-3.2-3.2H7.2A3.2 3.2 0 0 0 4 18v1.2"/><circle cx="10.2" cy="8.2" r="2.7"/><path d="M20 19.2v-1a2.8 2.8 0 0 0-2.1-2.7"/><path d="M16.4 5.6a2.7 2.7 0 0 1 0 5.2"/>',
		'business' => '<path d="M4 20.5V6.5A1.5 1.5 0 0 1 5.5 5H13v15.5"/><path d="M13 9.5h5.5A1.5 1.5 0 0 1 20 11v9.5"/><path d="M7.5 8.5h2M7.5 12h2M7.5 15.5h2M16 13h1.5M16 16.5h1.5"/>',
		'expert'   => '<circle cx="12" cy="8" r="3"/><path d="M5.5 19.2a6.5 6.5 0 0 1 13 0"/><path d="M17.2 4.2 18.4 6l1.8.3-1.3 1.3.3 1.8-1.6-.8-1.6.8.3-1.8-1.3-1.3 1.8-.3Z"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return;
	}
	echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icons[ $name ] . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
};

get_header();
?>

<main id="main" class="site-main">

	<section class="relative flex min-h-[46vh] items-end overflow-hidden pt-24 md:min-h-[52vh]" data-section="ht-hero" data-dark-hero>
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
			<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sun" data-reveal><?php echo esc_html( $short_name ); ?></p>
			<h1 class="mt-3 max-w-3xl font-sans text-4xl font-bold leading-tight tracking-tight md:text-5xl" data-reveal><?php echo esc_html( $hero_title ); ?></h1>
			<p class="mt-4 max-w-2xl text-base leading-relaxed text-white/85 md:text-lg" data-reveal>
				<?php
				echo esc_html(
					sprintf(
						'Gửi hồ sơ năng lực, Call for Proposal hoặc đề xuất hợp tác tới %s.',
						$short_name
					)
				);
				?>
			</p>
		</div>
	</section>

	<section class="bg-bone py-14 md:py-20" data-section="ht-portal">
		<div class="mx-auto grid max-w-[1200px] items-start gap-8 px-4 lg:grid-cols-2 lg:gap-10">

			<article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 md:p-8" data-reveal="left">
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php esc_html_e( 'Đơn vị', 'nongnghiepnhietdoi' ); ?></p>
				<h2 class="mt-2 font-sans text-2xl font-bold tracking-tight text-ink md:text-3xl"><?php esc_html_e( 'Thông tin pháp lý & Liên hệ', 'nongnghiepnhietdoi' ); ?></h2>

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
							<p class="mt-1 font-sans text-lg font-bold leading-snug text-ink"><?php echo esc_html( $company ); ?></p>
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
									<?php $ht_icon( $row['icon'] ); ?>
								</span>
								<span class="min-w-0">
									<span class="block text-xs font-semibold uppercase tracking-[0.12em] text-slate-400"><?php echo esc_html( $row['label'] ); ?></span>
									<?php if ( ! empty( $row['href'] ) ) : ?>
										<a class="mt-0.5 block text-sm font-semibold text-ink hover:text-brand" href="<?php echo esc_url( $row['href'] ); ?>"><?php echo esc_html( $row['value'] ); ?></a>
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

			<div data-reveal="right">
				<p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand"><?php esc_html_e( 'Đối tác', 'nongnghiepnhietdoi' ); ?></p>
				<h2 class="mt-2 font-sans text-2xl font-bold tracking-tight text-ink md:text-3xl"><?php esc_html_e( 'Cổng đề xuất hợp tác', 'nongnghiepnhietdoi' ); ?></h2>
				<p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo esc_html( sprintf( 'Chọn nhóm phù hợp. Biểu mẫu bên dưới sẽ ghi nhận đề xuất gửi tới %s.', $short_name ) ); ?></p>

				<div class="mt-6 space-y-3">
					<?php foreach ( $audiences as $key => $audience ) : ?>
						<button
							type="button"
							class="ht-portal-card flex w-full items-start gap-4 rounded-3xl bg-white p-5 text-left shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-0.5 hover:ring-brand/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand [&.is-active]:bg-brand [&.is-active]:text-white [&.is-active]:ring-brand"
							data-ht-audience="<?php echo esc_attr( $key ); ?>"
							data-ht-subject-value="<?php echo esc_attr( $audience['subject'] ); ?>"
							aria-pressed="false"
						>
							<span class="ht-portal-icon inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand/10 text-brand [&>svg]:h-6 [&>svg]:w-6">
								<?php $ht_icon( $key ); ?>
							</span>
							<span>
								<span class="block font-sans text-lg font-bold"><?php echo esc_html( $audience['title'] ); ?></span>
								<span class="ht-portal-text mt-1 block text-sm leading-relaxed text-slate-600"><?php echo esc_html( $audience['text'] ); ?></span>
							</span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div id="gui-thong-tin" class="mx-auto mt-10 max-w-[1200px] scroll-mt-28 px-4 md:mt-14">
			<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8" data-reveal>
				<p class="text-sm text-slate-500">
					<?php
					echo esc_html(
						sprintf(
							'Yêu cầu nhận Hồ sơ năng lực hoặc gửi Call for Proposal tới %s.',
							$short_name
						)
					);
					?>
				</p>

				<form class="ht-proposal-form mt-6" method="post" action="" enctype="multipart/form-data" novalidate>
					<?php wp_nonce_field( 'nongnghiepnhietdoi_contact', 'nongnghiepnhietdoi_contact_nonce' ); ?>
					<input type="hidden" name="lx_form_source" value="partnership">
					<input type="hidden" name="lx_audience" value="" data-ht-audience-input>
					<div class="hidden" aria-hidden="true">
						<label>Website<input type="text" name="nongnghiepnhietdoi_website" tabindex="-1" autocomplete="off"></label>
					</div>

					<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
						<div>
							<label class="mb-2 block text-sm font-semibold text-ink" for="ht-name"><?php esc_html_e( 'Họ và tên', 'nongnghiepnhietdoi' ); ?> <span class="text-red-600">*</span></label>
							<input class="h-11 w-full rounded-md border border-slate-200 bg-white px-3 text-sm text-ink outline-none transition focus:border-brand focus:ring-2 focus:ring-brand/20" type="text" id="ht-name" name="lx_name" required autocomplete="name">
						</div>
						<div>
							<label class="mb-2 block text-sm font-semibold text-ink" for="ht-email"><?php esc_html_e( 'Email', 'nongnghiepnhietdoi' ); ?> <span class="text-red-600">*</span></label>
							<input class="h-11 w-full rounded-md border border-slate-200 bg-white px-3 text-sm text-ink outline-none transition focus:border-brand focus:ring-2 focus:ring-brand/20" type="email" id="ht-email" name="email" required autocomplete="email">
						</div>
						<div>
							<label class="mb-2 block text-sm font-semibold text-ink" for="ht-phone"><?php esc_html_e( 'Điện thoại', 'nongnghiepnhietdoi' ); ?></label>
							<input class="h-11 w-full rounded-md border border-slate-200 bg-white px-3 text-sm text-ink outline-none transition focus:border-brand focus:ring-2 focus:ring-brand/20" type="tel" id="ht-phone" name="phone" autocomplete="tel">
						</div>
						<div>
							<label class="mb-2 block text-sm font-semibold text-ink" for="ht-org"><?php esc_html_e( 'Đơn vị / Tổ chức', 'nongnghiepnhietdoi' ); ?></label>
							<input class="h-11 w-full rounded-md border border-slate-200 bg-white px-3 text-sm text-ink outline-none transition focus:border-brand focus:ring-2 focus:ring-brand/20" type="text" id="ht-org" name="organization" autocomplete="organization">
						</div>
					</div>

					<div class="mt-5">
						<label class="mb-2 block text-sm font-semibold text-ink" for="ht-subject"><?php esc_html_e( 'Tiêu đề', 'nongnghiepnhietdoi' ); ?></label>
						<select id="ht-subject" name="lx_subject" class="ht-select h-11 w-full appearance-none rounded-md border border-slate-200 bg-white px-3 pr-10 text-sm text-ink outline-none transition focus:border-brand focus:ring-2 focus:ring-brand/20" data-ht-subject>
							<?php foreach ( $subjects as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="mt-5">
						<label class="mb-2 block text-sm font-semibold text-ink" for="ht-message"><?php esc_html_e( 'Nội dung', 'nongnghiepnhietdoi' ); ?> <span class="text-red-600">*</span></label>
						<textarea id="ht-message" name="message" required class="min-h-[148px] w-full resize-y rounded-md border border-slate-200 bg-white px-3 py-3 text-sm text-ink outline-none transition focus:border-brand focus:ring-2 focus:ring-brand/20"></textarea>
					</div>

					<div class="mt-5">
						<label class="mb-2 block text-sm font-semibold text-ink" for="ht-file"><?php esc_html_e( 'Tệp đính kèm (PDF, DOC, ZIP ≤ 20MB)', 'nongnghiepnhietdoi' ); ?></label>
						<input id="ht-file" class="block w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border file:border-slate-300 file:bg-slate-50 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-ink" type="file" name="lx_attachment" accept=".pdf,.doc,.docx,.zip,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/zip">
					</div>

					<button type="submit" name="nongnghiepnhietdoi_contact_submit" value="1" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700 disabled:opacity-70">
						<span class="lx-submit-label"><?php esc_html_e( 'Gửi thông tin', 'nongnghiepnhietdoi' ); ?> <span aria-hidden="true">→</span></span>
						<span class="lx-submit-loading hidden"><?php esc_html_e( 'Đang gửi…', 'nongnghiepnhietdoi' ); ?></span>
					</button>
				</form>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
